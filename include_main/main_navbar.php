<?php
    session_start();
    error_reporting(E_ERROR);

    $email = $_SESSION["email"];
    $name  = $_SESSION["name"];
    $id    = $_SESSION["id"];

    // login show
    $name_view = substr($name, 0, 2);
?>
<header>
    <div class="wrapper">
        <nav>
            <input type="checkbox" id="show-menu">
            <label for="show-menu" class="menu-icon"><i class="fas fa-bars"></i></label>
            <div class="content-navbar">
                <div class="logo"><a href="index.html">HIDAYAH</a></div>
                <ul class="links-navbar">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="news.php">News</a></li>
                    <li><a href="history.html">About Us</a></li>
                    <li><a href="index.php#timeline">Today Activity</a></li>
                    <!-- <li>
                        <a href="#" class="desktop-link">Activity <i class="fa fa-caret-down"></i></a>
                        <input type="checkbox" id="show-features">
                        <label for="show-features">Activity <i class="fa fa-caret-down"></i></label>
                        <ul>
                            <li><a href="index.php#timeline">Timeline Activity</a></li>
                            <li><a href="#">Tansinul Qur'an</a></li>
                            <li><a href="#">Pengajian</a></li>
                            <li><a href="#">Drop Menu 4</a></li>
                        </ul>
                    </li> -->
                    <li><a href="https://muhammadiyah.or.id/">about muhammadiyah</a></li>
                </ul>
            </div>
            <div class="language">
                <!-- <a href="#">
                    <div class="globe">
                        <img src="images/language.png" alt="">
                    </div>
                </a> -->
            </div>
        </nav>
    </div>

    <div class="form-pop-up">
        <div class="form-container">
            <div class="cancel" id="form-close">X</div>
            <h1>Select language</h1>
            <div class="flag">
                <a href="#idn">
                    <div class="country">
                        <img src="images/language/indonesia.png" alt="">
                    </div>
                </a>
                <a href="#eng">
                    <div class="country">
                        <img src="images/language/usa.png" alt="">
                    </div>
                </a>
                <a href="#japan">
                    <div class="country">
                        <img src="images/language/japan.png" alt="">
                    </div>
                </a>
            </div>
        </div>
    </div>

</header>