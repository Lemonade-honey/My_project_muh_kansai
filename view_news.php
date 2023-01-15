<?php
    require 'admin/src/include/connectDB.php';
    $berita_terbaru = array();
    $berita_pinned = array();
    // newset data detect
    $sql = "SELECT id, judul FROM news ORDER BY id DESC LIMIT 4";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $news_id, $judul);
    while(mysqli_stmt_fetch($stmt)){
        $data = $news_id . "||" . $judul;
        array_push($berita_terbaru, $data);
    }
    mysqli_stmt_close($stmt);

    // pinned news
    $sql = "SELECT id, judul, pinned FROM news ORDER BY id ASC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $news_id, $judul, $pinned);
    while(mysqli_stmt_fetch($stmt)){
        $data = $news_id . "||" . $judul ."||". $pinned;
        array_push($berita_pinned, $data);
    }
    mysqli_stmt_close($stmt);
    
    if(isset($_GET["news_id"])){
        $data = htmlspecialchars(trim($_GET["news_id"]));
        $sql = "SELECT id, judul, deskripsi, gambar, create_at, create_by  FROM news WHERE id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_target);
            $param_target = trim($data);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt, $id_news, $judul, $deskripsi, $gambar, $create_at, $create_by);
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_fetch($stmt);
            }
        }
        
    }else{
        header("location: news.php", true, 301);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/css/global_style.css">
    <link rel="stylesheet" href="style/css/view_news_style.css">
    <link rel="stylesheet" href="style/css/main_navbar_style.css">

    <title>News || Muhammadiyah Kansai</title>
</head>
<body>
    <?php include 'include_main/main_navbar.php' ?>
    <section>
        <div class="news-container">
            <div class="main_news">
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
                <div class="gambar">
                    <img src="news/<?php echo $gambar?>" alt="">
                </div>
                <div class="judul">
                    <h1><?php echo $judul?></h1>
                    <p>by <?php echo $create_by?>, <?php echo date("d F Y", strtotime($create_at))?></p>
                </div>
                <div class="deskripsi">
                    <?php echo $deskripsi?>
                    <!-- <iframe src="" frameborder="0"></iframe> -->
                </div>
            </div>
            <div class="container-pin">
                    <p>newes pined</p>
                    <ul>
                        <?php foreach($berita_pinned as $pinned){
                            $pisah = explode("||", $pinned);
                            if($pisah[2] >= 1){
                        ?>
                        <li><a href="view_news.php?news_id=<?php echo $pisah[0]?>&news_tittel=<?php echo $pisah[1]?>"><?php echo $pisah[1]?></a></li>
                        <?php } }?>
                    </ul>
                    <p>See other newes</p>
                    <ul>
                        <?php foreach($berita_terbaru as $berita) {
                            $pisah = explode("||", $berita);
                        ?>
                        <li><a href="view_news.php?news_id=<?php echo $pisah[0]?>&news_tittel=<?php echo $pisah[1]?>"><?php echo $pisah[1]?></a></li>
                        <?php }?>
                    </ul>
            </div>
        </div>
    </section>
</body>
</html>