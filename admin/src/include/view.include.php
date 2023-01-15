<?php
    $button = array();
    $script = "";
    if(isset($_GET["action"]) && isset($_GET["user_id"])){
        $get_id = htmlspecialchars(trim($_GET["user_id"]));
        $action = htmlspecialchars(trim($_GET["action"]));
        
        // action delete
        if($action == "delete"){
            $button[0] = "<button type='submit' class='btn red'>Delete</button>";
        
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $sql = "DELETE FROM account WHERE id = ?";
                if($stmt = mysqli_prepare($conn, $sql)){
                    mysqli_stmt_bind_param($stmt, "i", $param_user_id);
                    $param_user_id = $get_id;
                    if(mysqli_stmt_execute($stmt)){
                        echo "<script>alert('The selected account was successfully deleted')</script>";
                        echo "<script>location.replace('list_member.php')</script>";
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
                        const select = document.querySelectorAll('select')
                        for(const input of inputs){
                            input.removeAttribute('disabled')
                        }
                        for(const text of select){
                            text.removeAttribute('disabled')   
                        }";
            $name = $name_err = $email = $email_err = $date_birth = $date_birth_err = "";
            $citizen = $citizen_err = $phone = $phone_err = $job = $job_err = $skill = $skill_err = "";
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                // email
                if(empty(trim($_POST["email"]))){
                    $email_err = "can't be empty";
                }elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
                    $email_err = "Invalid email address";
                }else{
                    $email = trim($_POST["email"]);
                }

                // name
                if(empty(trim($_POST["name"]))){
                    $name_err = "can't be empty";
                } elseif(!preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["name"]))){
                    $name_err = "only letters and spaces are allowed";
                } else{
                    $name = trim($_POST["name"]);
                }

                // phone
                if(empty(trim($_POST["phone"]))){
                    $phone_err = "can't be empty";
                }elseif(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["phone"]))){
                    $phone_err = "only numbers are allowed";
                }else{
                    $phone = trim($_POST["phone"]);
                }

                // Validate citizen
                if(empty(trim($_POST["citizen"]))){
                    $citizen_err = "Select your country origin";
                }
                else{
                    $citizen = trim($_POST["citizen"]);
                }

                // Validate date
                if(empty(trim($_POST["date_birth"]))){
                    $date_birth_err = "can't be empty";
                }elseif(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["date_birth"]))){
                    $date_birth_err = "date not valid";
                }
                else{
                    $date_birth = trim($_POST["date_birth"]);
                }

                // validate job
                if(empty(trim($_POST["job"]))){
                    $job = null;
                }
                elseif(!preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["job"]))){
                    $job_err = "only letters and spaces are allowed";
                }
                else{
                    $job = trim($_POST["job"]);
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

                if(empty($name_err) && empty($email_err) && empty($date_birth_err) && empty($citizen_err)
                && empty($phone_err) && empty($job_err) && empty($skill_err)){
                    $sql = "UPDATE account SET name = ?, email = ?, date_birth = ?, citizen = ?, phone_number = ?, job = ?,
                    skill = ? WHERE id = ?";
                    if($stmt = mysqli_prepare($conn, $sql)){
                        mysqli_stmt_bind_param($stmt, "sssssssi", $param_name, $param_email, $param_date, $param_citizen,
                        $param_phone, $param_job, $param_skill, $param_id_target);
                        $param_name = $name;
                        $param_email = $email;
                        $param_date = date("Y-m-d", strtotime($date_birth));
                        $param_citizen = $citizen;
                        $param_phone = $phone;
                        $param_job = $job;
                        $param_skill = $skill;
                        $param_id_target = $get_id;
                        if(mysqli_stmt_execute($stmt)){
                            echo "<script>alert('Update succses !')</script>";
                            echo "<script>location.replace('list_member.php')</script>";
                        }else{
                            die("Oops! Something went wrong when update data. Please try again later.");
                        }
                    }
                }else{
                    echo "<script>alert('error input, please check again')</script>";
                }
            }
        }
        else{
            die("action tidak ada");
        }

        $sql = "SELECT id, email, name, phone_number, date_birth, job, skill, citizen, create_time FROM account WHERE id = ?";
        $stmt = mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $get_id;
        mysqli_stmt_bind_result($stmt, $id_user, $email, $name, $phone, $date, $job, $skill, $citizen, $create);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    else{
        die("keluar");
        exit;
    }
?>
