<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mahasiswa_npm = $_POST['mahasiswa_npm'];
    $matakuliah_kodemk = $_POST['matakuliah_kodemk'];

    // Cek apakah kombinasi sudah ada
    $check_sql = "SELECT * FROM krs WHERE mahasiswa_npm = '$mahasiswa_npm' AND matakuliah_kodemk = '$matakuliah_kodemk'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "Mahasiswa sudah mengambil mata kuliah ini.";
    } else {
        $sql = "INSERT INTO krs (mahasiswa_npm, matakuliah_kodemk) VALUES ('$mahasiswa_npm', '$matakuliah_kodemk')";
        
        if ($conn->query($sql) {
            header("Location: krs_view.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>