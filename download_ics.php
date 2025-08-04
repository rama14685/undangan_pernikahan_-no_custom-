<?php
// Atur zona waktu ke Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');

// Detail Acara (sesuaikan jika perlu)
$namaPria = "Krisna adi Irawan";
$namaWanita = "Ainun prapti";
$tanggalMulai = "2025-11-08 09:00:00"; // Format: Y-m-d H:i:s
$tanggalSelesai = "2025-11-08 14:00:00"; // Perkiraan waktu selesai
$lokasi = "Jl. Trajutrisno Raya, Tlogosari Kulon, Semarang";
$deskripsi = "Acara Pernikahan Krisna dan Ainun. Kehadiran Anda sangat berarti bagi kami.";

// --- Konversi Waktu ke UTC (Wajib untuk format .ics) ---
// Buat objek DateTime dari string waktu dan zona waktu asal (Asia/Jakarta)
$dtStart = new DateTime($tanggalMulai, new DateTimeZone('Asia/Jakarta'));
$dtEnd = new DateTime($tanggalSelesai, new DateTimeZone('Asia/Jakarta'));

// Ubah zona waktu ke UTC
$dtStart->setTimezone(new DateTimeZone('UTC'));
$dtEnd->setTimezone(new DateTimeZone('UTC'));

// Format ke dalam format yang dibutuhkan iCalendar (YYYYMMDDTHHMMSSZ)
$utcStart = $dtStart->format('Ymd\THis\Z');
$utcEnd = $dtEnd->format('Ymd\THis\Z');
// --- Selesai Konversi Waktu ---

// Header untuk memberi tahu browser bahwa ini adalah file kalender
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="pernikahan_krisna_ainun.ics"');

// Konten file .ics
echo "BEGIN:VCALENDAR\n";
echo "VERSION:2.0\n";
echo "PRODID:-//YourWebsite//NONSGML v1.0//EN\n";
echo "BEGIN:VEVENT\n";
echo "UID:" . md5(uniqid(mt_rand(), true)) . "@yourwebsite.com\n"; // ID unik acara
echo "DTSTAMP:" . gmdate('Ymd\THis\Z') . "\n";
echo "DTSTART:" . $utcStart . "\n";
echo "DTEND:" . $utcEnd . "\n";
echo "SUMMARY:Pernikahan " . $namaPria . " & " . $namaWanita . "\n";
echo "LOCATION:" . $lokasi . "\n";
echo "DESCRIPTION:" . $deskripsi . "\n";
echo "END:VEVENT\n";
echo "END:VCALENDAR";

exit();
?>