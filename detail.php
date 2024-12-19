<?php
include 'db.php'; // Pastikan untuk menghubungkan ke database

// Ambil ID dari parameter URL
$id = intval($_GET['id']); // Sanitasi input

// Mengambil data destinasi berdasarkan ID
$sql = "SELECT * FROM destinasi WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Destinasi tidak ditemukan.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Destinasi - <?php echo htmlspecialchars($row['nama']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eaeef1; /* Warna latar belakang yang lebih cerah */
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .content {
            padding: 20px;
            padding-left: 5em; /* Menambahkan margin samping kiri 5.0em */
            padding-right: 5em; /* Menambahkan margin samping kanan 5.0em */
        }
        .content h1 {
            color: #2c3e50; /* Warna teks yang lebih gelap untuk kontras */
            font-size: 2.5em; /* Ukuran font lebih besar */
            margin: 20px 0; /* Menambahkan margin atas dan bawah */
            text-align: center; /* Mengatur teks agar rata tengah */
            font-weight: 700; /* Membuat teks lebih tebal */
        }
        .content p {
            color: #555;
            margin: 15px 0; /* Menambahkan margin atas dan bawah untuk rapi */
            font-size: 1.0em; /* Ukuran font yang lebih besar */
            text-align: justify; /* Membuat teks menjadi rata kiri dan kanan */
        }
        .image {
            display: block; /* Mengubah tampilan gambar menjadi block */
            margin: 0 auto 25px auto; /* Memusatkan gambar dan memberi margin bawah */
            width: 70%; /* Mengatur lebar gambar */
            height: auto; /* Memastikan gambar responsif */
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            object-fit: cover; /* Memastikan gambar terpotong dengan baik */
        }
        .map-link {
            margin: 20px 0;
            font-size: 1.0em;
            color: #007bff;
        }
        .map-link a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s;
        }
        .map-link a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        @media (max-width: 800px) {
            .container {
                margin: 10px; /* Mengurangi margin pada tampilan kecil */
            }
            .content {
                padding-left: 2em; /* Mengurangi padding pada tampilan kecil */
                padding-right: 2em; /* Mengurangi padding pada tampilan kecil */
            }
            .content h1 {
                font-size: 2.2em; /* Menyesuaikan ukuran font pada tampilan kecil */
            }
            .content p {
                font-size: 1em; /* Menyesuaikan ukuran font pada tampilan kecil */
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="content">
        <h1><?php echo htmlspecialchars($row['nama']); ?></h1>
        <img class="image" src="aset/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama']); ?>">
        <p><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
        <div class="map-link">
            <p>Untuk melihat lokasi, kunjungi <a href="<?php echo htmlspecialchars($row['link_maps']); ?>" target="_blank">Google Maps</a>.</p>
        </div>
    </div>
</div>

<div class="footer">
    &copy; 2024 GoExplore. Semua hak dilindungi.
</div>

</body>
</html>