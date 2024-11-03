<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Input Kecamatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .result-container {
            background-color: #fff;
            padding: 30px;
            border: 2px solid #007BFF; /* Border tebal dengan warna kontras */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Lebar container */
            text-align: center; /* Pusatkan teks */
        }
        h2 {
            color: #007BFF; /* Warna judul */
        }
        p {
            margin: 15px 0;
        }
        a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #007BFF; /* Warna tombol */
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a:hover {
            background-color: #0056b3; /* Warna tombol saat hover */
        }
    </style>
</head>
<body>

<div class="result-container">
    <?php
    // Ambil data dari form
    $kecamatan = $_POST['kecamatan'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];

    // Cek apakah semua field telah diisi
    if (empty($kecamatan) || empty($longitude) || empty($latitude) || empty($luas) || empty($jumlah_penduduk)) {
        die("<h2>Error</h2><p>Semua field harus diisi.</p><a href='index.html'>Kembali ke form</a>"); // Berhenti jika ada yang kosong
    }

    // Sesuaikan dengan setting MySQL
    $servername = "localhost";
    $username = "root";
    $password = ""; // Default tanpa password
    $dbname = "acara8_pgweb_frendy"; // Ganti dengan nama database yang sesuai

    // Buat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("<h2>Error</h2><p>Connection failed: " . $conn->connect_error . "</p><a href='index.html'>Kembali ke form</a>");
    }

    // Masukkan data ke dalam tabel 'kecamatan_data'
    $sql = "INSERT INTO kecamatan_data (kecamatan, longitude, latitude, luas, jumlah_penduduk) 
    VALUES ('$kecamatan', $longitude, $latitude, $luas, $jumlah_penduduk)";

    if ($conn->query($sql) === TRUE) {
        echo "<h2>Success</h2><p>Record baru berhasil dibuat.</p>";
    } else {
        echo "<h2>Error</h2><p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    $conn->close();
    ?>
    <a href="index.html">Kembali ke form</a>
</div>

</body>
</html>
