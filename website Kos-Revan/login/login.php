<?php
include("../inc/inc_koneksi.php");
session_start();

$error = "";

if (isset($_POST["login"])) {
    $email = trim($_POST["username"]);
    $nama = trim($_POST["nama"]);
    $password = trim($_POST["password"]);

    if ($email == "" || $nama == "" || $password == "") {
        $error = "Semua kolom harus diisi!";
    } else {
        // Ubah ke huruf kecil agar pencarian tidak case-sensitive
        $email_lower = strtolower($email);
        $nama_lower = strtolower($nama);

        // Gunakan LOWER() pada kolom agar pencocokan tidak case-sensitive
        $sql = "SELECT * FROM akun 
                WHERE LOWER(Email) = '$email_lower' 
                AND LOWER(Nama) = '$nama_lower' 
                LIMIT 1";

        $q = mysqli_query($koneksi, $sql);

        if ($q && mysqli_num_rows($q) > 0) {
            $akun = mysqli_fetch_assoc($q);

            // Cek password (belum di-hash)
            if ($akun['Password'] == $password) {
                // Simpan session
                $_SESSION['login'] = true;
                $_SESSION['ID'] = $akun['ID'];
                $_SESSION['Nama'] = $akun['Nama'];
                $_SESSION['Email'] = $akun['Email'];
                $_SESSION['Level'] = $akun['Level'];

                if (strtolower($akun['Level']) == 'admin') {
                    header("Location: ../admin/kos.php");
                    exit;
                } elseif (strtolower($akun['Level']) == 'user') {
                    header("Location: ../user/home.php");
                    exit;
                } else {
                    $error = "Level tidak dikenal!";
                }
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Akun tidak ditemukan!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kos Revan</title>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

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

    .link {
        margin-top: 15px;
        font-size: 14px;
    }

    p {
        text-align: left;
        margin-bottom: 1px;
    }

    /* tambahan untuk ikon lihat/sembunyi password */
    .password-wrapper {
        position: relative;
    }

    .password-wrapper i {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #777;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Login Kos Revan</h2>
        <form method="POST" action="login.php">
            <p>Email</p>
            <input type="text" name="username" placeholder="Masukkan Email" required>

            <p>Nama</p>
            <input type="text" name="nama" placeholder="Masukkan Nama" required>

            <p>Password</p>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="Masukkan Password" required>
                <i class="bi bi-eye" id="togglePassword"></i>
            </div>

            <?php if (!empty($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
            <?php } ?>

            <button type="submit" name="login">Login</button>
        </form>


        <div class="link">
            Belum punya akun? <a href="signup.php">Daftar di sini</a>
        </div>
    </div>

    <script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function() {
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        this.classList.toggle("bi-eye");
        this.classList.toggle("bi-eye-slash");
    });
    </script>
</body>

</html>