<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "acara8_pgweb_frendy";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses update data jika 'id' dan data lain diterima
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $kecamatan = $_POST['kecamatan'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];

    // Query update data berdasarkan id
    $sql = "UPDATE kecamatan_data SET 
                kecamatan='$kecamatan', 
                longitude='$longitude', 
                latitude='$latitude', 
                luas='$luas', 
                jumlah_penduduk='$jumlah_penduduk' 
            WHERE id='$id'";

    // Eksekusi query dan cek keberhasilan
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diupdate.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "ID tidak diset.";
}

// Tutup koneksi dan redirect ke index.php setelah update
$conn->close();
header("Location: index.php");
exit;
?>
