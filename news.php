<?php
    require 'admin/src/include/connectDB.php';
    include 'include_main/include.news.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style/css/global_style.css">
    <link rel="stylesheet" href="style/css/news_style.css">
    <link rel="stylesheet" href="style/css/main_navbar_style.css">
    <link rel="stylesheet" href="style/css/footer_index.css">
    <title>News || Muhammadiyah Kansai</title>
</head>
<body>
    <?php include 'include_main/main_navbar.php' ?>
    <form action="" method="get">
        <section>
            <div class="pencarian">
                <input type="search" class="box" name="data" placeholder="Search...">
                <button type="submit" class="box btn"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="container-berita">
                <div class="container-news">
                    <?php while(mysqli_stmt_fetch($stmt)){ ?>
                        <?php 
                            if($gambar == null){
                                $gambar = "NULL.png";
                            }else{
                                $scan = file_exists('./news/' . $gambar);
                                if($scan == 1){
                                    $gambar = $gambar;
                                }
                                else{
                                    $gambar = "NULL.png";
                                }    
                            } 
                        ?>
                    <a href="view_news.php?news_id=<?php echo $news_id?>&news_tittel=<?php echo $judul?>" class="news">
                        <div class="gambar-berita">
                            <img src="news/<?php echo $gambar?>" alt="" loading="lazy">
                        </div>
                        <div class="judul-berita">
                            <h1><?php echo $judul?></h1>
                            <p><?php echo date("d F Y", strtotime($create_at))?></p>
                        </div>
                    </a>
                    <?php }?>
                </div>
                <div class="container-pin">
                    <p>marked news</p>
                    <ul>
                        <?php foreach($berita_pinned as $pinned){
                            $pisah = explode("||", $pinned);
                            if($pisah[2] >= 1){
                        ?>
                        <li><a href="view_news.php?news_id=<?php echo $pisah[0]?>&news_tittel=<?php echo $pisah[1]?>"><?php echo $pisah[1]?></a></li>
                        <?php } }?>
                    </ul>
                    <p>latest news</p>
                    <ul>
                        <?php foreach($berita_terbaru as $berita) {
                            $pisah = explode("||", $berita);
                        ?>
                        <li><a href="view_news.php?news_id=<?php echo $pisah[0]?>&news_tittel=<?php echo $pisah[1]?>"><?php echo $pisah[1]?></a></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <div class="paggingnation">
            <?php for($i=1; $i<= $pages; $i++){ if(isset($_GET["data"])){?>
                <a class="number" href="?data=<?php echo $_GET["data"]?>&page=<?php echo $i?>"><?php echo $i?></a>
            <?php } else{?>
                <a href="?page=<?php echo $i?>"><?php echo $i?></a>
            <?php } }?>
            </div>
        </section>
        <?php mysqli_stmt_close($stmt)?>
    </form>
    <?php include 'include_main/main_footer.php' ?>
    <script>
        
        let news = document.querySelectorAll(".judul-berita").length
        let container = document.querySelector(".container-pin")
        if(news <= 0){
            container.style.display = 'none'
        }
    </script>
</body>
</html>