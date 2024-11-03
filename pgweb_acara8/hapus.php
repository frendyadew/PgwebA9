<?php
// Sesuaikan dengan setting MySQL default
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

// Cek apakah 'id' diterima
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Query untuk menghapus data
    $sql = "DELETE FROM kecamatan_data WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "ID not set"; // Jika ID tidak ada
}

// Menutup koneksi
$conn->close();

// Redirect kembali ke index.php setelah menghapus
header("Location: index.php");
exit;
?>
