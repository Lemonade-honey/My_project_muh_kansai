<?php
    require 'admin/src/include/connectDB.php';
    include 'include_main/session_manage.php';
    include 'include_main/include.timeline.php';
    include 'include_main/image_slide.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Musilmah Muhammadiyah organization for the public affiliated in Kansai, Japan. 
    Special Branch Muhammadiyah (PRIM) Kansai was founded on October 31, 2020 by several pioneer cadres and the next day 
    immediately started the Morning Prayer activities to facilitate reading and memorizing Juz Amma.">
    <!-- link css -->
    <link rel="stylesheet" href="style/css/global_style.css">
    <link rel="stylesheet" href="style/css/index_style.css">
    <link rel="stylesheet" href="style/css/login_style.css">
    <link rel="stylesheet" href="style/css/main_navbar_style.css">
    <link rel="stylesheet" href="style/css/footer_index.css">
    <link rel="stylesheet" href="style/css/image_slider.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- animation link -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- script -->
    <script src="js/image_slider.js" defer></script>
    <script src="js/language_pop_up.js" defer></script>


    <!-- web logo icon -->
    <link rel="shortcut icon" href="images/web-icon.png" type="image/x-icon">
    <title>Muhammadiyah Kansai</title>
</head>
<body>
    
    <?php
        include 'include_main/main_navbar.php';
    ?>

    <!--======== image slider start =========-->
    <div class="images-slider" data-carousel>
        <div class="slider" data-slides>
            <div class="slide" data-active>
                <img src="admin/src/image_slide/images/<?php echo $image[0]?>" />
            </div>
            <div class="slide">
                <img src="admin/src/image_slide/images/<?php echo $image[1]?>" />
            </div>
            <div class="slide">
                <img src="admin/src/image_slide/images/<?php echo $image[2]?>" />
            </div>
        </div>
        <div id="nav-button-sebelum" class="slider-button" data-carousel-button="sebelum"></div>
        <div id="nav-button-sesudah" class="slider-button" data-carousel-button="sesudah"></div>
    </div>
    <!--======== image slider end =========-->
    <div class="section-color">
        <section>
            <div class="home-container">
                <div class="home-image" data-aos="fade-right" data-aos-delay="400">
                    <img src="images/home_index/home-judul.png" alt="gambar page #1" loading="lazy">
                </div>
                <div class="home-content" data-aos="fade-left">
                    <h1>Muhammadiyah Kansai</h1>
                    <p>Musilmah Muhammadiyah organization for the public affiliated in Kansai, Japan</p>
                </div>
            </div>
        </section>
    </div>
    <section>
        <div class="home-deskripsi" data-aos="fade-up" data-aos-delay="350">
            <p>Special Branch Muhammadiyah (PRIM) Kansai was founded on October 31, 2020 by several pioneer cadres and the next day immediately started the Morning Prayer activities to facilitate reading and memorizing Juz Amma. Morning Prayer is done <a href="sejarah.html">...read more</a></p>
        </div>
    </section>

    <div class="section-color">
        <section>
            <div class="judul-visi-misi"><h1>Our Vision and Mission</h1></div>
            <div class="visi-misi">
                <div class="visi" data-aos="slide-right">
                    <h2>Vision</h2>
                    <p>Participate in creating a real Islamic society that can lead to the gates of heaven "Jannatun Na'im" with the pleasure of Allah, the Rahman and Rahim.</p>
                </div>
                <div class="misi" data-aos="slide-left" data-aos-delay="200">
                    <h2>Mission</h2>
                    <p>Participate in implementing progressive Islam which is manifested in the form of business in the form of charitable efforts, programs and activities in all areas of life.</p>
                </div>
            </div>
        </section>
    </div>

    <section id="lokasi">
        <div class="lokasi-container">
            <div class="judul-lokasi" data-aos="zoom-in-left">
                <h1>Our Location</h1>
                <p>We are located in Japan, the Kansai region to be precise. see us <a href="#" style="text-decoration: underline;">on google maps</a></p>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2285.4808733271084!2d135.56004306613363!3d34.56656088550357!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6000d9aaf4ac54e5%3A0xeb71de69471d2ba2!2sShibagaki%2C%20Matsubara%2C%20Prefektur%20Osaka%20580-0017%2C%20Jepang!5e0!3m2!1sid!2sid!4v1669869146862!5m2!1sid!2sid" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" width="600" height="450" 
            style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" data-aos="zoom-in-right" data-aos-delay="400"></iframe>
        </div>
    </section>

    <section id="kegiatan">
        <div class="judul-kegiatan" data-aos="fade-down"><h1>Our Activity</h1></div>
        <div class="kegiatan-container">
            <div class="sub-container" data-aos="zoom-in">
                <div class="gambar"><img src="images/home_index/pengajian.png" alt="" loading="lazy"></div>
                <h2>recitation 'Aisyiyah Wal' Ashri</h2>
            </div>
            <div class="sub-container" data-aos="zoom-in" data-aos-delay="200">
                <div class="gambar"><img src="images/home_index/one-night-one-just.png" alt="" loading="lazy"></div>
                <h2>one night one juz</h2>
            </div>
            <div class="sub-container" data-aos="zoom-in" data-aos-delay="400">
                <div class="gambar"><img src="images/home_index/silaturahmi.png" alt="" loading="lazy"></div>
                <h2>Indonesia-Japan Muslim Forum</h2>
            </div>
        </div>
    </section>

    <section id="timeline">
        <div class="judul-timeline"><h1 style="margin-top: 2rem;">Timeline Event this week</h1></div>
        <div class="no-agenda">
            <div class="content">
                <img src="images/timeline_index/tidak-ada-agenda.png" alt="" loading="lazy">
                <p>there are no events this week</p>
            </div>
        </div>
        <div class="total-agenda" id="event"></div>
        <div class="timeline-container">
        <?php while(mysqli_stmt_fetch($stmt)){ if(eventDisplay($time_end, $time_local, $event_start, $param_date_now) === true){ ?>
            <div class="agenda">
                <div class="agenda-atas">
                    <div class="waktu-agenda"><?php echo date("H:i", strtotime($time_start)) . " - " . date("H:i a", strtotime($time_end))?></div>
                    <div class="status-agenda"><?php status($event_start, $time_start, $time_end, $time_local, $param_date_now);?></div>
                </div>
                <div class="agenda-tengah">
                    <div class="judul-agenda"><h3><?php echo $event_name?></h3></div>
                    <div class="tanggal-agenda"><?php echo date("l", strtotime($event_start)) .", ". date("d F Y", strtotime($event_start))?></div>
                    <div class="pemateri-agenda"><span>Speaker</span> <?php echo $speaker?></div>
                    <div class="deskripsi-agenda"><?php echo $desc ?></div>
                </div>
                <div class="agenda-bawah">
                    <div class="lokasi">
                        <p><span>Location</span> <?php splitData($location, 0)?></p>
                        <p><a href="<?php splitData($location, 1)?>"><?php splitData($location, 1)?></a></p>
                    </div>
                    <div class="links">
                        <?php $data = array($links); foreach($data as $key){?>
                        <div class="link">
                            <div class="judul-link"><?php splitData($key, 0)?></div>
                            <a href="<?php splitData($key, 0)?>"><?php splitData($key, 0)?></a>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        <?php } } mysqli_stmt_close($stmt);?>
            
            
        </div>
    </section>

    <section>
        <div class="sosial-links-container">
            <div class="gambar-pesawat" data-aos="flip-up">
                <img src="images/home_index/kertas_terbang.png" alt="">
            </div>
            <div class="sosial-content" data-aos="fade-down-right" data-aos-delay="400">
                <div class="judul-sosial-links"><h1>join and follow us</h1></div>
                <div class="links">
                    <a href="https://www.facebook.com/people/Pengajian-Hidayah-Kansai/100075339490047/"><img src="images/sosial-icons/facebook.png" alt=""></a>
                    <a href="https://www.instagram.com/hidayah_kansai/"><img src="images/sosial-icons/instagram.png" alt=""></a>
                    <a href="https://line.me/ti/p/tRh5qZMPgX"><img src="images/sosial-icons/line.png" alt=""></a>
                    <a href="https://www.youtube.com/channel/UCUy-zTRjTlZooPkLsuRRsWg"><img src="images/sosial-icons/youtube.png" alt=""></a>
                </div>
            </div>
        </div>
    </section>

    <!-- <section>
        <div class="judul-berita"><h1>headlines</h1></div>
        <div class="berita-container">
            <div class="box-berita">
                <a href="">
                    <img src="images/japan.jpg" alt="">
                    <h2>judul berita</h2>
                </a>
            </div>
            <div class="box-berita">
                <a href="">
                    <img src="images/japan.jpg" alt="">
                    <h2>judul berita</h2>
                </a>
            </div>
            <div class="box-berita">
                <a href="">
                    <img src="images/japan.jpg" alt="">
                    <h2>judul berita</h2>
                </a>
            </div>
        </div>
    </section> -->

    <?php
        include 'include_main/main_footer.php';
    ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="js/timeline.js"></script>
    <script>
        // animation 
        AOS.init();
    </script>
</body>
</html>