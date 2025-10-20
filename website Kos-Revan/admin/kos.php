<?php include("inc_header.php"); ?>
<?php
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "delete from kamar where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    }
}
?>
<div class="container mt-4">
    <h1>Manajemen Kamar Kos</h1>
    <p>
        <a href="kos_input.php">
            <input type="button" class="btn btn-primary" value="Tambah Data Kos Baru" />
        </a>
    </p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="col-1">ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Fasilitas</th>
                <th>Status</th>
                <th class="col-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sukses = "";
            $sql1 = "select * from kamar order by id asc";
            $q1 = mysqli_query($koneksi, $sql1);

            while ($r1 = mysqli_fetch_array($q1)) {
                ?>
                <?php
                if ($sukses) {
                    ?>
                    <div class="alert alert-primary" role="alert">
                        <?php echo $sukses ?>
                    </div>
                    <?php
                }
                ?>
                <tr>
                    <td><?php echo $r1['ID'] ?></td>
                    <td><?php echo $r1['Nama_Kamar'] ?></td>
                    <td><?php echo $r1['Harga'] ?></td>
                    <td><?php echo $r1['Gambar_Kamar'] ?></td>
                    <td><?php echo $r1['Fasilitas'] ?></td>
                    <td><?php echo $r1['Status'] ?></td>
                    <td>
                        <a href="edit_kos.php?ID=<?php echo $r1['ID'] ?>">
                            <span class="badge bg-warning text-dark">Edit</span>
                        </a>

                        <a href="kos.php?op=delete&id=<?php echo $r1['ID'] ?>"
                            onclick="return confirm('Apakah yakin mau hapus data?')">
                            <span class="badge bg-danger">Delete</span>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>

        </tbody>
    </table>
</div>
<?php include("inc_footer.php"); ?>