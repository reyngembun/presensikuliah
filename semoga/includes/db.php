<?php
$host_db = "localhost";
$user_db = "root";
$pass_db = "";
$nama_db = "absenreal";

$conn = mysqli_connect($host_db, $user_db, $pass_db, $nama_db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>