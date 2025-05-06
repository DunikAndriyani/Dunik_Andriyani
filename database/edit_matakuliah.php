<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['kodemk'])) {
    $kodemk = $_GET['kodemk'];
    
    // Ambil data mata kuliah yang akan diedit
    $sql = "SELECT * FROM matakuliah WHERE kodemk = '$kodemk'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kodemk = $_POST['kodemk'];
    $nama = $_POST['nama'];
    $jumlah_sks = $_POST['jumlah_sks'];

    $sql = "UPDATE matakuliah SET nama = '$nama', jumlah_sks = $jumlah_sks WHERE kodemk = '$kodemk'";
    
    if ($conn->query($sql)) {
        header("Location: matakuliah.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Kuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Edit Mata Kuliah</h1>
    <form action="edit_matakuliah.php" method="post">
        <input type="hidden" name="kodemk" value="<?php echo $row['kodemk']; ?>">
        
        <div class="form-group">
            <label for="kodemk">Kode MK:</label>
            <input type="text" id="kodemk" value="<?php echo $row['kodemk']; ?>" disabled>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
        </div>
        <div class="form-group">
            <label for="jumlah_sks">Jumlah SKS:</label>
            <input type="number" id="jumlah_sks" name="jumlah_sks" min="1" max="6" value="<?php echo $row['jumlah_sks']; ?>" required>
        </div>
        
        <button type="submit">Simpan Perubahan</button>
        <a href="matakuliah.php">Batal</a>
    </form>
</body>
</html>
<?php $conn->close(); ?>