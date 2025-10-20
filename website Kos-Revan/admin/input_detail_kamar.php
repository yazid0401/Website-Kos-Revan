<?php
include("inc_header.php");

// Ambil daftar kamar untuk dropdown
$sql_kamar = "SELECT * FROM kamar ORDER BY Nama_Kamar ASC";
$q_kamar = mysqli_query($koneksi, $sql_kamar);

$error = "";
$sukses = "";

if (isset($_POST["simpan"])) {
    $id_kamar = $_POST["ID_Kamar"];
    $files = $_FILES["Gambar_Detail"];

    if (empty($id_kamar)) {
        $error = "Silakan pilih kamar terlebih dahulu!";
    } elseif (empty($files['name'][0])) {
        $error = "Silakan pilih minimal satu gambar untuk diupload!";
    }

    if (empty($error)) {
        // Buat folder tujuan jika belum ada
        $upload_dir = "../gambar/gambar_detail/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $sukses_upload = 0;

        // Loop semua file yang diupload
        for ($i = 0; $i < count($files["name"]); $i++) {
            $nama_file = basename($files["name"][$i]);
            $tmp_file = $files["tmp_name"][$i];
            $target_file = $upload_dir . $nama_file;

            // Cek jika file sudah ada
            if (file_exists($target_file)) {
                $nama_file = time() . "_" . $nama_file; // beri nama unik
                $target_file = $upload_dir . $nama_file;
            }

            if (move_uploaded_file($tmp_file, $target_file)) {
                // Simpan nama file ke database
                $sql_insert = "INSERT INTO kamar_detail (ID_Kamar, Gambar_Detail) 
                               VALUES ('$id_kamar', '$nama_file')";
                mysqli_query($koneksi, $sql_insert);
                $sukses_upload++;
            }
        }

        if ($sukses_upload > 0) {
            $sukses = "Berhasil mengupload $sukses_upload gambar ke kamar ini!";
        } else {
            $error = "Gagal mengupload gambar!";
        }
    }
}
?>

<h1>Tambah Gambar Detail Kamar</h1>
<div class="mb-3 row">
    <a href="kos.php">&lt;&lt; Kembali ke halaman admin</a>
</div>

<?php if ($error) { ?>
<div class="alert alert-danger" role="alert">
    <?php echo $error; ?>
</div>
<?php } ?>

<?php if ($sukses) { ?>
<div class="alert alert-success" role="alert">
    <?php echo $sukses; ?>
</div>
<?php } ?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3 row">
        <label for="ID_Kamar" class="col-sm-2 col-form-label">Pilih Kamar</label>
        <div class="col-sm-10">
            <select name="ID_Kamar" class="form-select">
                <option value="">-- Pilih Kamar --</option>
                <?php while ($row = mysqli_fetch_assoc($q_kamar)) { ?>
                <option value="<?php echo $row['ID']; ?>">
                    <?php echo $row['Nama_Kamar']; ?>
                </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="Gambar_Detail" class="col-sm-2 col-form-label">Upload Gambar Detail</label>
        <div class="col-sm-10">
            <input type="file" name="Gambar_Detail[]" multiple class="form-control">
            <small class="text-muted">Kamu bisa memilih lebih dari satu gambar.</small>
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