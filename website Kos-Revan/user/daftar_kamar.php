<?php
include("inc_header.php");

$sql = "SELECT * FROM kamar";
$q = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Kamar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background: url('../gambar/kos.jpeg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Inter', sans-serif;
    }

    .container {}

    .card {
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        border: none;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        text-transform: uppercase;
    }

    .card-body {
        text-align: center;
    }

    .btn-detail {
        background-color: #6c3b1c;
        color: white;
        border-radius: 25px;
        padding: 8px 20px;
        transition: 0.3s;
    }

    .btn-detail:hover {
        background-color: #8b4b27;
        color: #fff;
    }

    .overlay {
        background-color: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(3px);
        border-radius: 10px;
        padding: 30px;
    }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="text-center text-black fw-bold mb-4 my-5">Daftar Kamar Kos</h2>

        <div class="overlay my-5">
            <div class="row g-4">
                <?php
                while ($row = mysqli_fetch_assoc($q)) {
                    $gambarPath = "../gambar/" . $row['Gambar_Kamar'];
                    $namaKamar = strtoupper($row['Nama_Kamar']);
                    ?>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <?php if (file_exists($gambarPath)) { ?>
                        <img src="<?php echo $gambarPath; ?>" alt="Gambar Kamar">
                        <?php } else { ?>
                        <img src="../gambar/default.jpg" alt="Tidak Ada Gambar">
                        <?php } ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $namaKamar; ?></h5>
                            <p class="mb-2"><?php echo $row['Harga']; ?></p>
                            <a href="detail_kamar.php?ID=<?php echo $row['ID']; ?>" class="btn btn-primary btn-sm">
                                Detail
                            </a>

                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d772.02051339005!2d106.87146018629493!3d-6.268345189572992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sid!2sid!4v1760792036806!5m2!1sid!2sid"
            width="1090" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe> -->
    </div>

</body>
<?php include("inc_footer.php"); ?>

</html>