<?php
    require_once '../admin/src/include/connectDB.php';
    $massage = "";
    if(isset($_GET["vkey"])){

        // $sql = "SELECT FROM account WHERE vkey = ? AND verified = 0 LIMIT 1";
        $sql = "SELECT verified, vkey FROM account WHERE verified = 0 AND vkey = ? LIMIT 1";

        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_vkey);
            $param_vkey = $_GET["vkey"];

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_close($stmt);

                    $sql = "UPDATE account SET verified = ?, vkey = ? WHERE vkey = ? LIMIT 1";
                    if($stmt = mysqli_prepare($conn, $sql)){
                        mysqli_stmt_bind_param($stmt, "iss", $param_verified, $param_vkey, $param_oldvkey);
                        $param_verified = 1;
                        $param_oldvkey = $_GET["vkey"];
                        $param_vkey = md5(time().$param_oldvkey);
                        if(mysqli_stmt_execute($stmt)){
                            $massage = "Account verified";
                        }else{
                            die("Failed to verify account, please try again later");
                        }
                    }else{
                        die("Failed to verify account, please try again later");
                        exit;
                    }
                    mysqli_stmt_close($stmt);
                }
                else{
                    die("This account may already be verified or not valid");
                    exit;
                }
            }
        }

        mysqli_close($conn);
    }
    else{
        // header("location: ../index.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/css/global_style.css">
    <style>
        .container{
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 100vh;
        }
        .gambar img{
            object-fit: cover;
            object-position: center;
            animation-name: up_and_down_loop;
            animation-duration: 3s;
            animation-iteration-count: infinite;
            animation-timing-function: ease-out;
            position: relative;
        }@keyframes up_and_down_loop{
            0%{
                transform: translate(1px, 1px) rotate(0deg);
            }
            50%{
                transform: translate(1px, 1px) rotate(10deg);
            }
            70%{
                transform: translate(1px, 1px) rotate(20deg);
            }
            75%{
                transform: translate(1px, 1px) rotate(10deg);
            }
            80%{
                transform: translate(1px, 1px) rotate(20deg);
            }
            85%{
                transform: translate(1px, 1px) rotate(10deg);
            }
            100%{
                transform: translate(1px, 1px) rotate(0deg);
            }
        }
        .angka{
            display: none;
        }
        .angka #count{
            padding: 1.7rem 3rem;
            font-size: 3rem;
            font-weight: 600;
            color: #fff;
            background-color: rgb(49, 194, 204);
            border-radius: .5rem;
        }

        .content{
            text-align: center;
            margin-top: 2rem;
            text-transform: capitalize;
        }
        .content h1{
            text-transform: capitalize;
        }
    </style>
    <title>Verified Account</title>
</head>
<body>
    <section>
        <div class="container">
            <div class="gambar">
                <img src="../images/random/checked.png" alt="" id="gambar1">
            </div>
            <div class="angka">
                <div id="count"></div>
            </div>
            <div class="content">
                <h1><?php echo $massage;?></h1>
                <p>Go To</p>
                <a href="login.php">login page</a>
            </div>
        </div>
    </section>
    <script>
        var counter = 10;
        let gambar = document.querySelector(".gambar")
        let angka = document.querySelector(".angka")
        if(counter >= 0){
            setInterval(function(){
                counter--;
                if(counter >= 0){
                    id = document.getElementById("count");
                    id.innerHTML = counter;
                }
                if(counter === 5){
                    gambar.style.display = 'none'
                    angka.style.display = 'block'
                }
                if(counter === -1){
                    // window.location.replace("login.php");
                }
            }, 1250);
        }
    </script>
</body>
</html>