<?php
include("inc_header.php");
include("../inc/inc_koneksi.php");

$id = "";
$id_kamar = "";
$gambar_detail = "";
$error = "";
$sukses = "";

// --- HAPUS DATA ---
if (isset($_GET['op']) && $_GET['op'] == 'delete') {
    $id = $_GET['id'];
    $sqlDel = "DELETE FROM kamar_detail WHERE ID = '$id'";
    $qDel = mysqli_query($koneksi, $sqlDel);
    if ($qDel) {
        $sukses = "Data berhasil dihapus";
    } else {
        $error = "Gagal menghapus data";
    }
}

// --- EDIT DATA ---
if (isset($_GET['op']) && $_GET['op'] == 'edit') {
    $id = $_GET['id'];
    $sqlEdit = "SELECT * FROM kamar_detail WHERE ID = '$id'";
    $qEdit = mysqli_query($koneksi, $sqlEdit);
    $r = mysqli_fetch_array($qEdit);
    if ($r) {
        $id_kamar = $r['ID_Kamar'];
        $gambar_detail = $r['Gambar_Detail'];
    } else {
        $error = "Data tidak ditemukan";
    }
}

// --- SIMPAN DATA ---
if (isset($_POST['simpan'])) {
    $id_kamar = $_POST['ID_Kamar'];
    $gambar_baru = $_FILES['Gambar_Detail']['name'];
    $tmp = $_FILES['Gambar_Detail']['tmp_name'];

    if ($id_kamar == "") {
        $error = "Kamar harus dipilih!";
    }

    if (isset($_POST['simpan'])) {
        $id_kamar = $_POST['ID_Kamar'];
        $files = $_FILES['Gambar_Detail'];

        if ($id_kamar == "") {
            $error = "Kamar harus dipilih!";
        }

        if (empty($error)) {
            // Loop untuk setiap file yang diupload
            for ($i = 0; $i < count($files['name']); $i++) {
                $namaFile = $files['name'][$i];
                $tmpFile = $files['tmp_name'][$i];

                if ($namaFile != "") {
                    $lokasi = "../gambar/gambar_detail/" . $namaFile;
                    move_uploaded_file($tmpFile, $lokasi);

                    // Simpan ke database
                    $sqlInsert = "INSERT INTO kamar_detail (ID_Kamar, Gambar_Detail) 
                              VALUES ('$id_kamar', '$namaFile')";
                    $qInsert = mysqli_query($koneksi, $sqlInsert);
                }
            }

            if ($qInsert) {
                $sukses = "Semua gambar berhasil ditambahkan";
            } else {
                $error = "Gagal menambahkan data ke database";
            }
        }
    }

}
?>

<div class="container mt-4">
    <h1>Manajemen Gambar Detail Kamar</h1>
    <!-- <a href="kos.php" class="btn btn-secondary btn-sm mb-3">&laquo; Kembali</a> -->

    <!-- Alert -->
    <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($sukses): ?>
    <div class="alert alert-success"><?php echo $sukses; ?></div>
    <?php endif; ?>

    <!-- Form Input -->
    <form action="" method="post" enctype="multipart/form-data" class="border p-3 rounded bg-light mb-4">
        <div class="mb-3">
            <label for="ID_Kamar" class="form-label">Pilih Kamar</label>
            <select name="ID_Kamar" class="form-select" required>
                <option value="">-- Pilih Kamar --</option>
                <?php
                $qKamar = mysqli_query($koneksi, "SELECT ID, Nama_Kamar FROM kamar ORDER BY Nama_Kamar ASC");
                while ($rKamar = mysqli_fetch_assoc($qKamar)) {
                    $selected = ($rKamar['ID'] == $id_kamar) ? "selected" : "";
                    echo "<option value='{$rKamar['ID']}' $selected>{$rKamar['Nama_Kamar']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <div class="col-sm-10">
                <input type="file" name="Gambar_Detail[]" multiple class="form-control">
                <small class="text-muted">Kamu bisa memilih lebih dari satu gambar.</small>
            </div>
            <?php if ($gambar_detail): ?>
            <small class="text-muted d-block mt-2">Gambar saat ini:</small>
            <img src="../gambar/gambar_detail/<?php echo $gambar_detail; ?>" alt="Gambar" width="120"
                class="rounded shadow-sm">
            <?php endif; ?>
        </div>

        <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
    </form>

    <!-- Tabel Data -->
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr class="text-center">
                <th>No</th>
                <th>Nama Kamar</th>
                <th>Gambar Detail</th>
                <th width="150px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT kd.*, k.Nama_Kamar 
                     FROM kamar_detail kd 
                     LEFT JOIN kamar k ON kd.ID_Kamar = k.ID
                     ORDER BY kd.ID DESC";
            $q2 = mysqli_query($koneksi, $sql2);
            $no = 1;
            while ($r2 = mysqli_fetch_array($q2)) {
                echo "<tr>
                    <td class='text-center'>$no</td>
                    <td>{$r2['Nama_Kamar']}</td>
                    <td class='text-center'>
                        <img src='../gambar/gambar_detail/{$r2['Gambar_Detail']}' width='100' class='rounded'>
                    </td>
                    <td class='text-center'>
                        <a href='?op=edit&id={$r2['ID']}' class='btn btn-sm btn-warning'>Edit</a>
                        <a href='?op=delete&id={$r2['ID']}' class='btn btn-sm btn-danger' 
                            onclick='return confirm(\"Yakin mau hapus gambar ini?\")'>Hapus</a>
                    </td>
                </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>

<?php include("inc_footer.php"); ?>