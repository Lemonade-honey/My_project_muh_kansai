<?php
    require '../include/connectDB.php';
    include '../include/session_handel.php';

    if(isset($_SESSION["staff_level"]) && $_SESSION["staff_level"] != 5){
        header("location: http://localhost/muhammadiyah-kansai-back/admin/login.php");
    }

    if(isset($_GET["staff_id"])){
        $id_target = htmlspecialchars(trim($_GET["staff_id"]));
        $sql = "SELECT email_staff FROM staff WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id_target;
        mysqli_stmt_bind_result($stmt, $email_staff);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $sql = "DELETE FROM staff WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $id_target;
            if(mysqli_stmt_execute($stmt)){
                echo "<script>alert('Staff account has successfully deleted')</script>";
                echo "<script>location.replace('list_staff.php')</script>";
            }else{
                die("Opps! something wrong, try again leter");
                exit;
            }
        }
    }
    else{
        // header("location: http://localhost/muhammadiyah-kansai-back/admin/login.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../../images/staff_logo/wrench.png">
    
    <title>Delete Staff || Staff Portal</title>
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
        .btn.red{
            float: right;
            padding: .5rem 1rem;
            border-radius: .5rem;
            font-size: 1.2rem;
            cursor: pointer;
            background: rgb(243, 53, 53);
            color: #fff;
        }.btn.red:hover{
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <?php include '../include_content/navbar.php' ?>
    <main>
        <section>
            <div class="judul-container"><h1>Delete Staff</h1></div>
            <form action="" method="post">
                <div class="container-staff">
                    <div class="form-data">
                        <p>Username <span class="alert"></span></p>
                        <input type="text" name="username" value="<?php echo $email_staff?>" class="box" disabled>
                    </div>
                    <div class="form-submit">
                        <button type="submit" class="btn red">Delete</button>
                    </div>
                </div>
            </form>
        </section>
    </main>
</body>
</html>