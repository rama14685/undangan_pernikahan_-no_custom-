<?php
// Memulai session di baris paling atas
session_start();

include 'koneksi.php';

// Variabel
$namaPria = "Krisna adi Irawan";
$namaWanita = "Ainun prapti";
$namaBapakPria = "Bapak Jarwanto";
$namaIbuPria = "Ibu Sukirah";
$namaBapakWanita = "Bapak Sagi";
$namaIbuWanita = "Ibu Sugiyarti";
$namaPanggilanPria = "Krisna";
$namaPanggilanWanita = "Ainun";

$tanggalAcara = "2025-11-08T09:00:00";
$waktuResepsi = "08:00 - 09:00 <br> ( lamaran ) <br> 13:00 - 15:00 <br> ( Resepsi )";
$lokasiTeks = "Jl. Trajutrisno Raya, Semarang";
$koordinat = "-6.979381402954114,110.39793039824535";
$linkGoogleMaps = "https://www.google.com/maps/search/?api=1&query=" . $koordinat;

// --- Persiapan untuk Link Google Calendar ---
date_default_timezone_set('Asia/Jakarta');
$startTime = new DateTime('2025-11-08 09:00:00');
$endTime = new DateTime('2025-11-08 14:00:00');
$gcal_dates = $startTime->format('Ymd\THis') . '/' . $endTime->format('Ymd\THis');
$gcal_title = urlencode("Pernikahan Krisna & Ainun");
$gcal_location = urlencode($lokasiTeks);
$gcal_link = "https://www.google.com/calendar/render?action=TEMPLATE&text={$gcal_title}&dates={$gcal_dates}&location={$gcal_location}&sf=true&output=xml";
// --- Selesai Persiapan ---

// Ambil data ucapan
$ucapan_tersimpan = [];
$sql_ucapan = "SELECT nama, pesan FROM ucapan ORDER BY id DESC";
$hasil_ucapan = mysqli_query($koneksi, $sql_ucapan);
if (mysqli_num_rows($hasil_ucapan) > 0) {
    while($row = mysqli_fetch_assoc($hasil_ucapan)) {
        $ucapan_tersimpan[] = $row;
    }
}

// Cek apakah undangan sudah dibuka
$isOpened = isset($_GET['opened']) && $_GET['opened'] === 'true';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Invitation — <?= $namaPria ?> & <?= $namaWanita ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <audio id="background-music" loop>
        <source src="audio/Instrumen.mp3" type="audio/mpeg">
    </audio>

    <div id="cover-page" class="<?= $isOpened ? 'hidden' : '' ?>">
        <div class="cover-content">
            <p>The Wedding Of</p>
            <h1><?= $namaPanggilanPria ?> & <?= $namaPanggilanWanita ?></h1>
            <a href="?opened=true" id="open-invitation-btn" class="button">Buka Undangan</a>
        </div>
    </div>

    <div id="main-content" class="<?= !$isOpened ? 'hidden' : '' ?>">
        <header class="hero">
            <div class="hero-text">
                <h1>Wedding Invitation</h1>
            </div>
        </header>

        <main>
            <section class="profile-section" data-aos="fade-up" style="background-image: url('foto/ainun.jpg');">
                <div class="profile-content">
                    <h3><?= $namaWanita ?></h3>
                    <p>Putri dari</p>
                    <p class="parents"><?= $namaBapakWanita ?> & <?= $namaIbuWanita ?></p>
                </div>
            </section>

            <div class="section-separator" data-aos="zoom-in"></div>
            
            <section class="profile-section" data-aos="fade-up" style="background-image: url('foto/krisna.jpg');">
                 <div class="profile-content">
                    <h3><?= $namaPria ?></h3>
                    <p>Putra dari</p>
                    <p class="parents"><?= $namaBapakPria ?> & <?= $namaIbuPria ?></p>
                </div>
            </section>
            
            <section class="intro-section" data-aos="fade-up">
                <p>"Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang. Sungguh, pada yang demikian itu benar-benar terdapat tanda-tanda (kebesaran Allah) bagi kaum yang berpikir."</p>
                <cite>QS. Ar-Rum: 21</cite>
            </section>

            <section class="details-section">
                <div class="batik-accent"></div>
                <h2 data-aos="fade-up">Save The Date</h2>
                <div class="event-time" data-aos="fade-up" data-aos-delay="100">
                    <p class="date"><?= date('l, d F Y', strtotime($tanggalAcara)) ?></p>
                    <p class="time"><?= $waktuResepsi ?></p>
                </div>
                <div class="event-location" data-aos="fade-up" data-aos-delay="200">
                    <p><?= $lokasiTeks ?></p>
                    <a href="<?= $linkGoogleMaps ?>" target="_blank" class="map-button">Lihat Lokasi</a>
                </div>
            </section>
            
            <section class="rsvp-section" id="rsvp-section" data-aos="fade-up">
                <h2>Konfirmasi Kehadiran</h2>
                
                <?php if (isset($_SESSION['rsvp_feedback'])): ?>
                    <div class="rsvp-feedback success">
                        <?php if ($_SESSION['rsvp_feedback'] == 'hadir_sukses'): ?>
                            <p>Terima kasih atas konfirmasi kehadiran Anda. Sampai jumpa di hari bahagia kami!</p>
                            <div class="calendar-buttons">
                                <a href="<?= $gcal_link ?>" target="_blank" class="calendar-btn">Tambahkan ke Google Calendar</a>
                                <a href="download_ics.php" class="calendar-btn">Simpan ke Kalender Lain</a>
                            </div>
                        <?php elseif ($_SESSION['rsvp_feedback'] == 'tidakhadir_sukses'): ?>
                            <p>Terima kasih atas konfirmasinya. Kami turut mendoakan yang terbaik untuk Anda.</p>
                        <?php else: ?>
                            <p>Terjadi kesalahan. Mohon coba lagi.</p>
                        <?php endif; ?>
                    </div>
                    <?php unset($_SESSION['rsvp_feedback']); ?>
                <?php else: ?>
                    <p class="rsvp-intro">Mohon konfirmasikan kehadiran Anda untuk membantu kami mempersiapkan acara ini dengan lebih baik.</p>
                    <form id="rsvp-form" class="rsvp-form" method="POST" action="simpan_rsvp.php">
                        <div class="rsvp-card">
                            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap Anda" required>
                            <input type="tel" name="no_hp" placeholder="No. WhatsApp / HP" required>
                            <div class="rsvp-choice">
                                <input type="radio" id="hadir" name="status_kehadiran" value="Hadir" checked>
                                <label for="hadir">✓ Hadir</label>
                                <input type="radio" id="tidak-hadir" name="status_kehadiran" value="Tidak Hadir">
                                <label for="tidak-hadir">✕ Tidak Hadir</label>
                            </div>
                            <button type="submit">Kirim Konfirmasi</button>
                        </div>
                    </form>
                <?php endif; ?>
            </section>

            <section class="guestbook-section" data-aos="fade-up">
                <h2>Ucapan & Doa</h2>
                <form id="guestbook-form" class="guestbook-form" method="POST" action="simpan_ucapan.php">
                    <input type="text" name="nama" placeholder="Nama Anda" required>
                    <textarea name="pesan" placeholder="Tulis ucapan & doa Anda..." rows="4" required></textarea>
                    <button type="submit">Kirim Ucapan</button>
                </form>
                <div id="guestbook-display" class="guestbook-display">
                    <?php if (!empty($ucapan_tersimpan)): ?>
                        <?php foreach ($ucapan_tersimpan as $ucapan): ?>
                            <div class="guestbook-entry">
                                <h4><?= htmlspecialchars($ucapan['nama']) ?></h4>
                                <p><?= nl2br(htmlspecialchars($ucapan['pesan'])) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="text-align: center;">Jadilah yang pertama memberikan ucapan!</p>
                    <?php endif; ?>
                </div>
            </section>

            <section class="gallery-section" data-aos="fade-up">
                <h2>Our Moments</h2>
                <div class="gallery-container">
                    <div class="gallery-preview">
                        <img src="foto/3.jpg" id="gallery-preview-img" alt="Foto Pilihan">
                    </div>
                    <div class="gallery-thumbnails">
                        <img src="foto/8.jpg" alt="Foto Kenangan 1" class="active-thumbnail">
                        <img src="foto/4.jpg" alt="Foto Kenangan 2">
                        <img src="foto/5.jpg" alt="Foto Kenangan 3">
                        <img src="foto/6.jpg" alt="Foto Kenangan 4">
                        <img src="foto/3.jpg" alt="Foto Kenangan 5">
                        <img src="foto/7.jpg" alt="Foto Kenangan 6">
                    </div>
                </div>
            </section>
            
            <section class="final-section" data-aos="fade-up">
                <p>Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Anda berkenan hadir untuk memberikan doa restu.</p>
                <h2>Terima Kasih <br> Krisna & Ainun</h2>
            </section>
        </main>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({
        duration: 800,
        once: true,
        offset: 20,
      });
    </script>
    
    <script>
        // Musik & Form
        const backgroundMusic = document.getElementById('background-music');
        const isOpened = <?= $isOpened ? 'true' : 'false' ?>;
        if (isOpened) {
            const savedTime = localStorage.getItem('musicCurrentTime');
            if (savedTime) {
                backgroundMusic.currentTime = parseFloat(savedTime);
            }
            backgroundMusic.play().catch(error => {
                document.body.addEventListener('click', () => backgroundMusic.play(), { once: true });
            });
        }
        const openBtn = document.getElementById('open-invitation-btn');
        if (openBtn) {
            openBtn.addEventListener('click', function(event) {
                event.preventDefault(); 
                backgroundMusic.play();
                setTimeout(() => {
                    window.location.href = this.href;
                }, 300);
            });
        }
        const rsvpForm = document.getElementById('rsvp-form');
        const guestbookForm = document.getElementById('guestbook-form');
        function saveMusicTime() {
            localStorage.setItem('musicCurrentTime', backgroundMusic.currentTime);
        }
        if (rsvpForm) { rsvpForm.addEventListener('submit', saveMusicTime); }
        if (guestbookForm) { guestbookForm.addEventListener('submit', saveMusicTime); }

        // Galeri
        const previewImg = document.getElementById('gallery-preview-img');
        const thumbnailImages = document.querySelectorAll('.gallery-thumbnails img');
        thumbnailImages.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                previewImg.src = this.src;
                thumbnailImages.forEach(img => img.classList.remove('active-thumbnail'));
                this.classList.add('active-thumbnail');
            });
        });
    </script>

</body>
</html>