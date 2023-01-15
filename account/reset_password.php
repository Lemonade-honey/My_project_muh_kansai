<?php
    require_once '../admin/src/include/connectDB.php';

    $password = "";
    $password_err = $confirm_password_err = "";

    if(isset($_POST['reset_password'])){
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

        if(empty($password_err) && empty($confirm_password_err)){
            $sql = "UPDATE account SET password = ?, vkey = ? WHERE vkey = ?";
            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "sss", $param_password, $param_vkey, $param_oldvkey);
                $param_password = password_hash($password, PASSWORD_DEFAULT);
                $param_vkey = md5(time() . $password);
                $param_oldvkey = $_GET["vkey"];
                if(mysqli_stmt_execute($stmt)){
                    echo "<script>alert('Change password succses');</script>";
                    echo "<script>document.location = 'login.php';</script>";
                }else{
                    die("Oops! Something went wrong. Please try again later. Close this tab");
                    exit;
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
    <title>Reset Password</title>
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
        .form-data{
            margin-bottom: 1rem;
        }
        .box{
            border: 1px solid var(--main-border-color);
            padding: 0.5rem 1rem;
            width: 100%;
        }.box:focus{
            border-color: orange;
        }
        button{
            float: right;
            margin-top: 1rem;
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
        p{
            text-transform: capitalize;
        }
        p .alert{
            color: red;
            text-transform: capitalize;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <form action="" method="post">
                <h1>Reset Password</h1>
                <div class="form-data">
                    <p>new password <span class="alert"><?php echo $password_err;?></span></p>
                    <input type="text" name="password" class="box">
                </div>
                <div class="form-data">
                    <p>confirm password <span class="alert"><?php echo $confirm_password_err;?></span></p>
                    <input type="text" name="confirm_password" class="box">
                </div>
                <button type="submit" name="reset_password">Reset</button>
            </form>
        </div>
    </section>
</body>
</html>