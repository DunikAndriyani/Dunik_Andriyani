<?php
include 'koneksi.php';

// Tambah Mahasiswa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_mahasiswa'])) {
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $alamat = $_POST['alamat'];

    $sql = "INSERT INTO mahasiswa (npm, nama, jurusan, alamat) VALUES ('$npm', '$nama', '$jurusan', '$alamat')";
    
    if ($conn->query($sql)) {
        header("Location: mahasiswa.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Hapus Mahasiswa
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_mahasiswa'])) {
    $npm = $_GET['delete_mahasiswa'];
    
    // Hapus dulu KRS yang terkait
    $sql_delete_krs = "DELETE FROM krs WHERE mahasiswa_npm = '$npm'";
    $conn->query($sql_delete_krs);
    
    // Kemudian hapus mahasiswa
    $sql = "DELETE FROM mahasiswa WHERE npm = '$npm'";
    
    if ($conn->query($sql)) {
        header("Location: mahasiswa.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil data mahasiswa
$sql_mahasiswa = "SELECT * FROM mahasiswa";
$result_mahasiswa = $conn->query($sql_mahasiswa);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>
    <h1>Kelola Data Mahasiswa</h1>
    
    <h2>Tambah Mahasiswa</h2>
    <form action="mahasiswa.php" method="post">
        <div class="form-group">
            <label for="npm">NPM:</label>
            <input type="text" id="npm" name="npm" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div class="form-group">
            <label for="jurusan">Jurusan:</label>
            <select id="jurusan" name="jurusan" required>
                <option value="informatika">Informatika</option>
                <option value="sistem informasi">Sistem Informasi</option>
            </select>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat"></textarea>
        </div>
        <button type="submit" name="add_mahasiswa">Tambah Mahasiswa</button>
    </form>
    
    <h2>Daftar Mahasiswa</h2>
    <table>
        <thead>
            <tr>
                <th>NPM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_mahasiswa->num_rows > 0) {
                while($row = $result_mahasiswa->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row['npm']."</td>
                            <td>".$row['nama']."</td>
                            <td>".ucfirst($row['jurusan'])."</td>
                            <td>".$row['alamat']."</td>
                            <td class='action-buttons'>
                                <a href='edit_mahasiswa.php?npm=".$row['npm']."'>Edit</a>
                                <a href='mahasiswa.php?delete_mahasiswa=".$row['npm']."' onclick='return confirm(\"Apakah Anda yakin ingin menghapus mahasiswa ini?\")'>Hapus</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada data mahasiswa</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <p><a href="krs_view.php">Kembali ke KRS</a></p>
</body>
</html>
<?php $conn->close(); ?>