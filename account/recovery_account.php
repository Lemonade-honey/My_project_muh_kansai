<?php
    session_start();
    require_once '../admin/src/include/connectDB.php';

    // namespace phpmailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $email_err = $email = $capcha = $capcha_err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // validate captcha
        if(empty(trim($_POST['capcha']))){
            $capcha_err = "Insert captcha code above";
        }elseif(preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', trim($_POST['capcha']))){
            $capcha_err = "Invalid code";
        }elseif(trim($_POST['capcha']) != $_SESSION["captcha"]){
            $capcha_err = "Code didn,t match";
        }

        //validate email
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
                        $email = trim($_POST["email"]);
                    } else{
                        $email_err = "Email not found";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        if(empty($email_err) && empty($capcha_err)){
            $sql = "UPDATE account SET vkey = ? WHERE email = ? ";
            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "ss", $param_vkey, $param_email);
                $param_vkey = md5(time() . $email);
                $param_email = $email;

                if(mysqli_stmt_execute($stmt)){
                    // phpmailer librarry
                    require '../PHPMailer/src/Exception.php';
                    require '../PHPMailer/src/PHPMailer.php';
                    require '../PHPMailer/src/SMTP.php';
    
                    $mail = new PHPMailer(true);
    
                    // phpmailer setup pengirim
                    $email_pengirim = "likelemon212@gmail.com"; // email pengirim
                    $nama_pengirim  = 'Muhammadiyah Kansai'; // nama pengirim
                    $email_penerima = $_POST["email"];
                    $subjek = 'Request for password reset';
                    $pesan = "<p>Reset your password by clicking the link below</p><br>
                    <a href='http://localhost/muhammadiyah-kansai-back/account/reset_password.php?vkey=$param_vkey'>Reset Password</a>";
    
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
                        echo "<script>alert('We have sent a link to reset your password in the destination email, Please check your email');</script>";
                        echo "<script>document.location = '../index.php';</script>";
                    }
                }else{
                    echo "Oops! Something went wrong. Please try again later.";
                }

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
    <title>Recovery Account</title>
    <style>
        body{
            background: rgb(216, 216, 216);
        }
        .container{
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 100vh;
        }
        h1{
            text-align: center;
            margin-bottom: 2rem;
        }
        form{
            border: 1px solid rgb(219, 219, 219);
            border-radius: .5rem;
            background: #fff;
            padding: 1rem;
            max-width: 40rem;
            width: 100%;
        }
        .box{
            border: 1px solid var(--main-border-color);
            padding: 0.5rem 1rem;
            width: 100%;
        }.box:focus{
            border-color: orange;
        }
        button{
            margin-top: 1rem;
            float: right;
            cursor: pointer;
            padding: .5rem 1rem;
            border-radius: .5rem;
            font-weight: 600;
            font-size: 1rem;
            color: #fff;
            background: rgb(36, 182, 187);
        }button:hover{
            background: rgb(30, 144, 148);
        }
        p .alert{
            color: red;
            text-transform: capitalize;
        }
        .form-data{
            margin-bottom: 1rem;
        }.capcha{
            display: flex;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <form action="" method="post">
                <h1>Recovery Your Account</h1>
                <div class="form-data">
                    <p>Email <span class="alert"><?php echo $email_err;?></span></p>
                    <input type="text" name="email" value="<?php echo $email;?>" class="box">
                </div>
                <p><span class="alert"><?php echo $capcha_err;?></span></p>
                <div class="form-data capcha">
                    <img src="../include_main/capcha.php" alt="">
                    <input type="text" name="capcha" class="box" placeholder="insert capcha code">
                </div>
                <button type="submit">Send</button>
            </form>
        </div>
    </section>
</body>
</html>