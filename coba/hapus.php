<?php
include 'config.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $conn->query("DELETE FROM mahasiswa WHERE id = $id");
}

// langsung redirect
header("Location: index.php");
exit;