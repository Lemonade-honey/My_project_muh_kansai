<?php
    require '../include/connectDB.php';
    include '../include/session_handel.php';

    $judul = $judul_err = $gambar = $gambar_err = $deskripsi = $deskripsi_err = 
    $pinned = $pinned_err = $update_by = $update_at = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["tittle_news"]))){
            $judul_err = "can't be empty";
        }else{
            $judul = trim($_POST["tittle_news"]);
        }

        if($_FILES["image"]["size"] == 0){
            $gambar_err = "can't be empty";
        }elseif($_FILES["image"]["size"] > 1200000){
            $gambar_err = "size to big, max 1mb";
        }else{
            $gambar = $_FILES["image"];
            echo $display = $gambar["name"];
        }

        if(empty(trim($_POST["description"]))){
            $deskripsi_err = "can't be empty";
        }else{
            $deskripsi = trim($_POST["description"]);
        }

        
        $pinned = trim($_POST["pinned"]);

        if(empty($judul_err) && empty($gambar_err) && empty($pinned_err)){
            $sql = "INSERT INTO news(judul, deskripsi, gambar, create_by, pinned) VALUES(?,?,?,?,?)";
            // image setting upload
            $dir = "../../../news/";

            $file_name = md5(time().$gambar["name"]) . "." . pathinfo($gambar["name"], PATHINFO_EXTENSION);
            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "ssssi", $param_judul, $param_desc, $param_gambar, $param_create_by, $param_pin);
                $param_judul = $judul;
                $param_desc = $deskripsi;
                $param_gambar = $file_name;
                $param_create_by = $_SESSION["staff_username"];
                $param_pin = $pinned;
                if(mysqli_stmt_execute($stmt)){
                    move_uploaded_file(
                        $gambar["tmp_name"], $dir . $file_name
                    );
                    echo "<script>alert('Succsesfuly create news')</script>";
                    echo "<script>location.replace('list_news.php')</script>";
                }else{
                    die("ERROR EXECUTE, in insert to database, Try again leter !");
                    exit;
                }
            }
            else{
                die("ERROR on Prepare Function, Try again leter");
            }
        }
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
    <title>Add News || Staff Portal</title>
</head>
<body>
    <?php include '../include_content/navbar.php'?>
    <main>
        <section>
            <div class="judul-container"><h1>Add news</h1></div>
            <div class="add-container">
                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-data">
                            <div class="judul-form"><h2>news title</h2></div>
                            <p>Add news headlines <span class="alert"><?php echo $judul_err?></span></p>
                            <input type="text" name="tittle_news" class="box" value="<?php echo $judul?>">
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>display image news <span class="alert"><?php echo $gambar_err?></span></h2></div>
                            <p>max image size 3 MB (image file ongoing)</p>
                            <img id="output"/>
                            <input type="file" name="image" id="image" onchange="loadFile(event)" value="" accept="image/*">
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>descripsion news <span class="alert"><?php echo $deskripsi_err?></span></h2></div>
                            <textarea name="description" id="summernote" class="box"><?php echo $deskripsi?></textarea>
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>bookmark news <span class="alert"><?php echo $pinned_err?></span></h2></div>
                            <p>Will this news be flagged? <?php echo $pinned?></p>
                            <select name="pinned" id="" class="box">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="form-submit">
                            <button type="submit" class="btn">Upload News</button>
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