<?php
    $page_data = 10;
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $start = ($page > 1) ? ($page * $page_data) - $page_data : 0;
    
    $sql = "SELECT * FROM account";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);


    $sql = "SELECT account.id, account.email, account.name, account.citizen, account_data.profile_picture FROM account JOIN account_data ON account.id = account_data.id ORDER BY id LIMIT $start, $page_data";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_result($stmt, $id_user, $email, $name, $citizen, $profile_picture);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $total_rows = mysqli_stmt_num_rows($stmt);

        // get data id url
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
            
            
            $sql = "(SELECT account.id, account.email, account.name, account.job, account.skill, account.citizen, account_data.profile_picture FROM account JOIN account_data ON account.id = account_data.id WHERE account.name LIKE '%".$data."%' ORDER BY id ASC LIMIT $start, $page_data)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_result($stmt, $id_user, $email, $name, $job, $skill, $citizen, $profile_picture); 
            mysqli_stmt_execute($stmt);
        }

        
        
    }
    else{
        die("Error database data query");
        exit;
    }
    $pages = ceil($rows/$page_data);

?>