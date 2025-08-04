<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan']);

    if (!empty($nama) && !empty($pesan)) {
        $sql = "INSERT INTO ucapan (nama, pesan) VALUES ('$nama', '$pesan')";
        mysqli_query($koneksi, $sql);
    }
}

// Tambahkan ?opened=true pada redirect
header("Location: index.php?opened=true#guestbook-section");
exit();
?>