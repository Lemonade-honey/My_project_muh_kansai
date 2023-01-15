<?php
    require 'include/connectDB.php';
    include_once 'include/session_handel.php';

    $data_count = array();
    // member calc
    // $sql = "SELECT * FROM account";
    // $stmt = mysqli_prepare($conn, $sql);
    // mysqli_stmt_execute($stmt);
    // mysqli_stmt_store_result($stmt);
    // array_push($data_count, mysqli_stmt_num_rows($stmt));
    // mysqli_stmt_close($stmt);

    // news calc
    $sql = "SELECT * FROM news";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    array_push($data_count, mysqli_stmt_num_rows($stmt));
    mysqli_stmt_close($stmt);

    // timeline
    $sql = "SELECT * FROM timeline";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    array_push($data_count, mysqli_stmt_num_rows($stmt));
    mysqli_stmt_close($stmt);

    mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../images/staff_logo/wrench.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../../style/css/global_style.css">
    <link rel="stylesheet" href="../style/css/dashboard_style.css">
    <link rel="stylesheet" href="../style/css/navbar.css">

    <script src="js/navbar.js" defer></script>

    <title>Dashboard || Staff Portal</title>
</head>
<body>
    <?php include 'include_content/navbar.php'?>
    <main>
        <section>
            <div class="judul-container"><h1>dashboard</h1></div>
            <div class="dasbord-container">
                <!-- <a href="">
                    <div class="content-dasbord">
                        <div class="isi">
                            <p>Member</p>
                            <p></p>
                        </div>
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                </a> -->
                <a href="">
                    <div class="content-dasbord">
                        <div class="isi">
                            <p>News</p>
                            <p><?php echo $data_count[0]?></p>
                        </div>
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                </a>
                <a href="">
                    <div class="content-dasbord">
                        <div class="isi">
                            <p>Activity</p>
                            <p><?php echo $data_count[1]?></p>
                        </div>
                        <i class="fa-solid fa-table-list"></i>
                    </div>
                </a>
            </div>
        </section>
    </main>
</body>
</html>