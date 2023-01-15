<?php
    require '../include/connectDB.php';
    include '../include/session_handel.php';
    $no = 1;

    $sql = "SELECT id, file FROM image_slide";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $id, $nama_file);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="../../../images/staff_logo/wrench.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../../../style/css/global_style.css">
    <link rel="stylesheet" href="../../style/css/image.css">
    <link rel="stylesheet" href="../../style/css/navbar.css">
    <script src="../js/navbar.js" defer></script>
    <title>Slide Settings</title>
</head>
<body>
    <?php include '../include_content/navbar.php'?>
    <main>
        <section>
            <div class="judul-container"><h1>Image Slide</h1></div>
            <div class="image-container">
                <?php while(mysqli_stmt_fetch($stmt)){
                    if(file_exists('./images/' . $nama_file)){
                        $status = "<span>files exist</span>";
                        $_SESSION["old_image"] = $nama_file;
                    }else{
                        $status = "<span style = 'color: red;'>missing</span>";
                    }?>
                    <div class="sub-container">
                        <p><h2>Slide <?php echo $no++?>, <?php echo $status?></h2></p>
                        <div class="gambar"><img src="images/<?php echo $nama_file?>" alt=""></div>
                        <a href="slide_edit.php?id_slide=<?php echo $id?>" class="btn">Edit Image</a>
                    </div>
                <?php } mysqli_stmt_close($stmt)?>
            </div>
        </section>
    </main>
</body>
</html>