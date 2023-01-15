<?php
    require 'src/include/connectDB.php';
    error_reporting(E_ERROR);
    session_start();
    session_destroy();

    $username = $password = $username_err = $password_err = $error = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["username"]))){
            $username_err = "username error";
        }elseif(!filter_var(trim($_POST["username"]), FILTER_VALIDATE_EMAIL)){
            $username_err = "username not valid";
        }else{
            $username = trim($_POST["username"]);
        }


        if(empty(trim($_POST["password"]))){
            $password_err = "empty password";
        }else{
            $password = htmlspecialchars(trim($_POST["password"]));
        }

        


        if(empty($error)){
            $sql = "SELECT id, email_staff, password, level FROM staff WHERE email_staff = ?";
            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = $username;
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        mysqli_stmt_bind_result($stmt, $staff_id, $staff_username, $staff_password, $level);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $staff_password)){
                                session_start();
                                session_regenerate_id(true);
                                $_SESSION["staff_loggedin"] = true;
                                $_SESSION["staff_level"] = $level;
                                $_SESSION["staff_username"] = $staff_username;
                                $_SESSION["staff_id"] = $staff_id;
                                header("location: src/dashboard.php", true, 301);
                            }else{
                                $error = "username or password not valid";
                            }
                        }
                    }else{
                        echo "tidak ada akun";
                    }
                }
                else{
                    die("execute error");
                }




            }else{
                die("Error database proses");
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

    <link rel="stylesheet" href="../style/css/global_style.css">
    <link rel="stylesheet" href="../style/css/login_style.css">

    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>login staff</h1>
            <div class="status-error"><?php echo $error?></div>
            <div class="form-data">
                <p>Username <span class="alert"><?php echo $username_err?></span></p>
                <input type="text" name="username" value="<?php echo $username?>" class="box">
            </div>
            <div class="form-data">
                <p>Password <span class="alert"><?php echo $password_err?></span></p>
                <input type="password" name="password" class="box">
            </div>
            <div class="submit-data">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>