<?php include 'config.php'; ?>

<h2>Daftar Mahasiswa</h2>
<a href="tambah.php">+ Tambah Data</a>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Aksi</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM mahasiswa");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nama']}</td>
                <td>
                    <a href='edit.php?id={$row['id']}'>Edit</a> | 
                    <a href='hapus.php?id={$row['id']}'>Hapus</a>
                </td>
              </tr>";
    }
    ?>
</table>
