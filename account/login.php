<?php
    require '../admin/src/include/connectDB.php';
    // Initialize the session
    session_start();
     
    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: ../index.php");
        exit;
    }

    $email = $password = "";
    $error = $email_err = $password_err ="";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // validate email
        if(empty(trim($_POST["email"]))){
            $email_err = "Enter your e-mail";
        }elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
            $email_err = "Email not valid";
        }
        else{
            $email = trim($_POST["email"]);
        }
        
        // validate password
        if(empty(trim($_POST["password"]))){
            $password_err = "Enter your password";
        } else{
            $password = trim($_POST["password"]);
        }

        if(empty($email_err) && empty($password_err)){
            // Prepare a select statement
            $sql = "SELECT id, email, password, name, verified FROM account WHERE email = ?";
            
            if($stmt = mysqli_prepare($conn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_email);
                
                // Set parameters
                $param_email = $email;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Store result
                    mysqli_stmt_store_result($stmt);
                    
                    // Check if email exists, if yes then verify password
                    if(mysqli_stmt_num_rows($stmt) == 1){                    
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $name, $verified);
                        if(mysqli_stmt_fetch($stmt)){
                            // jika akun sudah terverifikasi
                            if(password_verify($password, $hashed_password)){
                                if($verified == 1){
                                    // Password is correct, so start a new session
                                    session_start();
                                    
                                    // Store data in session variables
                                    session_regenerate_id(true);
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["email"] = $email;
                                    $_SESSION["name"] = $name;
                                    $_SESSION["rand"] = md5(rand());
                                                            
                                    // Redirect user
                                    header("location: ../index.php");
                                }else{
                                    // kalo akun belum terverivikasi
                                    $error = "Account not verified";
                                }
                            }else{
                                // Password is not valid
                                $error = "Invalid email or password.";
                            }
                            
                        }
                    }else{
                        // email doesn't exist
                        $error = "Invalid email or password.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                mysqli_stmt_close($stmt);
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

    <title>Login || Muhammadiyah Kansai</title>
</head>
<body>
    <div class="login-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>login</h1>
            <div class="status-error"><?php echo $error;?></div>
            <div class="form-data">
                <p>Username <span class="alert"><?php echo $email_err;?></span></p>
                <input type="text" name="email" value="<?php echo $email;?>" class="box">
            </div>
            <div class="form-data">
                <p>Password <span class="alert"><?php echo $password_err;?></span></p>
                <input type="password" name="password" class="box">
            </div>
            <div class="submit-data">
                <p>don't have an account ? <a href="register.php">registerd now</a></p>
                <p>forget your password ? <a href="recovery_account.php">recovery password</a></p>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>