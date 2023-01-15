<?php
    require '../include/connectDB.php';
    include '../include/session_handel.php';

    $hapus = false;
    if(isset($_GET["id_slide"])){
        $get_id = htmlspecialchars(trim($_GET["id_slide"]));
        $gambar_err = "";

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // gambar
            if(empty($_FILES["image"])){
                $gambar_err = "can't be empty";
            }elseif($_FILES["image"]["size"] == 0){
                $gambar["name"] = $_SESSION["old_image"];
            }
            elseif($_FILES["image"]["size"] > 2000000){
                $gambar_err = "file size too big";
            }else{
                $gambar = $_FILES["image"];
                $hapus = true;
            }

            if(empty($gambar_err)){
                $sql = "UPDATE image_slide SET file =? WHERE id = ?";

                // image setting upload
                $dir = "./images/";

                $file_name = md5(time().$gambar["name"]) . "." . pathinfo($gambar["name"], PATHINFO_EXTENSION);
                if($stmt = mysqli_prepare($conn, $sql)){
                   mysqli_stmt_bind_param($stmt, "si", $param_file, $param_id);
                   $param_file = $file_name;
                   $param_id = $get_id;

                    if(mysqli_stmt_execute($stmt)){
                        move_uploaded_file(
                            $gambar["tmp_name"], $dir . $file_name
                        );
                        if($hapus){
                            unlink($dir.$_SESSION["old_image"]);
                        }
                        echo "<script>alert('Sucsessfuly Update data')</script>";
                        echo "<script>location.replace('image_setting.php')</script>";
                    }
                    else{
                        die("Error Update Function, Please try again leter");
                        exit;
                    }
                }
            }
        }
    }

    $sql = "SELECT id, file FROM image_slide WHERE id = ?";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $get_id;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $id, $gambar);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if(file_exists('./images/' . $gambar)){
            $status = "<span>files exist</span>";
            $_SESSION["old_image"] = $gambar;
        }else{
            $status = "<span style='color:red;'>missing</span>";
        }

    }else{
        die("ERROR Get Data From Database, check connection");
        exit;
    }
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
    <link rel="stylesheet" href="../../style/css/slide_edit.css">
    <link rel="stylesheet" href="../../style/css/navbar.css">
    <script src="../js/navbar.js" defer></script>
    <title>Edit Slide</title>
</head>
<body>
    <?php include '../include_content/navbar.php'?>
    <main>
        <section>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="container">
                    <p>Slide 1, <?php echo $status?></p>
                    <img src="images/<?php echo $gambar?>" alt="" id="old">
                    <img src="" alt="" id="output">
                    <p>max file size 2mb <span class="alert"><?php echo $gambar_err?></span></p>
                    <input type="file" name="image" id="" onchange="loadFile(event)" accept="image/*">
                    <button type="submit">Update</button>
                </div>
            </form>
        </section>
    </main>
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            var old = document.getElementById('old');
            output.src = URL.createObjectURL(event.target.files[0]);
            if(event.target.files[0].size > 0){
                old.style.display = 'none'
            }
            output.onload = function() {
            URL.revokeObjectURL(output.src)
            }
        };
    </script>
</body>
</html>