<?php
include 'db.php';

// Ambil data komentar dan rating pengguna
$sql = "
    SELECT c.id, c.comment, c.user_id, c.destination_id, r.rating, u.username, d.nama AS destination_name 
    FROM comments c 
    JOIN ratings r ON c.id = r.comment_id 
    JOIN users u ON c.user_id = u.id 
    JOIN destinasi d ON c.destination_id = d.id
";
$result = $conn->query(query: $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - GoExplore</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            height: 100vh; /* Full height */
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
            margin-top: 60px; /* Space for navbar */
            max-width: calc(100% - 250px);
            padding: 20px;
            overflow-y: auto; /* Allow scrolling */
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
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">GoExplore</div>
    <div>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="daftar_wisata.php">Daftar Wisata</a>
        <a href="daftar_pengguna.php">Daftar Pengguna</a>
        <a href="laporan.php">Laporan</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="sidebar">
    <a href="daftar_pengguna.php">Daftar Pengguna</a>
    <a href="daftar_wisata.php">Daftar Destinasi</a>
    <a href="laporan.php">Laporan</a>
    <a href="login.php">Logout</a>
</div>

<div class="container">
    <h2>Laporan Komentar dan Rating</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Destinasi</th>
            <th>Komentar</th>
            <th>Rating</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['destination_name']; ?></td>
                <td><?php echo $row['comment']; ?></td>
                <td><?php echo $row['rating']; ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">Tidak ada data komentar dan rating.</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>