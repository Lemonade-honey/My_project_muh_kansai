<?php
    $image = array();

    mysqli_stmt_close($stmt);
    $sql = "SELECT file FROM image_slide";
    $stmt  = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $gambar);
    while(mysqli_stmt_fetch($stmt)){
        array_push($image, $gambar);
    }
?>