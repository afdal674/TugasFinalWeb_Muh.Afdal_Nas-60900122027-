<?php
include 'db.php'; // Pastikan untuk menghubungkan ke database

// Mengambil data destinasi dari database
$searchQuery = "";
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
    $sql = "SELECT * FROM destinasi WHERE nama LIKE '%$searchQuery%'";
} else {
    $sql = "SELECT * FROM destinasi";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Destinasi Wisata</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F4F5F7;
        }
        .navbar {
            background-color: #4475F2;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 700;
            transition: color 0.3s;
        }
        .navbar a:hover {
            color: #0056b3; /* Warna biru saat hover */
        }
        .search-container {
            display: flex;
            align-items: center;
        }
        .search-input {
            padding: 8px;
            border: none;
            border-radius: 5px;
            width: 200px;
            transition: width 0.4s;
        }
        .search-input:focus {
            width: 300px; /* Memperlebar saat fokus */
            outline: none;
        }
        .search-button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            background-color: #FFff
        ;
            color: #333;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s;
        }
        .search-button:hover {
            background-color: #0056b3; /* Mengubah warna hover menjadi biru */
            color: white; /* Mengubah warna teks menjadi putih saat hover */
        }
        .hero {
            background-image: url('aset/hero-image.jpg');
            height: 250px; /* Mengurangi tinggi hero */
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
        }
        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(120, 157, 252, 0.7); /* Transparan */
            z-index: 1;
        }
        .hero h1 {
            font-size: 36px; /* Mengurangi ukuran font judul */
            margin: 0;
            position: relative;
            z-index: 2;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 0 20px;
        }
        .card {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            background-color: white;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 2px solid #4475F2; /* Bingkai berwarna biru */
            overflow: hidden; /* Menghindari overflow */
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.3);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        .card h3 {
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: white;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 5px 10px;
            border-radius: 5px;
            margin: 0;
            transition: background-color 0.3s;
        }
        .card h3:hover {
            background-color: rgba(0, 0, 0, 0.9);
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>
        <a href="https://wa.me/6288242136325" target="_blank">FAQ</a>
        <a href="login.php">Keluar</a>
        <a href="tentang_kami.php">About Us</a>
    </div>
    <form class="search-container" method="POST" action="">
        <input type="text" class="search-input" name="search" placeholder="Cari destinasi..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" class="search-button">Cari</button>
    </form>
</div>

<div class="hero">
    <h1>Selamat Datang di GoExplore</h1>
</div>

<div class="container">
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="card">
            <a href="detail.php?id=<?php echo $row['id']; ?>">
                <img src="aset/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama']; ?>">
                <h3><?php echo $row['nama']; ?></h3>
            </a>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Tidak ada data destinasi.</p>
    <?php endif; ?>
</div>

<div class="footer">
    &copy; 2024 GoExplore. Semua hak dilindungi.
</div>

</body>
</html>