<?php
    require '../include/connectDB.php';
    include '../include/session_handel.php';
    $hapus = false;
    if(isset($_GET["action"]) && isset($_GET["news_id"])){
        $get_id = htmlspecialchars(trim($_GET["news_id"]));
        $action = htmlspecialchars(trim($_GET["action"]));
        $judul_err = $gambar_err = $deskripsi_err = $pinned_err = $update_by = $update_at = "";

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // judul
            if(empty(trim($_POST["tittle_news"]))){
                $judul_err = "can't be empty";
            }else{
                $judul = htmlspecialchars(trim($_POST["tittle_news"]));
            }

            // gambar
            if(empty($_FILES["image"])){
                $gambar_err = "can't be empty";
            }elseif($_FILES["image"]["size"] == 0){
                $gambar["name"] = $_SESSION["old_image"];
            }
            elseif($_FILES["image"]["size"] > 1500000){
                $gambar_err = "file size too big";
            }else{
                $gambar = $_FILES["image"];
                $hapus = true;
            }

            // deskripsi
            if(empty($_POST["description"])){
                $deskripsi_err = "can't be empty";
            }else{
                $deskripsi = trim($_POST["description"]);
            }

            // pinned
            if(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["pinned"]))){
                $pinned_err = "only number alowwed";
            }else{
                $pinned = htmlspecialchars(trim($_POST["pinned"]));
            }

            if(empty($judul_err) && empty($gambar_err) && empty($deskripsi_err)
            && empty($pinned_err)){
                $sql = "UPDATE news SET judul = ?, deskripsi =?, gambar =?, pinned =?, update_by =?,
                update_at=? WHERE id = ?";

                // image setting upload
                $dir = "../../../news/";

                $file_name = md5(time().$gambar["name"]) . "." . pathinfo($gambar["name"], PATHINFO_EXTENSION);
                if($stmt = mysqli_prepare($conn, $sql)){
                    mysqli_stmt_bind_param($stmt, "sssissi", $param_judul, $param_deskripsi, $param_gambar,
                    $param_pin, $param_update_by, $param_update_at, $param_target_id);
                    $param_judul = replace($judul);
                    $param_deskripsi = replace($deskripsi);
                    $param_gambar = $file_name;
                    $param_pin = $pinned;
                    $param_update_by = $_SESSION["staff_username"];
                    $param_update_at = date("Y-m-d H:i:s");
                    $param_target_id = $get_id;

                    if(mysqli_stmt_execute($stmt)){
                        move_uploaded_file(
                            $gambar["tmp_name"], $dir . $file_name
                        );
                        if($hapus){
                            unlink($dir.$_SESSION["old_image"]);
                        }
                        echo "<script>alert('Sucsessfuly Update data')</script>";
                        echo "<script>location.replace()</script>";
                    }
                    else{
                        die("Error Update Function, Please try again leter");
                        exit;
                    }
                }
            }
        }
    }

    $sql = "SELECT * FROM news WHERE id = ?";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $get_id;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $news_id, $judul, $deskripsi, $gambar, $create_at, $create_by, $pin, 
        $update_by, $update_at);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if(file_exists('../../../news/' . $gambar)){
            $status = "files exist";
            $_SESSION["old_image"] = $gambar;
        }else{
            $status = "missing";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../../images/staff_logo/wrench.png">

    <!-- <link rel="stylesheet" href="../../../style/css/global_style.css"> -->
    <link rel="stylesheet" href="../../style/css/navbar.css">
    <link rel="stylesheet" href="../../style/css/add_style.css">
    <link rel="stylesheet" href="../../style/css/summernote.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script src="../js/navbar.js" defer></script>
    <style>
        #output{
            max-width: 30rem;
            max-height: 15rem;
        }#output img{
            width: 100%;
            height: 100%;
        }.form-data label{
            padding: 0 .5rem;
            border: 1px solid #000;
            border-radius: .3rem;
            background: rgba(0, 0, 0, .2);
            cursor: pointer;
        }.form-data label:hover{
            opacity: .8;
        }
    </style>
    <title>Edit News || Staff Portal</title>
</head>
<body>
    <?php include '../include_content/navbar.php'?>
    <main>
        <section>
            <div class="judul-container"><h1>edit news</h1></div>
            <div class="add-container">
                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-data">
                            <div class="judul-form"><h2>news title</h2></div>
                            <p>news headlines <span class="alert"><?php echo $judul_err?></span></p>
                            <input type="text" name="tittle_news" class="box" value="<?php echo $judul?>">
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>display image news <span class="alert"><?php echo $gambar_err?></span></h2></div>
                            <p>max image size 1.5 MB</p>
                            <img id="output"/>
                            <input type="file" name="image" id="image" onchange="loadFile(event)" value="" accept="image/*">
                            <p>Image Display Name: <?php echo $gambar?></p>
                            <p>image status: <b><?php echo $status?></b></p>
                            <progress id="progress-bar" value="0" max="100"></progress>
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>descripsion news <span class="alert"><?php echo $deskripsi_err?></span></h2></div>
                            <textarea name="description" id="summernote" class="box"><?php echo $deskripsi?></textarea>
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>bookmark news <span class="alert"><?php echo $pinned_err?></span></h2></div>
                            <p>Will this news be flagged? <?php echo $pinned?></p>
                            <p>status : <?php if($pin == 0){echo "No";}else{echo "Yes";}?></p>
                            <select name="pinned" id="" class="box">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>news history</h2></div>
                            <p>create at <?php echo date("d F Y, H:i", strtotime($create_at))?>. created by : </p>
                            <input type="text" id="create1" class="box" value="<?php echo $create_by?>" disabled>
                            <p>last update <?php echo date("d F Y, H:i", strtotime($update_at))?>. updated by : </p>
                            <input type="text" id="create2" class="box" value="<?php echo $update_by?>" disabled>
                        </div>
                        <div class="form-submit">
                            <button type="submit" class="btn">Update News</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <script>
        $('#summernote').summernote({
          placeholder: 'Type here . . . ',
          tabsize: 2,
          height: 400,
          toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link']],
              ['view', ['codeview', 'help']]
          ]
        });
        
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
            URL.revokeObjectURL(output.src)
            }
        };
    </script>
</body>
</html>