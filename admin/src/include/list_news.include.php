<?php
    $page_data = 10;
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $start = ($page > 1) ? ($page * $page_data) - $page_data : 0;

    $sql = "SELECT * FROM news";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    $sql = "SELECT id, judul, create_at, create_by, pinned FROM news ORDER BY id DESC LIMIT $start, $page_data";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_result($stmt, $news_id, $judul, $create_at, $create_by, $pin);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $total_rows = mysqli_stmt_num_rows($stmt);

        if(isset($_GET["data"])){
            mysqli_stmt_close($stmt);

            $data = htmlspecialchars(trim($_GET["data"]));
            // $sql = "SELECT id, email, name, job, skill, citizen FROM account";
            $sql = "SELECT id, judul, create_at, create_by, pinned FROM news WHERE judul LIKE '%".$data."%' ORDER BY id DESC";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $news_id, $judul, $create_at, $create_by, $pin);
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