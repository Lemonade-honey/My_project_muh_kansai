<?php
    require_once '../admin/src/include/connectDB.php';
    // namespace phpmailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


    // Define variables and initialize with empty values
    $email = $password = $confirm_password = "";
    $email_err = $password_err = $confirm_password_err = "";

    $name = $phone_number = $code_number = $date_birth = $citizen ="";
    $job = $skill = "";

    $name_err = $phone_number_err = $date_birth_err = $citizen_err = "";
    $job_err = $skill_err = $capcha_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // hide reporting error massage
        error_reporting(E_ERROR);

        // Validate email
        if(empty(trim($_POST["email"]))){
            $email_err = "enter your email";
        }elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
            $email_err = "Invalid email address";
        }else{
            // Prepare a select statement
            $sql = "SELECT id FROM account WHERE email = ?";
            
            if($stmt = mysqli_prepare($conn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_email);
                
                // Set parameters
                $param_email = trim($_POST["email"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $email_err = "Already used";
                    } else{
                        $email = trim($_POST["email"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        // Validate password
        if(empty(trim($_POST["password"]))){
            $password_err = "enter your password";     
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Minimum 6 letter password";
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Re-enter your password";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "didn't macth";
            }
        }

        // Validate name
        if(empty(trim($_POST["name"]))){
            $name_err = "Enter your name";
        } elseif(!preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["name"]))){
            $name_err = "only letters and spaces are allowed";
        } else{
            $name = trim($_POST["name"]);
        }

        // Validate phone number
        if(empty(trim($_POST["phone_number"])) && empty(trim($_POST["code_phone"]))){
            $phone_number_err = "Enter your phone number";
        } elseif(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["phone_number"]))){
            $phone_number_err = "only numbers are allowed";
        } elseif(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["code_phone"]))){
            $phone_number_err = "only numbers are allowed";
        } else{
            $code_number  = trim($_POST["code_phone"]);
            $phone_number = trim($_POST["phone_number"]);
        }

        // Validate date
        if(empty(trim($_POST["date_birth"]))){
            $date_birth_err = "Enter your date of birth";
        }elseif(preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["date_birth"]))){
            $date_birth_err = "date not valid";
        }
        else{
            $date_birth = trim($_POST["date_birth"]);
        }

        // validate job
        if(!preg_match("/^[a-zA-Z-' ]*$/", trim($_POST["job"]))){
            $job_err = "only letters and spaces are allowed";
        }
        else{
            $job = trim($_POST["job"]);
        }

        // Validate skill
        if(!preg_match("/^[a-zA-Z-', ]*$/", trim($_POST["skill"]))){
            $skill_err = "only letters, spaces and coma(,) are allowed";
        }else{
            $skill = trim($_POST["skill"]);
        }

        // Validate citizen
        if(empty(trim($_POST["citizen"]))){
            $citizen_err = "Select your country origin";
        }
        else{
            $citizen = trim($_POST["citizen"]);
        }

        // validate captcha
        if(empty(trim($_POST['capcha']))){
            $capcha_err = "Insert captcha code above";
        }elseif(preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', trim($_POST['capcha']))){
            $capcha_err = "Invalid code";
        }elseif(trim($_POST['capcha']) != $_SESSION["captcha"]){
            $capcha_err = "Code didn,t match";
        }

        // if no error
        if(empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($name_err) && empty($phone_number_err) && empty($date_birth_err)
        && empty($job_err) && empty($skill_err) && empty($citizen_err)){

            $sql = "INSERT INTO account(email, password, name, phone_number, date_birth, job, skill, citizen, vkey) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
            if($stmt = mysqli_prepare($conn, $sql)){
                // bind paramater
                mysqli_stmt_bind_param($stmt, "sssisssss", $param_email, $param_password, $param_name, $param_phone_number, $param_date, $param_job, 
                $param_skill, $param_citizen, $param_vkey);

                // the parameter
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $param_name = $name;
                $param_phone_number = "+" . $code_number . $phone_number;
                $param_date = date('Y-m-d', strtotime(trim($_POST["date_birth"])));
                $param_job = $job;
                $param_skill = $skill;
                $param_citizen = $citizen;
                $param_vkey = md5(time() . $name);

                if(mysqli_stmt_execute($stmt)){
                    // Redirect to login page
                    // header("<script>alert('register sukses')</script>");
                    // header("location: ../index.php", true, 301);
                    
                    // phpmailer librarry
                    require '../PHPMailer/src/Exception.php';
                    require '../PHPMailer/src/PHPMailer.php';
                    require '../PHPMailer/src/SMTP.php';
    
                    $mail = new PHPMailer(true);
    
                    // phpmailer setup pengirim
                    $email_pengirim = "likelemon212@gmail.com"; // email pengirim
                    $nama_pengirim  = 'Muhammadiyah Kansai'; // nama pengirim
                    $email_penerima = $_POST["email"];
                    $subjek = 'Request for email address validation';
                    $pesan = "<p>Verify your email by clicking the link below</p><br>
                    <a href='http://localhost/muhammadiyah-kansai-back/account/account_verified.php?vkey=$param_vkey'>Account Verification</a>";
    
                    // eksekusi
                    $mail = new PHPMailer;
                    $mail->isSMTP();
                    // server setting
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Username = $email_pengirim;
                    $mail->Password = 'mzyisdrwmbfgjdyi';
                    $mail->Port = 465;
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = "tls";
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    
                    $mail->setFrom($email_pengirim, $nama_pengirim);
                    $mail->addAddress($email_penerima);
                    $mail->isHTML(true);
                    $mail->Subject = $subjek;
                    $mail->Body = $pesan;
                    $mail->smtpClose();
                    $send = $mail->send();
                    if($send){
                        header("location: account_status.html", true, 301);
                    }
    
    
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
        mysqli_close($conn);
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../style/css/global_style.css">
    <link rel="stylesheet" href="../style/css/register_style.css">
    <style>
        .register-container form .form-data .capcha{
            display: flex;
        }
    </style>

    <title>Register || Muhammadiyah Kansai</title>
</head>
<body>
    <div class="register-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>Register Account</h1>
            <div class="form-data">
                <p>email <span class="alert"><?php echo $email_err;?></span></p>
                <input type="email" name="email" value="<?php echo $email;?>" class="box">
            </div>
            <div class="form-data">
                <p>password <span class="alert"><?php echo $password_err;?></span></p>
                <input type="password" name="password" value="<?php echo $password;?>" class="box">
            </div>
            <div class="form-data">
                <p>confirm password <span class="alert"><?php echo $confirm_password_err;?></span></p>
                <input type="password" name="confirm_password" value="<?php echo $confirm_password;?>" class="box">
            </div>
            <div class="form-data">
                <p>full name <span class="alert"><?php echo $name_err;?></span></p>
                <input type="text" name="name" value="<?php echo $name;?>" class="box">
            </div>
            <div class="form-data">
                <p>phone number <span class="alert"><?php echo $phone_number_err;?></span></p>
                <div class="handphone">
                    <input type="number" name="code_phone" value="<?php echo $code_number;?>" class="box code" placeholder="+code">
                    <input type="number" name="phone_number" value="<?php echo $phone_number;?>" class="box">
                </div>
            </div>
            <div class="form-data">
                <p>date birth <span class="alert"><?php echo $date_birth_err;?></span></p>
                <input type="date" name="date_birth" value="<?php echo $date_birth;?>" class="box">
            </div>
            <div class="form-data">
                <p>job <span class="opsional"></span> <span class="alert"><?php echo $job_err;?></span></p>
                <select name="job" id="" class="box">
                    <option value="<?php echo $job;?>" selected><?php echo $job;?></option>
                    <option value="teacher">teacher</option>
                    <option value="student">student</option>
                    <option value="lainya">other</option>
                </select>
                <!-- <input type="text" name="job" class="box hide"> -->
            </div>
            <div class="form-data">
                <p>skill <span class="opsional"></span><span class="alert"><?php echo $skill_err;?></span></p>
                <input type="text" name="skill" value="<?php echo $skill;?>" class="box" placeholder="Can be filled a lot">
            </div>
            <div class="form-data">
                <p>citizen <span class="alert"><?php echo $citizen_err;?></span></p>
                <select name="citizen" id="hasil" class="box">
                    <option value="<?php echo $citizen;?>"selected><?php echo $citizen;?></option>
                </select>
            </div>
            <div class="form-data">
                <p>captcha code <span class="alert"><?php echo $capcha_err?></span></p>
                <div class="capcha">
                    <img src="../include_main/capcha.php" alt="">
                    <input type="text" name="capcha" class="box" placeholder="captcha code..">
                </div>
            </div>
            <div class="submit-data">
                <p>have account already? <a href="#">login now</a></p>
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
    <script>
        let target = document.getElementById("hasil")
        fetch("https://restcountries.com/v2/all")
        .then(res => res.json())
        .then(data => initialize(data))
        .catch(err => console.log("Error: ", err));
        
        function initialize(contriesData){
            countries = contriesData;
            let option = "";
            for(i in countries){
                negara = countries[i].name;
                value = countries[i].alpha3Code;
                var opt = document.createElement('option')
                opt.value = negara
                opt.innerHTML = negara
                target.appendChild(opt)
            }
        }
    </script>
</body>
</html>