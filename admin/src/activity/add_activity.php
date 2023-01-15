<?php
    require '../include/connectDB.php';
    include '../include/session_handel.php';

    $event_name = $event_name_err = $event_start = $event_start_err = $start = $start_err = $end = $end_err =
    $speaker = $speaker_err = $deskripasi = $deskripasi_err = $location = $location_err = $location_link = 
    $location_link_err = $link_tittle = $link_tittle_err = $link = $link_err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // validete even name
        if(empty(trim($_POST["tittle"]))){
            $event_name_err = "can't be empty";
        }else{
            $event_name = htmlspecialchars(trim($_POST["tittle"]));
        }

        // valdiate event start
        if(empty(trim($_POST["date"]))){
            $event_start_err = "can't be empty";
        }elseif(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["date"]))){
            $event_start_err = "only number allowed";
        }elseif(date("d-m-Y", strtotime($_POST["date"])) < date("d-m-Y")){
            $event_start_err ="day must be greater than today";
        }else{
            $event_start = trim($_POST["date"]);
        }

        // start
        if(empty(trim($_POST["start"]))){
            $start_err = "can't be empty";
        }elseif(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["start"]))){
            $start_err = "only number allowed";
        }
        else{
            $start = trim($_POST["start"]);
        }

        // end
        if(empty(trim($_POST["end"]))){
            $end_err = "can't be empty";
        }elseif(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["end"]))){
            $end_err = "only number allowed";
        }elseif(date("H:i", strtotime($_POST["end"])) < date("H:i", strtotime($start))){
            $end_err = "clock must be greater then start clock";
        }else{
            $end = trim($_POST["end"]);
        }

        // speaker
        if(empty(trim($_POST["speaker"]))){
            $speaker_err = "can't be empty";
        }elseif(preg_match("/^[0-9-' ]*$/", trim($_POST["speaker"]))){
            $speaker_err = "Number Not Alowed";
        }else{
            $speaker = trim($_POST["speaker"]);
        }

        // desckrisp
        if(empty(trim($_POST["description"]))){
            $deskripasi_err = "can't be empty";
        }else{
            $deskripasi = trim($_POST["description"]);
        }
        // location
        if(empty(trim($_POST["location"]))){
            $location_err = "can't be empty";
        }else{
            $location = trim($_POST["location"]);
        }

        // map link
        if(empty(trim($_POST["link_map"]))){
            $location_link = null;
        }else{
            $location_link = trim($_POST["link_map"]);
        }

        // link tittle
        if(empty(trim($_POST["link_tittle"]))){
            $link_tittle = null;
        }else{
            $link_tittle = trim($_POST["link_tittle"]);
        }
        // link
        if(empty(trim($_POST["link"]))){
            $link = null;
        }elseif(!empty($link_tittle)){
            $link_err = "insert the link";
        }else{
            $link = trim($_POST["link"]);
        }

        if(empty($event_name_err) && empty($event_start_err) && empty($start_err) && empty($end_err) && empty($speaker_err)
        && empty($deskripasi_err) && empty($location_err) && empty($link_err)){
            $sql = "INSERT INTO timeline(event_name, event_start, time_start, time_end, speaker, description, location, link_location,
            link_tittle, links, make_by) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "sssssssssss", $param_event, $param_date, $param_start, $param_end, $param_speaker, $param_desc,
                $param_location, $param_map, $param_tittle_link, $param_link, $param_create_by);
                $param_event = $event_name;
                $param_date = date("Y-m-d", strtotime($event_start));
                $param_start = date("H:i", strtotime($start));
                $param_end = date("H:i", strtotime($end));
                $param_speaker = replace($speaker);
                $param_desc = replace($deskripasi);
                $param_location = $location;
                $param_map = $location_link;
                $param_tittle_link = $link_tittle;
                $param_link = $link;
                $param_create_by = $_SESSION["staff_username"];

                if(mysqli_stmt_execute($stmt)){
                    echo "<script>alert('Succsesfuly create activity')</script>";
                    echo "<script>location.replace('list_activity.php')</script>";
                }
                else{
                    die("ERROR EXECUTE, in insert to database, Try again leter !");
                    exit;
                }
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

    <link rel="stylesheet" href="../../style/css/navbar.css">
    <link rel="stylesheet" href="../../style/css/add_style.css">
    <link rel="stylesheet" href="../../style/css/summernote.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="../js/navbar.js" defer></script>
    <title>Add Activity || Muhammadiyah Kansai</title>
</head>
<body>
    <?php include '../include_content/navbar.php'?>
    <main>
        <section>
            <div class="judul-container"><h1>Add activity</h1></div>
            <div class="add-container">
                <div class="form-container">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-data">
                            <div class="judul-form"><h2>activity tittle</h2></div>
                            <p>Add activity headlines <span class="alert"><?php echo $event_name_err?></span></p>
                            <input type="text" name="tittle" class="box" value="<?php echo $event_name?>">
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>activity date</h2></div>
                            <p>activity start date <span class="alert"><?php echo $event_start_err?></span></p>
                            <input type="date" name="date" value="<?php echo $event_start?>" class="box">
                            <p>activity start <span class="alert"><?php echo $start_err?></span></p>
                            <input type="time" name="start" class="box" value="<?php echo $start?>">
                            <p>activity end <span class="alert"><?php echo $end_err?></span></p>
                            <input type="time" name="end" class="box" value="<?php echo $end?>">
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>activity descripsion <span class="alert"></span></h2></div>
                            <p>speaker <span class="alert"><?php echo $speaker_err?></span></p>
                            <input type="text" name="speaker" class="box" value="<?php echo $speaker?>">
                            <p>descripsion <span class="alert"><?php echo $deskripasi_err?></span></p>
                            <textarea name="description" id="summernote" class="box"><?php echo $deskripasi?></textarea>
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>location</h2></div>
                            <p>location <span class="alert"><?php echo $location_err?></span></p>
                            <input type="text" name="location" class="box" value="<?php echo $location?>">
                            <p>link maps <span class="opsional">(Optional)</span></p>
                            <textarea name="link_map" rows="3" class="box"><?php echo $location_link?></textarea>
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>links <span class="opsional">(optional)</span></h2></div>
                            <p>link tittle</p>
                            <input type="text" name="link_tittle" class="box" value="<?php echo $link_tittle?>">
                            <p>link <span class="alert"><?php echo $link_err?></span></p>
                            <textarea name="link" rows="3" class="box"><?php echo $link?></textarea>
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
          height: 200,
          toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['insert', ['link']],
              ['view', ['codeview', 'help']]
          ]
        });
    </script>
</body>
</html>
