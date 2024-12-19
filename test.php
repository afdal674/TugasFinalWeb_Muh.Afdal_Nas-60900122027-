<?php
require 'db.php'; // Memanggil file koneksi

// Uji koneksi
if ($conn) {
    echo "Koneksi ke database berhasil!";
} else {
    echo "Koneksi ke database gagal!";
}

// Tutup koneksi
$conn->close();
?>