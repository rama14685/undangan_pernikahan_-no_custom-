<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $status_kehadiran = mysqli_real_escape_string($koneksi, $_POST['status_kehadiran']);

    if (!empty($nama_lengkap) && !empty($no_hp) && !empty($status_kehadiran)) {
        $sql = "INSERT INTO rsvp (nama_lengkap, no_hp, status_kehadiran) VALUES ('$nama_lengkap', '$no_hp', '$status_kehadiran')";

        if (mysqli_query($koneksi, $sql)) {
            if ($status_kehadiran == 'Hadir') {
                $_SESSION['rsvp_feedback'] = 'hadir_sukses';
            } else {
                $_SESSION['rsvp_feedback'] = 'tidakhadir_sukses';
            }
        } else {
            $_SESSION['rsvp_feedback'] = 'error';
        }
    } else {
         $_SESSION['rsvp_feedback'] = 'error';
    }
}

// Tambahkan ?opened=true pada redirect
header("Location: index.php?opened=true#rsvp-section");
exit();
?>