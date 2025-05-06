<?php
include 'koneksi.php';

// Query untuk mendapatkan data KRS
$sql = "SELECT k.id, m.nama AS nama_mahasiswa, mk.nama AS nama_matakuliah, mk.jumlah_sks
        FROM krs k
        JOIN mahasiswa m ON k.mahasiswa_npm = m.npm
        JOIN matakuliah mk ON k.matakuliah_kodemk = mk.kodemk
        ORDER BY k.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem KRS Mahasiswa</title>
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
        .nama {
            color: #0066cc;
            font-weight: bold;
        }
        .matkul {
            color: #cc3300;
            font-weight: bold;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
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
    <h1>Sistem KRS Mahasiswa</h1>
    
    <h2>Daftar KRS</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Mata Kuliah</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while($row = $result->fetch_assoc()) {
                    $keterangan = "<span class='nama'>".$row['nama_mahasiswa']."</span> Mengambil Mata Kuliah <span class='matkul'>".$row['nama_matakuliah']."</span> (".$row['jumlah_sks']." SKS)";
                    echo "<tr>
                            <td>".$no++."</td>
                            <td>".$row['nama_mahasiswa']."</td>
                            <td>".$row['nama_matakuliah']."</td>
                            <td>".$keterangan."</td>
                            <td class='action-buttons'>
                                <a href='edit_krs.php?id=".$row['id']."'>Edit</a>
                                <a href='delete_krs.php?id=".$row['id']."' onclick='return confirm(\"Apakah Anda yakin ingin menghapus?\")'>Hapus</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada data KRS</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Tambah KRS</h2>
    <form action="add_krs.php" method="post">
        <div class="form-group">
            <label for="mahasiswa">Mahasiswa:</label>
            <select name="mahasiswa_npm" id="mahasiswa" required>
                <option value="">Pilih Mahasiswa</option>
                <?php
                $sql_mahasiswa = "SELECT npm, nama FROM mahasiswa";
                $result_mahasiswa = $conn->query($sql_mahasiswa);
                while($row = $result_mahasiswa->fetch_assoc()) {
                    echo "<option value='".$row['npm']."'>".$row['nama']." (".$row['npm'].")</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="matakuliah">Mata Kuliah:</label>
            <select name="matakuliah_kodemk" id="matakuliah" required>
                <option value="">Pilih Mata Kuliah</option>
                <?php
                $sql_matakuliah = "SELECT kodemk, nama FROM matakuliah";
                $result_matakuliah = $conn->query($sql_matakuliah);
                while($row = $result_matakuliah->fetch_assoc()) {
                    echo "<option value='".$row['kodemk']."'>".$row['nama']." (".$row['kodemk'].")</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit">Tambah KRS</button>
    </form>

    <h2>Kelola Data</h2>
    <ul>
        <li><a href="mahasiswa.php">Kelola Data Mahasiswa</a></li>
        <li><a href="matakuliah.php">Kelola Data Mata Kuliah</a></li>
    </ul>
</body>
</html>
<?php $conn->close(); ?>