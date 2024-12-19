<?php
include 'db.php';

// Proses tambah destinasi
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $link_maps = $_POST['link_maps'];
    $gambar = $_FILES['gambar']['name'];
    $target = "aset/" . basename($gambar);

    $sql = "INSERT INTO destinasi (nama, deskripsi, lokasi, link_maps, gambar) 
            VALUES ('$nama', '$deskripsi', '$lokasi', '$link_maps', '$gambar')";
    
    if ($conn->query($sql) === TRUE) {
        move_uploaded_file($_FILES['gambar']['tmp_name'], $target);
        echo "<script>alert('Destinasi berhasil ditambahkan!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Proses hapus destinasi
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $gambarSql = "SELECT gambar FROM destinasi WHERE id=$id";
    $gambarResult = $conn->query($gambarSql);
    $gambarRow = $gambarResult->fetch_assoc();
    $gambarPath = "aset/" . $gambarRow['gambar'];

    $sql = "DELETE FROM destinasi WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Ambil data destinasi
$sql = "SELECT * FROM destinasi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            height: 100vh; /* Full height */
            flex-direction: column;
        }
        .navbar {
            background-color: #4475F2;
            padding: 15px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .navbar .logo {
            font-size: 1.5em;
            font-weight: bold;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 60px;
        }
        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: block;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        .container {
            margin-left: 250px;
            margin-top: 60px;
            max-width: calc(100% - 250px);
            padding: 20px;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            flex-grow: 1; /* Allow to grow and fill space */
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }
        .form-container {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            width: 600px; /* Set a wider fixed width for the form */
            max-width: 90%; /* Responsive max width */
            margin: auto; /* Center the form container */
        }
        .form-container label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 700;
            font-size: 14px;
            color: #333;
        }
        .form-container input,
        .form-container textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            padding: 12px 15px;
            background-color: #4475F2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 10px;
        }
        .form-container button:hover {
            background-color: #365e97;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">GoExplore Admin</div>
</div>

<div class="sidebar">
    <a href="daftar_pengguna.php">Daftar Pengguna</a>
    <a href="daftar_wisata.php">Daftar Destinasi</a>
    <a href="laporan.php">Laporan</a>
    <a href="login.php">Logout</a>
</div>

<div class="container">
    <div class="form-container">
        <h2>Tambah Destinasi</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="nama">Nama Destinasi</label>
            <input type="text" name="nama" id="nama" required>
            
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" required></textarea>
            
            <label for="lokasi">Lokasi Destinasi</label>
            <input type="text" name="lokasi" id="lokasi" required>
            
            <label for="link_maps">Link Google Maps</label>
            <input type="text" name="link_maps" id="link_maps" required>
            
            <label for="gambar">Gambar</label>
            <input type="file" name="gambar" id="gambar" required>
            
            <button type="submit" name="tambah">Tambah</button>
        </form>
    </div>
</div>

</body>
</html>