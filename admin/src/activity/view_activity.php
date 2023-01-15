<?php
    require '../include/connectDB.php';
    include '../include/session_handel.php';
    include '../include/activity.include.php';
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
    <title><?php echo $_GET["action"]?> Activity || Muhammadiyah Kansai</title>
</head>
<body>
    <?php include '../include_content/navbar.php'?>
    <main>
        <section>
            <div class="judul-container"><h1><?php echo $_GET["action"]?> activity</h1></div>
            <div class="add-container">
                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-data">
                            <div class="judul-form"><h2>activity tittle <span class="alert"></span></h2></div>
                            <p>Add activity headlines <span class="alert"><?php echo $event_name_err?></span></p>
                            <input type="text" name="tittle" class="box" value="<?php echo $event_name?>" disabled onkeypress="if(this.value.length == 100) return false">
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>activity date</h2></div>
                            <p>activity start date <span class="alert"><?php echo $event_date_err?></span></p>
                            <input type="date" name="date" class="box" value="<?php echo $event_date?>" disabled>
                            <p>activity start <span class="alert"><?php echo $start_err?></span></p>
                            <input type="time" name="start" class="box" value="<?php echo date("H:i", strtotime($start))?>" disabled>
                            <p>activity end <span class="alert"><?php echo $end_err?></span></p>
                            <input type="time" name="end" class="box" value="<?php echo date("H:i", strtotime($end))?>" disabled>
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>activity descripsion <span class="alert"></span></h2></div>
                            <p>speaker <span class="alert"><?php echo $speaker_err?></span></p>
                            <input type="text" name="speaker" class="box" value="<?php echo balik($speaker)?>" disabled>
                            <p>descripsion <span class="alert"><?php echo $deskripsi_err?></span></p>
                            <textarea name="description" id="summernote" class="box"><?php echo($deskripsi)?></textarea>
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>location</h2></div>
                            <p>location<span class="alert"><?php echo $location_err?></span></p>
                            <input type="text" name="location" class="box" value="<?php echo $location?>" disabled >
                            <p>link maps <span class="opsional"></span></p>
                            <textarea name="link_map" id=""  rows="3" class="box" disabled><?php echo $location_link?></textarea>
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>links <span class="opsional"></span></h2></div>
                            <p>link tittle</p>
                            <input type="text" name="link_tittle" class="box" value="<?php echo $link_tittle?>" disabled onkeypress="if(this.value.length == 60) return false">
                            <p>link <span class="alert"><?php echo $link_err?></span></p>
                            <textarea name="link" rows="3" class="box" disabled><?php echo $link?></textarea>
                        </div>
                        <div class="form-data">
                            <div class="judul-form"><h2>activity history</h2></div>
                            <p>create at <?php echo date("d F Y, H:i", strtotime($create_at))?>. create by:</p>
                            <input type="text" id="create1" class="box" value="<?php echo $create_by?>" disabled>
                            <p>update at <?php if($update_at != NULL){echo date("d F Y, H:i", strtotime($update_at));}?>. update by:</p>
                            <input type="text" id="create2" class="box" value="<?php echo $update_by?>" disabled>
                        </div>
                        <div class="form-submit">
                            <?php foreach($button as $btn){echo $btn;}?>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <script>
        <?php echo $script?>
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
        document.querySelector('#create1').setAttribute('disabled', true)
        document.querySelector('#create2').setAttribute('disabled', true)
    </script>
</body>
</html>
