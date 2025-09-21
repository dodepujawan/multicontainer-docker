<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $conn->query("INSERT INTO mahasiswa (nama) VALUES ('$nama')");
    header("Location: index.php");
    exit;
}
?>

<h2>Tambah Mahasiswa</h2>
<form method="POST">
    Nama: <input type="text" name="nama">
    <input type="submit" name="submit" value="Simpan">
</form>
