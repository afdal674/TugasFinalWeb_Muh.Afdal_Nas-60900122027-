<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            overflow: hidden; /* Mencegah scroll saat animasi */
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 50px;
            max-width: 980px;
            margin: auto;
            opacity: 0; /* Mulai dengan transparan */
            transform: translateY(20px); /* Mulai sedikit lebih bawah */
            animation: fadeInUp 0.8s forwards; /* Animasi saat masuk */
        }
        @keyframes fadeInUp {
            to {
                opacity: 1; /* Menjadi terlihat */
                transform: translateY(0); /* Kembali ke posisi awal */
            }
        }
        h1 {
            font-size: 48px;
            color: #181E4B; /* Warna teks judul */
            margin-bottom: 20px;
        }
        p {
            font-size: 20px;
            color: #34495e; /* Warna teks paragraf */
            margin-bottom: 30px;
        }
        .button {
            background-color: #4475F2; /* Warna tombol */
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s; /* Transisi untuk hover */
        }
        .button:hover {
            background-color: #2980b9; /* Warna tombol saat hover */
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        /* Animasi untuk fade-out */
        .fade-out {
            animation: fadeOut 0.5s forwards;
        }
        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
    </style>
</head>
<body>

<div class="container" id="landing-container">
    <div class="text-section">
        <h1>Liburan & nikmati tempat baru di Indonesia</h1>
        <p>GoExplore membantu kamu selalu update terkait tempat liburan baru di Indonesia yang menarik untuk anda kunjungi.</p>
        <a href="#" class="button" id="start-button">Mulai sekarang &rarr;</a>
    </div>
    <div class="image-section">
        <img src="aset/Group 592 2.png" alt="Liburan di Indonesia">
    </div>
</div>

<div class="footer">
    &copy; 2024 GoExplore. Semua hak dilindungi.
</div>

<script>
    document.getElementById('start-button').addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah perilaku default anchor
        const container = document.getElementById('landing-container');
        
        // Tambahkan kelas fade-out untuk animasi
        container.classList.add('fade-out');

        // Setelah animasi selesai, arahkan ke halaman login
        setTimeout(() => {
            window.location.href = 'login.php'; // Arahkan ke halaman login
        }, 500); // Waktu sesuai dengan durasi animasi
    });
</script>

</body>
</html>