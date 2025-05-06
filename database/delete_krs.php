<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil data KRS yang akan diedit
    $sql = "SELECT * FROM krs WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $mahasiswa_npm = $_POST['mahasiswa_npm'];
    $matakuliah_kodemk = $_POST['matakuliah_kodemk'];

    $sql = "UPDATE krs SET mahasiswa_npm = '$mahasiswa_npm', matakuliah_kodemk = '$matakuliah_kodemk' WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: krs_view.php");
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
    <title>Edit KRS</title>
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
    <h1>Edit KRS</h1>
    <form action="edit_krs.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        
        <div class="form-group">
            <label for="mahasiswa">Mahasiswa:</label>
            <select name="mahasiswa_npm" id="mahasiswa" required>
                <?php
                $sql_mahasiswa = "SELECT npm, nama FROM mahasiswa";
                $result_mahasiswa = $conn->query($sql_mahasiswa);
                while($mhs = $result_mahasiswa->fetch_assoc()) {
                    $selected = ($mhs['npm'] == $row['mahasiswa_npm']) ? 'selected' : '';
                    echo "<option value='".$mhs['npm']."' $selected>".$mhs['nama']." (".$mhs['npm'].")</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="matakuliah">Mata Kuliah:</label>
            <select name="matakuliah_kodemk" id="matakuliah" required>
                <?php
                $sql_matakuliah = "SELECT kodemk, nama FROM matakuliah";
                $result_matakuliah = $conn->query($sql_matakuliah);
                while($mk = $result_matakuliah->fetch_assoc()) {
                    $selected = ($mk['kodemk'] == $row['matakuliah_kodemk']) ? 'selected' : '';
                    echo "<option value='".$mk['kodemk']."' $selected>".$mk['nama']." (".$mk['kodemk'].")</option>";
                }
                ?>
            </select>
        </div>
        
        <button type="submit">Simpan Perubahan</button>
        <a href="krs_view.php">Batal</a>
    </form>
</body>
</html>
<?php $conn->close(); ?>