<?php
session_start();

$bandara_asal = [
    "Soekarno Hatta" => 65000,
    "Husein Sastranegara" => 50000,
    "Abdul Rachman Saleh" => 40000,
    "Juanda" => 30000
];

$bandara_tujuan = [
    "Ngurah Rai" => 85000,
    "Hasanuddin" => 70000,
    "Inanwatan" => 90000,
    "Sultan Iskandar Muda" => 60000
];

$nama_maskapai = "";
$asal = "";
$tujuan = "";
$harga_tiket = "";
$pajak = 0;
$total_harga = 0;
$tanggal = date("d-m-Y");
$nomor = rand(100000, 999999);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_maskapai = $_POST["nama_maskapai"];
    $asal = $_POST["bandara_asal"];
    $tujuan = $_POST["bandara_tujuan"];
    $harga_tiket = (int) $_POST["harga_tiket"];
    $pajak = $bandara_asal[$asal] + $bandara_tujuan[$tujuan];
    $total_harga = $harga_tiket + $pajak;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Rute Penerbangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        form {
            background: #ffc0cb;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 8px;
            margin: 8px 0 16px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #d63384;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #e83e8c;
        }

        .output {
            background: #fff0f5;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            margin-top: 20px;
        }

        .output p {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="center-container">
        <h2>Pendaftaran Rute Penerbangan</h2>

        <form method="post">
            <label>Nama Maskapai:</label>
            <input type="text" name="nama_maskapai" required>

            <label>Bandara Asal:</label>
            <select name="bandara_asal">
                <?php foreach ($bandara_asal as $nama => $nilai): ?>
                    <option value="<?= $nama ?>"><?= $nama ?></option>
                <?php endforeach; ?>
            </select>

            <label>Bandara Tujuan:</label>
            <select name="bandara_tujuan">
                <?php foreach ($bandara_tujuan as $nama => $nilai): ?>
                    <option value="<?= $nama ?>"><?= $nama ?></option>
                <?php endforeach; ?>
            </select>

            <label>Harga Tiket:</label>
            <input type="number" name="harga_tiket" required>

            <input type="submit" value="Submit">
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="output">
                <h3>Output:</h3>
                <p><strong>Nomor:</strong> <?= $nomor ?></p>
                <p><strong>Tanggal:</strong> <?= $tanggal ?></p>
                <p><strong>Nama Maskapai:</strong> <?= htmlspecialchars($nama_maskapai) ?></p>
                <p><strong>Asal Penerbangan:</strong> <?= $asal ?></p>
                <p><strong>Tujuan Penerbangan:</strong> <?= $tujuan ?></p>
                <p><strong>Harga Tiket:</strong> Rp<?= number_format($harga_tiket, 0, ',', '.') ?></p>
                <p><strong>Pajak:</strong> Rp<?= number_format($pajak, 0, ',', '.') ?></p>
                <p><strong>Total Harga Tiket:</strong> Rp<?= number_format($total_harga, 0, ',', '.') ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>