<?php
include("../inc/inc_koneksi.php");

// Pastikan ID dikirim
if (!isset($_GET['ID']) || empty($_GET['ID'])) {
    die("ID kamar tidak ditemukan di URL!");
}

$id_kamar = intval($_GET['ID']);

// Ambil data utama kamar
$sql_kamar = "SELECT * FROM kamar WHERE ID = $id_kamar";
$q_kamar = mysqli_query($koneksi, $sql_kamar);

// Jika query gagal
if (!$q_kamar) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Jika tidak ada data kamar ditemukan
if (mysqli_num_rows($q_kamar) == 0) {
    die("Data kamar dengan ID $id_kamar tidak ditemukan.");
}

$kamar = mysqli_fetch_assoc($q_kamar);

// Ambil gambar detail dari tabel kamar_detail
$sql_detail = "SELECT * FROM kamar_detail WHERE ID_Kamar = $id_kamar";
$q_detail = mysqli_query($koneksi, $sql_detail);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kamar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background: url('../gambar/kos.jpeg') no-repeat center center fixed;
        background-size: cover;
        color: white;
    }

    .overlay {
        background-color: rgba(0, 0, 0, 0.8);
        border-radius: 10px;
        padding: 30px;
    }

    .img-detail {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="overlay">
            <h2 class="mb-4 text-center">
                Detail Kamar: <?php echo strtoupper(htmlspecialchars($kamar['Nama_Kamar'])); ?>
            </h2>

            <div class="row mb-4">
                <div class="col-md-6">
                    <img src="../gambar/<?php echo htmlspecialchars($kamar['Gambar_Kamar']); ?>"
                        class="img-fluid rounded" alt="Gambar Kamar">
                </div>
                <div class="col-md-6">
                    <h4>Harga: Rp <?php echo htmlspecialchars($kamar['Harga']); ?></h4>
                    <p><strong>Fasilitas:</strong> <?php echo nl2br(htmlspecialchars($kamar['Fasilitas'])); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($kamar['Status']); ?></p>
                </div>
            </div>

            <h4 class="mt-4">Foto Tambahan</h4>
            <div class="row">
                <?php
                if (mysqli_num_rows($q_detail) > 0) {
                    while ($detail = mysqli_fetch_assoc($q_detail)) { ?>
                <div class="col-md-4 mb-3">
                    <img src="../gambar/gambar_detail/<?php echo htmlspecialchars($detail['Gambar_Detail']); ?>"
                        class="img-detail" alt="Gambar Detail Kamar">
                </div>
                <?php }
                } else {
                    echo "<p class='text-center'>Tidak ada foto tambahan untuk kamar ini.</p>";
                }
                ?>
            </div>

            <a href="tes.php" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</body>

</html>