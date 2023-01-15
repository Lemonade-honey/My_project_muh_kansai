<?php
    include 'session_manage.php';
    $button = array();
    $script = "";
    $edit_data = null;

    // define post var
    $name_err = $phone_number_err = $date_birth_err = $skill_err = $job_err = "";
    $full_name = $phone_number = $date_birth = $address = $skill = $job = $line = $ig = $twt = "";
    if(isset($_GET["user_id"])){
        $sql = "SELECT account.name, account.email, account.phone_number, account.date_birth, account.job, account.skill, account.citizen, account.create_time,
        account_data.address, account_data.profile_picture, account_data.line, account_data.instagram, account_data.twitter FROM account INNER JOIN account_data ON account.id = account_data.id WHERE account.id = ? ";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $_GET["user_id"];
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $full_name, $email_user, $phone_number, $date_birth, $job, $skill, $citizen, $create_date, $address, $profile_picture, $line, $ig, $twt);
            mysqli_stmt_fetch($stmt);

            if($profile_picture == null){
                $profile_picture = "blank_null.png";
            }else{
                $scan = file_exists('./profile/' . $profile_picture);
                if($scan == 1){
                    $profile_picture = $profile_picture;
                }
                else{
                    $profile_picture = "blank_null.png";
                }    
            }
        }

            // edit availbel
        if($_SESSION["loggedin"]){
            if(htmlspecialchars($_SESSION["id"]) == htmlspecialchars($_GET["user_id"])){
                session_regenerate_id(true);
                $user_id = htmlspecialchars($_SESSION["id"]);
                $user_name = htmlspecialchars($_SESSION["name"]);
                $key = htmlspecialchars($_SESSION["rand"]);
                $edit_data = true;

                $button[0] = "<a href='profile.php?user_id=$user_id&user_name=$user_name&edit=$edit_data&key=$key' class='btn edit'>edit</a>";

                if(isset($_GET["key"])){
                    if(htmlspecialchars($_GET["key"]) == htmlspecialchars($_SESSION["rand"])){
                        $button[0] = "<button type='submit' value='update' class='btn update'>Update</button>";
                        $button[1] = "<a href='profile.php?user_id=$user_id&user_name=$user_name' class='btn cancel'>Cancel</a>";

                        $script = "
                        const inputs = document.querySelectorAll('input')
                        const textarea = document.querySelectorAll('textarea')
                        for(const input of inputs){
                            input.removeAttribute('disabled')
                        }
                        for(const text of textarea){
                            text.removeAttribute('disabled')   
                        }";

                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            mysqli_stmt_close($stmt);

                            // validate profile picture
                            if(!empty(trim($_POST['user_profile']))){
                                $profile_picture = htmlspecialchars(trim($_POST['user_profile']));
                            }

                            // validation name
                            if(empty(trim($_POST["name"]))){
                                $name_err = "can't be null";
                            }
                            if(!preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["name"]))){
                                $name_err = "only letters and spaces are allowed nama";
                            }else{
                                $full_name = $_POST["name"];
                            }

                            // validation phone
                            if(empty(trim($_POST["phone_number"]))){
                                $phone_number_err = "can't be null";
                            }
                            else{
                                $phone_number = $_POST["phone_number"];
                            }

                            // date birth
                            if(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["date_birth"]))){
                                $date_birth_err = "date not valid";
                            }
                            else{
                                $date_birth = $_POST["date_birth"];
                            }

                            // address validation
                            if(empty(trim($_POST["address"]))){
                                $address = null;
                            }
                            elseif(!empty(trim($_POST["address"]))){
                                $address = htmlspecialchars(trim($_POST["address"]));
                            }

                            // skill validation
                            if(empty(trim($_POST["skill"]))){
                                $skill = null;
                            }
                            elseif(!preg_match("/^[a-zA-Z-,' ]*$/", trim($_POST["skill"]))){
                                $skill_err = "only letters, spaces and koma(,) are allowed";
                            }
                            else{
                                $skill = htmlspecialchars(trim($_POST["skill"]));
                            }

                            // job validation
                            if(empty(trim($_POST["job"]))){
                                $job = null;
                            }
                            elseif(!preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["job"]))){
                                $job_err = "only letters and spaces are allowed job";
                            }
                            else{
                                $job = trim($_POST["job"]);
                            }
                            
                            // sosial validation
                            if(empty(trim($_POST["line"]))){
                                $line = null;
                            }
                            elseif(!empty(trim($_POST["line"]))){
                                $line = htmlspecialchars(trim($_POST["line"]));
                            }

                            if(empty(trim($_POST["instagram"]))){
                                $ig = null;
                            }
                            elseif(!empty(trim($_POST["instagram"]))){
                                $ig = htmlspecialchars(trim($_POST["instagram"]));
                            }
                            
                            if(empty(trim($_POST["twitter"]))){
                                $twt = null;
                            }
                            if(!empty(trim($_POST["twitter"]))){
                                $twt = htmlspecialchars(trim($_POST["twitter"]));
                            }

                            $sql = "UPDATE account ac JOIN account_data ad ON ac.id = ad.id SET ac.name =?, ac.phone_number=?, ac.job=?, ac.skill=?, 
                            ad.address =?, ad.profile_picture=?, ad.line=?, ad.instagram=?, ad.twitter=? WHERE ac.id =?";
                            if($stmt = mysqli_prepare($conn, $sql)){
                                mysqli_stmt_bind_param($stmt, "sssssssssi", $param_name, $param_phone, $param_job, $param_skill, 
                                $param_address, $param_pp, $param_line, $param_ig, $param_twt, $param_id_target);
                                $param_name = $full_name;
                                $param_phone = $phone_number;
                                $param_job = $job;
                                $param_skill = $skill;
                
                                $param_address = $address;
                                $param_pp = $profile_picture;
                                $param_line = $line;
                                $param_ig = $ig;
                                $param_twt = $twt;
                                $param_id_target = htmlspecialchars(trim($_GET["user_id"]));

                                if(mysqli_stmt_execute($stmt)){
                                    header("location: profile.php?user_id=$user_id&user_name=$user_name", true, 301);
                                    echo $phone_number;
                                }
                                else{
                                    echo "<script>alert('Oops Something went wrong. Please try again later.')</script>";
                                }
                            }

                            
                        }
                    }
                }
            }
        }else{
            $button = null;
        }
    }
    else{
        header("location: index.php", true, 301);
    }
    echo $name_err = $phone_number_err = $date_birth_err = $skill_err = $job_err;
?>