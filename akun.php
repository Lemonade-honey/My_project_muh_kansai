<?php
    require "admin/src/include/connectDB.php";

    $sql = "INSERT INTO staff(username, password, level) VALUES(?, ?, ?)";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "ssi", $param_username, $param_password, $param_level);
        $param_username = "daffaalif1239@gmail.com";
        $param_password = password_hash("123456", PASSWORD_DEFAULT);
        $param_level = "5";

        if(mysqli_stmt_execute($stmt)){
            echo "sukses";
        }
    }

?>