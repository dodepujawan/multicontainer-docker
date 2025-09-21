<?php
include 'config.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Kalau form disubmit → update data
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $conn->query("UPDATE mahasiswa SET nama='$nama' WHERE id=$id");
    header("Location: index.php");
    exit; // penting untuk hentikan eksekusi setelah redirect
}

// Kalau belum disubmit → ambil data untuk form
$result = $conn->query("SELECT * FROM mahasiswa WHERE id=$id");
$data = $result->fetch_assoc();
?>

<h2>Edit Mahasiswa</h2>
<form method="POST">
    Nama: <input type="text" name="nama" value="<?php echo $data['nama']; ?>">
    <input type="submit" name="submit" value="Update">
</form>

