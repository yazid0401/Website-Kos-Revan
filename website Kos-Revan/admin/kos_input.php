<?php include("inc_header.php"); ?>
<?php
$nama = "";
$harga = "";
$gambar = "";
$fasilitas = "";
$status = "";
$error = "";
$sukses = "";

if (isset($_POST["simpan"])) {
    $nama = $_POST["Nama_Kamar"];
    $harga = $_POST["Harga"];
    $gambar = $_FILES["Gambar_Kamar"]["name"];
    $tmp = $_FILES["Gambar_Kamar"]["tmp_name"];

    $fasilitas = $_POST["Fasilitas"];
    $status = $_POST["Status"];

    if ($nama == "" or $harga == "" or $fasilitas == "" or $status == "") {
        $error = "Semua Kolom Harus Di isi";
    }

    if (empty($error)) {
        $sql1 = "insert into kamar(Nama_Kamar, Harga, Gambar_Kamar, Fasilitas, Status) values('$nama', '$harga', '$gambar' ,'$fasilitas' ,'$status')";
        $location = '../gambar/' . $gambar;
        move_uploaded_file($tmp, $location);
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Sukses Memasukkan Data";
        } else {
            $error = "Gagal Memasukkan Data";
        }
    }
}

?>
<div class="container mt-4">
    <h1>Halaman Admin Input Data Kos Baru</h1>
    <a href="kos.php" class="btn btn-secondary btn-sm mb-3">&laquo; Kembali</a>
    <?php
    if ($error) {
        ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
        <?php
    }
    ?>
    <?php
    if ($sukses) {
        ?>
        <div class="alert alert-primary" role="alert">
            <?php echo $sukses; ?>
        </div>
        <?php
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3 row">
            <label for="Nama_Kamar" class="col-sm-2 col-form-label">Nama Kamar</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="Nama_Kamar" value="<?php echo $nama ?>" name="Nama_Kamar">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="Harga" class="col-sm-2 col-form-label">Harga</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="Harga" value="<?php echo $harga ?>" name="Harga">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="Gambar_Kamar" class="col-sm-2 col-form-label">Gambar</label>
            <div class="col-sm-10">
                <input type="file" name="Gambar_Kamar" class="form-control" value="<?php echo $gambar ?>"
                    name="Gambar_Kamar">
            </div>
        </div>
        <!-- <div class="mb-3 row">
        <label for="Gambar_Kamar" class="col-sm-2 col-form-label">Gambar</label>
        <div class="col-sm-10">
            <textarea name="Gambar_Kamar" class="form-control" id="summernote"><?php echo $gambar ?></textarea>
        </div>
    </div> -->
        <div class="mb-3 row">
            <label for="Fasilitas" class="col-sm-2 col-form-label">Fasilitas</label>
            <div class="col-sm-10">
                <textarea name="Fasilitas" class="form-control"><?php echo $fasilitas ?></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="Status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="Status" value="<?php echo $status ?>" name="Status">
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
            </div>
        </div>


    </form>
</div>
<?php include("inc_footer.php"); ?>