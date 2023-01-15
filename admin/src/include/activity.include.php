<?php
    $button = array();
    $script = "";
    $ekseskui = true;

    function pisah($data, $indeks){
        $data = explode("~|*", $data);
        return $data[$indeks];
    }

    if(isset($_GET["action"]) && isset($_GET["activity_id"])){
        $get_id = htmlspecialchars(trim($_GET["activity_id"]));
        $action = htmlspecialchars(trim($_GET["action"]));
        
        // action delete
        if($action == "delete"){
            $button[0] = "<button type='submit' class='btn red'>Delete</button>";
        
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $sql = "DELETE FROM timeline WHERE id = ?";
                if($stmt = mysqli_prepare($conn, $sql)){
                    mysqli_stmt_bind_param($stmt, "i", $param_user_id);
                    $param_user_id = $get_id;
                    if(mysqli_stmt_execute($stmt)){
                        echo "<script>alert('The selected activity was successfully deleted')</script>";
                        echo "<script>location.replace('list_activity.php')</script>";
                    }else{
                        die("Oops! Something went wrong when deleted the selected data. Please try again later.");
                        exit;
                    }
                }else{
                    die("Oops! Something went wrong with the connection. Please try again later.");
                    exit;
                }
            }
        }
        elseif($action == 'edit'){
            $button[0] = "<button type='submit' class='btn blue'>Update</button>";
            $script = "
            const inputs = document.querySelectorAll('input')
            const textarea = document.querySelectorAll('textarea')
            for(const input of inputs){
                input.removeAttribute('disabled')
            }
            for(const text of textarea){
                text.removeAttribute('disabled')   
            }            
            ";
            
            $event_name_err = $event_date_err = $start_err = $end_err =
            $speaker_err = $deskripsi_err = $location_err = 
            $location_link = $link_err = "";
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(empty(trim($_POST["tittle"]))){
                    $event_name_err = "can't be empty";
                }else{
                    $event_name = htmlspecialchars(trim($_POST["tittle"]));
                }

                if(empty(trim($_POST["date"]))){
                    $event_date_err = "can't be empty";
                }elseif(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["date"]))){
                    $event_date_err = "Only number alowed";
                }elseif(date("d-m-Y", strtotime($_POST["date"])) < date("d-m-Y")){
                    $event_date_err = "day must be greater than today";
                }else{
                    $event_date = $_POST["date"];
                }

                if(empty(trim($_POST["start"]))){
                    $start_err = "can't be empty";
                }elseif(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["start"]))){
                    $start_err = "Only number allowed";
                }else{
                    $start = trim($_POST["start"]);
                }

                if(empty(trim($_POST["end"]))){
                    $end_err = "can't be empty";
                }elseif(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["end"]))){
                    $end_err = "Only number alowed";
                }elseif(date("H:i", strtotime($_POST["end"])) < date("H:i", strtotime($_POST["start"]))){
                    $end_err = "clock must be greater than start clock";
                }else{
                    $end = trim($_POST["end"]);
                }

                if(empty($_POST["speaker"])){
                    $speaker_err = "can't be empty";
                }elseif(!preg_match("/^[a-zA-Z-,.' ]*$/", trim($_POST["speaker"]))){
                    $speaker_err = "Only letter allowed";
                }else{
                    $speaker = trim($_POST["speaker"]);
                }

                if(empty($_POST["description"])){
                    $deskripsi_err = "can't be empty";
                }else{
                    $deskripsi = trim($_POST["description"]);
                }

                if(empty($_POST["location"])){
                    $location_err = "can't be empty";
                }else{
                    $location = trim($_POST["location"]);
                }

                if(empty($_POST["link_map"])){
                    $location_link = null;
                }else{
                    $location_link = trim($_POST["link_map"]);
                }

                if(empty($_POST["link_tittle"])){
                    $link_tittle = null;
                }else{
                    $link_tittle = trim($_POST["link_tittle"]);
                }

                if(!empty($link_tittle) && empty($_POST["link"])){
                    $link_err = "insert the link";
                }else{
                    $link = trim($_POST["link"]);
                }
                $ekseskui = false;
                if(empty($event_name_err) && empty($event_date_err) && empty($start_err) && empty($end_err) && empty($speaker_err) 
                && empty($deskripsi_err) && empty($location_err) && empty($link_err)){
                    $sql = "UPDATE timeline SET event_name = ?, event_start = ?, time_start = ?, time_end =?,
                    speaker = ?, description = ?, location =?, link_location = ?, link_tittle =? ,links = ?, update_by =?, update_at =? WHERE id = ?";
                    if($stmt = mysqli_prepare($conn, $sql)){
                        mysqli_stmt_bind_param($stmt, "ssssssssssssi", $param_name, $param_date, $param_start, $param_end,
                        $param_speaker, $param_desc, $param_location, $param_link_location, $param_link_tittle, $param_links, $param_update_by, $param_update_at, $param_target_id);
                        $param_name = replace($event_name);
                        $param_date = date('Y-m-d', strtotime($event_date));
                        $param_start = date("H:i", strtotime($start));
                        $param_end = date("H:i", strtotime($end));
                        $param_speaker = replace($speaker);
                        $param_desc = replace($deskripsi);
                        $param_location = $location;
                        $param_link_location = $location_link;
                        $param_link_tittle = $link_tittle;
                        $param_links = $link;
                        $param_update_by = $_SESSION["staff_username"];
                        $param_update_at = date("Y-m-d H:i:s");
                        $param_target_id = $get_id;

                        if(mysqli_stmt_execute($stmt)){
                            echo "<script>alert('Activity succsesfuly created')</script>";
                            echo "<script>location.replace('list_activity.php')</script>";
                        }else{
                            die("Error Update Function, Please try again leter");
                            exit;
                        }

                    }
                }
            }
        }
        else{
            die("action tidak ada");
        }

        if($ekseskui){
            $sql = "SELECT * FROM timeline WHERE id = ?";
            $stmt = mysqli_prepare($conn,$sql);
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $get_id;
            mysqli_stmt_bind_result($stmt, $id_event, $event_name, $event_date, $start, $end, $speaker, $deskripsi, $location, $location_link,
            $link_tittle, $link, $create_by, $create_at, $update_by, $update_at);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        }

    }
    else{
        die("keluar");
        exit;
    }
?>