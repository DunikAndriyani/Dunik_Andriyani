<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['npm'])) {
    $npm = $_GET['npm'];
    
    // Ambil data mahasiswa yang akan diedit
    $sql = "SELECT * FROM mahasiswa WHERE npm = '$npm'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE mahasiswa SET nama = '$nama', jurusan = '$jurusan', alamat = '$alamat' WHERE npm = '$npm'";
    
    if ($conn->query($sql)) {
        header("Location: mahasiswa.php");
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
    <title>Edit Mahasiswa</title>
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
    <h1>Edit Mahasiswa</h1>
    <form action="edit_mahasiswa.php" method="post">
        <input type="hidden" name="npm" value="<?php echo $row['npm']; ?>">
        
        <div class="form-group">
            <label for="npm">NPM:</label>
            <input type="text" id="npm" value="<?php echo $row['npm']; ?>" disabled>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
        </div>
        <div class="form-group">
            <label for="jurusan">Jurusan:</label>
            <select id="jurusan" name="jurusan" required>
                <option value="informatika" <?php echo ($row['jurusan'] == 'informatika') ? 'selected' : ''; ?>>Informatika</option>
                <option value="sistem informasi" <?php echo ($row['jurusan'] == 'sistem informasi') ? 'selected' : ''; ?>>Sistem Informasi</option>
            </select>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat"><?php echo $row['alamat']; ?></textarea>
        </div>
        
        <button type="submit">Simpan Perubahan</button>
        <a href="mahasiswa.php">Batal</a>
    </form>
</body>
</html>
<?php $conn->close(); ?>