<?php
require 'db.php'; // Memanggil file koneksi

// Cek jika admin sudah ada di database
$admin_username = "admin";
$admin_password = password_hash("admin123", PASSWORD_DEFAULT);

// Mengecek apakah admin sudah terdaftar
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $admin_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Jika admin belum ada, tambahkan admin ke database
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
    $stmt->bind_param("ss", $admin_username, $admin_password);
    $stmt->execute();
}
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Memeriksa apakah username dan password sama dengan admin
    if ($username === $admin_username && password_verify($password, $admin_password)) {
        $error_message = "Anda bukan admin!";
    } elseif ($password !== $confirm_password) {
        $error_message = "Password dan konfirmasi password tidak cocok!";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Menyimpan data ke database
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            // Redirect ke halaman login setelah pendaftaran berhasil
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #789DFC;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .signup-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: left;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"], input[type="password"] {
            font-family: 'Montserrat', sans-serif;
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4475F2;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-family: 'Montserrat', sans-serif;
        }
        input[type="submit"]:hover {
            background-color: #3066F0;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .alternative-login {
            text-align: center;
            margin-top: 20px;
        }
        .alternative-login p {
            margin-bottom: 10px;
            font-size: 12px;
        }
        .alternative-login a {
            text-decoration: underline;
            color: blue; /* Warna tautan */
            cursor: pointer; /* Mengubah kursor saat hover */
        }
        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .social-button {
            width: 20px; /* Atur ukuran logo */
            height: 30px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        .social-button img {
            width: 100%;
            height: auto;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<div class="signup-container">
    <h2>Sign Up</h2>
    <?php if (!empty($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required id="username"><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required id="password"><br>

        <label for="confirm_password">Konfirmasi Password:</label>
        <input type="password" name="confirm_password" required id="confirm_password"><br>

        <input type="submit" value="Daftar">
    </form>

    <div class="alternative-login">
        <p>Sudah punya akun? <a href="login.php">Login</a></p>

        <div class="social-buttons">
            <div class="social-button" onclick="window.location.href='https://accounts.google.com/o/oauth2/auth'">
                <img src="aset/search.png" alt="Login with Google">
            </div>
            <div class="social-button" onclick="window.location.href='https://www.facebook.com/v12.0/dialog/oauth'">
                <img src="aset/facebook (1).png" alt="Login with Facebook">
            </div>
            <div class="social-button" onclick="window.location.href='https://appleid.apple.com/auth/authorize'">
                <img src="aset/apple-logo.png" alt="Login with Apple">
            </div>
        </div>
    </div>
</div>

</body>
</html>