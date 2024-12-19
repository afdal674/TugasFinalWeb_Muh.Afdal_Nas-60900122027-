<?php
session_start();
require 'db.php'; // Memanggil file koneksi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mengambil data user dari database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Memverifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session dan redirect berdasarkan role
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            if ($user['role'] === 'admin') {
                header("Location: dashboard_admin.php"); // Redirect ke halaman admin
            } else {
                header("Location: dashboard.php"); // Redirect ke halaman user
            }
            exit();
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "Username tidak ditemukan!";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .login-container {
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

<div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="post" action="">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>

    <div class="alternative-login">
        <p>Apakah Anda tidak punya akun? <a href="register.php">Daftar</a></p>

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