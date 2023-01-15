<?php
    require '../include/connectDB.php';
    include '../include/session_handel.php';

    if(isset($_SESSION["staff_level"]) && $_SESSION["staff_level"] != 5){
        header("location: http://localhost/muhammadiyah-kansai-back/admin/login.php");
    }

    $username = $password = $username_err = $password_err = $confirm_password = $confirm_password_err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // email
        if(empty(trim($_POST["username"]))){
            $username_err = "enter username";
        }elseif(!filter_var(trim($_POST["username"]), FILTER_VALIDATE_EMAIL)){
            $username_err = "username not valid";
        }else{
            $sql = "SELECT id FROM staff WHERE email_staff = ?";
            
            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = trim($_POST["username"]);
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $username_err = "Already used";
                    } else{
                        $username = trim($_POST["username"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
                // Close statement
                mysqli_stmt_close($stmt);
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

        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
            $sql = "INSERT INTO staff(email_staff, password) VALUES(?, ?)";
            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
                $param_username = $username;
                $param_password = $password;
                if(mysqli_stmt_execute($stmt)){
                    echo "<script>alert('Staff account created successfully')</script>";
                    echo "<script>location.replace('list_staff.php')</script>";
                }else{
                    die("Opps! something wrong, try again leter");
                    exit;
                }
            }else{
                die("Error on database connection");
                exit;
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

    <title>Add Staff || Staff Portal</title>
    <link rel="stylesheet" href="../../../style/css/global_style.css">
    <link rel="stylesheet" href="../../style/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="../js/navbar.js" defer></script>
    <style>
        form{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .judul-container{
            margin-bottom: 2rem;
        }
        .container-staff{
            border: 1px solid var(--main-border-color);
            padding: 1rem;
            width: 100%;
            border-radius: .5rem;
        }.form-data{
            margin-bottom: 1rem;
        }.form-data p{
            margin-bottom: 0.5rem;
        }.form-data .box{
            padding: .5rem 1rem;
            border: 1px solid var(--main-border-color);
            width: 100%;
        }
        .btn{
            float: right;
            padding: .5rem 1rem;
            border-radius: .5rem;
            font-size: 1.2rem;
            cursor: pointer;
            background: var(--main-navbar_index-color);
            color: #fff;
        }
    </style>
</head>
<body>
    <?php include '../include_content/navbar.php' ?>
    <main>
        <section>
            <div class="judul-container"><h1>Add Staff</h1></div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="container-staff">
                    <div class="form-data">
                        <p>Email <span class="alert"><?php echo $username_err?></span></p>
                        <input type="text" name="username" class="box">
                    </div>
                    <div class="form-data">
                        <p>Password <span class="alert"><?php echo $password_err?></span></p>
                        <input type="text" name="password" class="box">
                    </div>
                    <div class="form-data">
                        <p>Confirm Password <span class="alert"><?php echo $confirm_password_err?></span></p>
                        <input type="text" name="confirm_password" class="box">
                    </div>
                    <div class="form-submit">
                        <button type="submit" class="btn">Create</button>
                    </div>
                </div>
            </form>
        </section>
    </main>
</body>
</html>