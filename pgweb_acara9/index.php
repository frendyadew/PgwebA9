<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kecamatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            border: 2px solid #007BFF;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            text-align: center;
            border-radius: 4px;
        }
        .action-button:hover {
            background-color: #c82333;
        }
        .no-results {
            margin: 20px 0;
            font-size: 18px;
            color: #555;
        }
        .center-text {
            text-align: center;
        }
        /* Style untuk peta */
        #map {
            height: 400px; /* Tinggi peta */
            width: 80%; /* Lebar peta */
            margin-top: 20px; /* Margin di atas peta */
            transition: opacity 0.3s; /* Animasi transisi untuk meredup */
        }
        /* Modal style */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 0; /* Hapus margin */
            padding: 12px;
            border: 1px solid #888;
            width: 30%; /* Could be more or less, depending on screen size */
            border-radius: 8px;
            position: fixed; /* Stay in place */
            left: 50%; /* Center horizontally */
            top: 50%; /* Center vertically */
            transform: translate(-50%, -50%); /* Pusatkan modal */
            z-index: 1001; /* Ensure modal content is above everything else */
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 15px; /* Spacing between fields */
        }
        .form-group label {
            display: block; /* Make labels block level */
            margin-bottom: 5px; /* Space between label and input */
            font-weight: bold; /* Make labels bold */
        }
        .form-group input {
            width: 100%; /* Make inputs full width */
            padding: 10px; /* Padding inside inputs */
            border: 1px solid #ccc; /* Border color */
            border-radius: 4px; /* Rounded corners */
            box-sizing: border-box; /* Include padding and border in element's total width and height */
        }
        /* Toast style */
        .toast {
            visibility: hidden; /* Hidden by default */
            min-width: 250px; /* Minimum width */
            margin-left: -125px; /* Center the toast */
            background-color: #333; /* Black background */
            color: #fff; /* White text */
            text-align: center; /* Center text */
            border-radius: 2px; /* Rounded corners */
            padding: 16px; /* Padding */
            position: fixed; /* Fixed position */
            z-index: 1000; /* Sit on top */
            left: 50%; /* Center horizontally */
            bottom: 30px; /* 30px from the bottom */
            font-size: 17px; /* Font size */
        }
        .toast.show {
            visibility: visible; /* Show the toast */
            animation: fadein 0.5s, fadeout 0.5s 2.5s; /* Fade in and out animations */
        }
        @keyframes fadein {
            from { bottom: 0; opacity: 0; }
            to { bottom: 30px; opacity: 1; }
        }
        @keyframes fadeout {
            from { bottom: 30px; opacity: 1; }
            to { bottom: 0; opacity: 0; }
        }
    </style>
</head>
<body>

<h2>Data Kecamatan</h2>

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
    die("<div class='no-results'>Connection failed: " . $conn->connect_error . "</div>");
}

// Query untuk mengambil data dari tabel 'kecamatan_data'
$sql = "SELECT id, kecamatan, longitude, latitude, luas, jumlah_penduduk FROM kecamatan_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Tampilkan data dalam tabel
    echo "<table>
            <tr>
                <th>Kecamatan</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Luas</th>
                <th>Jumlah Penduduk</th>
                <th>Aksi</th>
            </tr>";

    // Array untuk menyimpan titik koordinat
    $points = [];

    // Output data dari setiap baris
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["kecamatan"] . "</td>
                <td>" . $row["longitude"] . "</td>
                <td>" . $row["latitude"] . "</td>
                <td>" . $row["luas"] . "</td>
                <td align='right'>" . $row["jumlah_penduduk"] . "</td>
                <td class='center-text'>
                    <form method='post' action='hapus.php' style='display:inline;'>
                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                        <input type='submit' class='action-button' value='Hapus'>
                    </form>
                    <button class='action-button' onclick='openEditModal(" . json_encode($row) . ")' style='background-color: #ffc107; color: white;'>Edit</button>
                </td>
              </tr>";
        
        // Simpan data ke array points untuk peta
        $points[] = [
            'kecamatan' => $row['kecamatan'],
            'longitude' => $row['longitude'],
            'latitude' => $row['latitude'],
            'luas' => $row['luas'],
            'jumlah_penduduk' => $row['jumlah_penduduk']
        ];
    }
    echo "</table>";
} else {
    echo "<div class='no-results'>0 results</div>";
}

// Menutup koneksi
$conn->close();
?>

<!-- Elemen peta -->
<div id="map"></div>

<!-- Sertakan Leaflet CSS dan JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Inisialisasi peta
    var map = L.map('map').setView([-7.7956, 110.3705], 13); // Ganti dengan koordinat pusat yang sesuai

    // Tambahkan layer peta OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Data titik dari PHP
    var points = <?php echo json_encode($points); ?>;

    // Menambahkan titik ke peta
    points.forEach(function(point) {
        L.marker([point.latitude, point.longitude]).addTo(map)
            .bindPopup("Kecamatan: " + point.kecamatan + "<br>Longitude: " + point.longitude + "<br>Latitude: " + point.latitude + "<br>Luas: " + point.luas + "<br>Jumlah Penduduk: " + point.jumlah_penduduk);
    });

    // Fungsi untuk membuka modal edit
    function openEditModal(data) {
        document.getElementById('edit-id').value = data.id;
        document.getElementById('edit-kecamatan').value = data.kecamatan;
        document.getElementById('edit-longitude').value = data.longitude;
        document.getElementById('edit-latitude').value = data.latitude;
        document.getElementById('edit-luas').value = data.luas;
        document.getElementById('edit-jumlah-penduduk').value = data.jumlah_penduduk;
        document.getElementById('editModal').style.display = 'block';
    }

    // Fungsi untuk menutup modal
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Fungsi untuk menampilkan toast
    function showToast() {
        var toast = document.getElementById("toast");
        toast.className = "toast show";
        setTimeout(function() {
            toast.className = toast.className.replace("show", ""); // Setelah 3 detik, hilangkan toast
        }, 3000);
    }
</script>

<!-- Modal Edit -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h3>Edit Kecamatan</h3>
        <form method="post" action="edit.php" onsubmit="showToast();">
            <div class="form-group">
                <label for="edit-kecamatan">Kecamatan:</label>
                <input type="text" id="edit-kecamatan" name="kecamatan" required>
            </div>
            <div class="form-group">
                <label for="edit-longitude">Longitude:</label>
                <input type="number" id="edit-longitude" name="longitude" step="any" required>
            </div>
            <div class="form-group">
                <label for="edit-latitude">Latitude:</label>
                <input type="number" id="edit-latitude" name="latitude" step="any" required>
            </div>
            <div class="form-group">
                <label for="edit-luas">Luas:</label>
                <input type="number" id="edit-luas" name="luas" required>
            </div>
            <div class="form-group">
                <label for="edit-jumlah-penduduk">Jumlah Penduduk:</label>
                <input type="number" id="edit-jumlah-penduduk" name="jumlah_penduduk" required>
            </div>
            <input type="hidden" id="edit-id" name="id">
            <input type="submit" value="Simpan" class="action-button">
        </form>
    </div>
</div>

<!-- Elemen untuk toast -->
<div id="toast"> </div>

</body>
</html>
