<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = ""; // Default tanpa password
$dbname = "acara8_pgweb_frendy";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari form
$id = $_POST['id'];
$kecamatan = $_POST['kecamatan'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];
$luas = $_POST['luas'];
$jumlah_penduduk = $_POST['jumlah_penduduk'];

// Query untuk memperbarui data
$sql = "UPDATE kecamatan_data SET 
            kecamatan = '$kecamatan', 
            longitude = '$longitude', 
            latitude = '$latitude', 
            luas = '$luas', 
            jumlah_penduduk = '$jumlah_penduduk' 
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    // Jika berhasil, set session variable untuk toast message
    $_SESSION['toast_message'] = "Data berhasil diedit!";
    // Arahkan kembali ke index.php
    header("Location: index.php");
    exit(); // Pastikan untuk keluar setelah header redirect
} else {
    echo "Error updating record: " . $conn->error;
}

// Menutup koneksi
$conn->close();
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Kecamatan</title>
    <style>
        /* Styling untuk membuat jendela edit lebih kecil */
        body {
            font-family: Arial, sans-serif;
        }
        form {
            width: 300px; /* Ukuran lebar form */
            margin: 0 auto; /* Mengatur posisi form di tengah */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Edit Data Kecamatan</h2>
<form action="update.php" method="post">
    <!-- Menyimpan ID data yang akan diedit -->
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    
    <!-- Form input untuk setiap field -->
    <label for="kecamatan">Kecamatan:</label>
    <input type="text" id="kecamatan" name="kecamatan" value="<?php echo htmlspecialchars($row['kecamatan']); ?>" required>

    <label for="longitude">Longitude:</label>
    <input type="text" id="longitude" name="longitude" value="<?php echo htmlspecialchars($row['longitude']); ?>" required>

    <label for="latitude">Latitude:</label>
    <input type="text" id="latitude" name="latitude" value="<?php echo htmlspecialchars($row['latitude']); ?>" required>

    <label for="luas">Luas:</label>
    <input type="text" id="luas" name="luas" value="<?php echo htmlspecialchars($row['luas']); ?>" required>

    <label for="jumlah_penduduk">Jumlah Penduduk:</label>
    <input type="text" id="jumlah_penduduk" name="jumlah_penduduk" value="<?php echo htmlspecialchars($row['jumlah_penduduk']); ?>" required>

    <input type="submit" value="Update">
</form>

</body>
</html>
