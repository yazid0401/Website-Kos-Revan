<?php include("inc_header.php");

$error = "";
$sukses = "";

if (!isset($_GET["ID"])) {
    header("Location: kos.php");
    exit;
}
$id = $_GET["ID"];

$sql1 = "SELECT * FROM kamar WHERE ID = '$id'";
$result = mysqli_query($koneksi, $sql1);
$r1 = mysqli_fetch_assoc($result);

$nama = $r1["Nama_Kamar"] ?? "";
$harga = $r1["Harga"] ?? "";
$gambar_lama = $r1["Gambar_Kamar"] ?? "";
$fasilitas = $r1["Fasilitas"] ?? "";
$status = $r1["Status"] ?? "";

if (isset($_POST["simpan"])) {
    $nama = $_POST["Nama_Kamar"];
    $harga = $_POST["Harga"];
    $fasilitas = $_POST["Fasilitas"];
    $status = $_POST["Status"];

    $gambar = $_FILES["Gambar_Kamar"]["name"] ?? "";
    $tmp = $_FILES["Gambar_Kamar"]["tmp_name"] ?? "";

    if ($nama == "" || $harga == "" || $fasilitas == "" || $status == "") {
        $error = "Semua kolom harus diisi!";
    } else {
        if (!empty($gambar)) {
            $lokasi = "../gambar/" . $gambar;
            move_uploaded_file($tmp, $lokasi);
            $gambar_query = ", Gambar_Kamar = '$gambar'";
        } else {
            $gambar_query = "";
        }

        $sqlup = "UPDATE kamar SET
            Nama_Kamar = '$nama',
            Harga = '$harga',
            Fasilitas = '$fasilitas',
            Status = '$status'
            $gambar_query
            WHERE ID = '$id'";

        if (mysqli_query($koneksi, $sqlup)) {
            $sukses = "Data berhasil diperbarui!";
            header("Location: kos.php");
            exit;
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
        }
    }
}
?>


<h1>Halaman Admin Input Data Kos Baru</h1>
<div class="mb-3 row">
    <a href="kos.php">
        << Kembali ke halaman admin</a>
</div>
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
        <label for="ID" class="col-sm-2 col-form-label">ID</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="ID" value="<?php echo $id ?>" name="ID" readonly>
        </div>
    </div>
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
<?php include("inc_footer.php"); ?>