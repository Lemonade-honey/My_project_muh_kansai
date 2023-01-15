<?php
    $berita_terbaru = array();
    $berita_pinned = array();
    $page_data = 5;

    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $start = ($page > 1) ? ($page * $page_data) - $page_data : 0;

    $sql = "SELECT * FROM news";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

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
    


    $sql = "SELECT id, judul, gambar, create_at, create_by FROM news ORDER BY id DESC LIMIT $start, $page_data";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_result($stmt, $news_id, $judul, $gambar, $create_at, $create_bt);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $total_rows = mysqli_stmt_num_rows($stmt);

        if(isset($_GET["data"])){
            mysqli_stmt_close($stmt);

            $data = htmlspecialchars(trim($_GET["data"]));
            // $sql = "SELECT id, email, name, job, skill, citizen FROM account";
            $sql = "SELECT * FROM news WHERE judul LIKE '%".$data."%' ORDER BY id DESC";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $news_id, $judul, $deskripsi, $gambar, $create_at, $create_by);
            mysqli_stmt_store_result($stmt);
            $rows = mysqli_stmt_num_rows($stmt);
        }
    }
    else{
        die("Error database data query");
        exit;
    }
    $pages = ceil($rows/$page_data);
?>