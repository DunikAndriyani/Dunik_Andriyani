<?php
include 'koneksi.php';

// Tambah Mata Kuliah
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_matakuliah'])) {
    $kodemk = $_POST['kodemk'];
    $nama = $_POST['nama'];
    $jumlah_sks = $_POST['jumlah_sks'];

    $sql = "INSERT INTO matakuliah (kodemk, nama, jumlah_sks) VALUES ('$kodemk', '$nama', $jumlah_sks)";
    
    if ($conn->query($sql)) {
        header("Location: matakuliah.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Hapus Mata Kuliah
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_matakuliah'])) {
    $kodemk = $_GET['delete_matakuliah'];
    
    // Hapus dulu KRS yang terkait
    $sql_delete_krs = "DELETE FROM krs WHERE matakuliah_kodemk = '$kodemk'";
    $conn->query($sql_delete_krs);
    
    // Kemudian hapus mata kuliah
    $sql = "DELETE FROM matakuliah WHERE kodemk = '$kodemk'";
    
    if ($conn->query($sql)) {
        header("Location: matakuliah.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil data mata kuliah
$sql_matakuliah = "SELECT * FROM matakuliah";
$result_matakuliah = $conn->query($sql_matakuliah);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Mata Kuliah</title>
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
    <h1>Kelola Data Mata Kuliah</h1>
    
    <h2>Tambah Mata Kuliah</h2>
    <form action="matakuliah.php" method="post">
        <div class="form-group">
            <label for="kodemk">Kode MK:</label>
            <input type="text" id="kodemk" name="kodemk" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div class="form-group">
            <label for="jumlah_sks">Jumlah SKS:</label>
            <input type="number" id="jumlah_sks" name="jumlah_sks" min="1" max="6" required>
        </div>
        <button type="submit" name="add_matakuliah">Tambah Mata Kuliah</button>
    </form>
    
    <h2>Daftar Mata Kuliah</h2>
    <table>
        <thead>
            <tr>
                <th>Kode MK</th>
                <th>Nama</th>
                <th>Jumlah SKS</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_matakuliah->num_rows > 0) {
                while($row = $result_matakuliah->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row['kodemk']."</td>
                            <td>".$row['nama']."</td>
                            <td>".$row['jumlah_sks']."</td>
                            <td class='action-buttons'>
                                <a href='edit_matakuliah.php?kodemk=".$row['kodemk']."'>Edit</a>
                                <a href='matakuliah.php?delete_matakuliah=".$row['kodemk']."' onclick='return confirm(\"Apakah Anda yakin ingin menghapus mata kuliah ini?\")'>Hapus</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data mata kuliah</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <p><a href="krs_view.php">Kembali ke KRS</a></p>
</body>
</html>
<?php $conn->close(); ?>