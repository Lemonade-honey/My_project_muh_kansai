<?php
    $page_data = 10;
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $start = ($page > 1) ? ($page * $page_data) - $page_data : 0;

    $sql = "SELECT * FROM timeline";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    $sql = "SELECT * FROM timeline ORDER BY id DESC LIMIT $start, $page_data";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_result($stmt, $id_event, $event_name, $date_start, $start, $end, $speak, $deskripsi, $location,
    $link_location, $link_tittle, $links, $create_by, $create_at, $update_by, $update_at);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        

        if(isset($_GET["data"])){
            mysqli_stmt_close($stmt);
            $data = htmlspecialchars(trim($_GET["data"]));
            $sql = "SELECT * FROM timeline WHERE event_name LIKE '%".$data."%' ORDER BY id ASC";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rows = mysqli_stmt_num_rows($stmt);
            mysqli_stmt_close($stmt);
            
            
            $sql = "SELECT * FROM timeline WHERE event_name LIKE '%".$data."%' ORDER BY id ASC LIMIT $start, $page_data";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_result($stmt, $id_event, $event_name, $date_start, $start, $end, $speak, $deskripsi, $location,
            $link_location, $link_tittle, $links, $create_by, $create_at, $update_by, $update_at);
            mysqli_stmt_execute($stmt);
        }
    }

    $pages = ceil($rows/$page_data);
?>