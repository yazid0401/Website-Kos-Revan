<?php
include("../inc/inc_koneksi.php");
session_start();

$error = "";
$sukses = "";

if (isset($_POST["signup"])) {
    $email = trim($_POST["email"]);
    $nama = trim($_POST["nama"]);
    $password = trim($_POST["password"]);
    $konfirmasi = trim($_POST["konfirmasi"]);

    // Validasi input
    if ($email == "" || $nama == "" || $password == "" || $konfirmasi == "") {
        $error = "Semua kolom wajib diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } elseif(strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } elseif ($password != $konfirmasi) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah email sudah digunakan
        $cek = mysqli_query($koneksi, "SELECT * FROM akun WHERE Email = '$email'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            // Simpan data baru ke tabel akun
            $sql = "INSERT INTO akun (Email, Nama, Password, Level)
                    VALUES ('$email', '$nama', '$password', 'user')";
            $q = mysqli_query($koneksi, $sql);

            if ($q) {
                $sukses = "Pendaftaran berhasil! Silakan login.";
            } else {
                $error = "Terjadi kesalahan saat menyimpan data.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Kos Revan</title>
    <style>
    body {
        font-family: Arial;
        background: #f5f5f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background: #fff;
        padding: 60px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        width: 300px;
        text-align: center;
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-top: 7px;
    }

    button {
        width: 100%;
        padding: 10px;
        background: #8b7355;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 15px;
    }

    button:hover {
        background: #a3866b;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-top: 10px;
    }

    .sukses {
        color: green;
        font-size: 14px;
        margin-top: 10px;
    }

    .link {
        margin-top: 15px;
        font-size: 14px;
    }

    p {
        text-align: left;
        margin-bottom: 1px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Daftar Akun Baru</h2>
        <form method="POST" action="">
            <p>Email</p>
            <input type="text" name="email" placeholder="Masukkan Email" required>
            <p>Nama</p>
            <input type="text" name="nama" placeholder="Masukkan Nama" required>
            <p>Password</p>
            <input type="password" name="password" placeholder="Masukkan Password" required>
            <p>Konfirmasi Password</p>
            <input type="password" name="konfirmasi" placeholder="Ulangi Password" required>
            <button type="submit" name="signup">Daftar</button>
        </form>

        <?php if ($error) { ?>
        <div class="error"><?php echo $error; ?></div>
        <?php } elseif ($sukses) { ?>
        <div class="sukses"><?php echo $sukses; ?></div>
        <meta http-equiv="refresh" content="2;url=login.php">
        <?php } ?>

        <div class="link">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </div>
    </div>
</body>

</html>