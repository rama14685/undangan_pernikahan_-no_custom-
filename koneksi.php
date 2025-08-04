<?php
// Detail koneksi ke database
$host = "localhost";    // Nama server
$user = "root";         // Username database (default XAMPP)
$pass = "";             // Password database (default XAMPP kosong)
$db   = "undangan";     // Nama database yang Anda buat

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>