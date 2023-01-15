<?php

    $page_data = 10;
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $start = ($page > 1) ? ($page * $page_data) - $page_data : 0;

    $sql = "SELECT * FROM account WHERE verified = 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    $sql = "SELECT id, name, email, date_birth, citizen, create_time FROM account WHERE verified = 1  LIMIT $start, $page_data";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_result($stmt, $id_user, $name, $email, $date, $citizen, $create);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        

        if(isset($_GET["data"])){
            mysqli_stmt_close($stmt);
            $data = htmlspecialchars(trim($_GET["data"]));
            // $sql = "SELECT id, email, name, job, skill, citizen FROM account";
            $sql = "(SELECT * FROM account WHERE name LIKE '%".$data."%' ORDER BY id ASC)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rows = mysqli_stmt_num_rows($stmt);
            mysqli_stmt_close($stmt);
            
            
            $sql = "SELECT id, name, email, date_birth, citizen, create_time FROM account WHERE verified = 1 AND name LIKE '%".$data."%' ORDER BY id ASC LIMIT $start, $page_data";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_result($stmt, $id_user, $name, $email, $date, $citizen, $create); 
            mysqli_stmt_execute($stmt);
        }
    }

    $pages = ceil($rows/$page_data);
?>