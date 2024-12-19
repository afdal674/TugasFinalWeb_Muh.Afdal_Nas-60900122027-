<?php
include 'db.php';

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM destinasi WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        die("Destinasi tidak ditemukan.");
    }
    
    $row = $result->fetch_assoc();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $link_maps = $_POST['link_maps'];
    
    // Jika ada gambar baru yang diupload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $gambar = $_FILES['gambar']['name'];
        $gambarPath = "aset/" . basename($gambar);
        
        // Pindahkan file ke folder aset
        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambarPath);
        
        // Update query
        $sql = "UPDATE destinasi SET nama=?, deskripsi=?, lokasi=?, link_maps=?, gambar=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nama, $deskripsi, $lokasi, $link_maps, $gambar, $id);
    } else {
        // Update tanpa mengganti gambar
        $sql = "UPDATE destinasi SET nama=?, deskripsi=?, lokasi=?, link_maps=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nama, $deskripsi, $lokasi, $link_maps, $id);
    }

    if ($stmt->execute()) {
        header('Location: daftar_wisata.php'); // Redirect setelah update
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Destinasi - GoExplore</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #F4F5F7;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input[type="text"],
        input[type="url"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="file"] {
            margin-top: 10px;
        }
        button {
            background-color: #4475F2;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Destinasi</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
        
        <label for="deskripsi">Deskripsi:</label>
        <textarea name="deskripsi" id="deskripsi" required><?php echo htmlspecialchars($row['deskripsi']); ?></textarea>
        
        <label for="lokasi">Lokasi:</label>
        <input type="text" name="lokasi" id="lokasi" value="<?php echo htmlspecialchars($row['lokasi']); ?>" required>
        
        <label for="link_maps">Link Google Maps:</label>
        <input type="url" name="link_maps" id="link_maps" value="<?php echo htmlspecialchars($row['link_maps']); ?>" required>
        
        <label for="gambar">Gambar:</label>
        <input type="file" name="gambar" id="gambar">
        
        <button type="submit">Update</button>
    </form>
</div>

</body>
</html>