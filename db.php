<?php
$host = 'localhost'; // Host database
$db_name = 'portal_wisata'; // Nama database
$username = 'root'; // Username database
$password = ''; // Password database (default kosong di Laragon)

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $db_name);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>