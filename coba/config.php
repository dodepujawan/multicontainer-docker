<?php
$host = "mysql";   // pakai nama service di docker-compose
$user = "root";
$pass = "root";
$db   = "latihan";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
