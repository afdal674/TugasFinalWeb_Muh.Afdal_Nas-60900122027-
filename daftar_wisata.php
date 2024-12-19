<?php
include 'db.php';

// Proses hapus destinasi
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']); // Sanitasi input
    $gambarSql = "SELECT gambar FROM destinasi WHERE id=?";
    
    // Persiapkan dan bind
    $stmt = $conn->prepare($gambarSql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $gambarResult = $stmt->get_result();
    
    if ($gambarRow = $gambarResult->fetch_assoc()) {
        $gambarPath = "aset/" . $gambarRow['gambar'];

        $sql = "DELETE FROM destinasi WHERE id=?";
        $deleteStmt = $conn->prepare($sql);
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            if (file_exists($gambarPath)) {
                unlink($gambarPath);
            }
            header('Location: daftar_wisata.php'); // Redirect setelah hapus
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Gambar tidak ditemukan.";
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
    <title>Daftar Wisata - GoExplore</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            height: 100vh;
        }
        .navbar {
            background-color: #4475F2;
            padding: 10px;
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
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }
        .navbar a:hover {
            text-decoration: underline;
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
            overflow-y: auto;
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4475F2;
            color: white;
        }
        td img {
            max-width: 100px;
        }
        .action-buttons {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-edit {
            background-color: #28a745;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">GoExplore</div>
</div>

<div class="sidebar">
    <a href="daftar_pengguna.php">Daftar Pengguna</a>
    <a href="dashboard_admin.php">Tambah Destinasi</a>
    <a href="laporan.php">Laporan</a>
    <a href="login.php">Logout</a>
</div>

<div class="container">
    <h2>Daftar Destinasi Wisata</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Lokasi</th>
            <th>Link Google Maps</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['deskripsi']; ?></td>
                <td><?php echo $row['lokasi']; ?></td>
                <td><a href="<?php echo $row['link_maps']; ?>" target="_blank">Lihat Peta</a></td>
                <td><img src="aset/<?php echo $row['gambar']; ?>" alt="Gambar Destinasi"></td>
                <td class="action-buttons">
                    <a href="edit_destinasi.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                    <a href="?hapus=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus?');">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">Tidak ada data destinasi.</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>