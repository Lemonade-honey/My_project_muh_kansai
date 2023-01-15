<?php
    require '../include/connectDB.php';
    include '../include/session_handel.php';
    if(isset($_SESSION["staff_level"]) && $_SESSION["staff_level"] != 5){
        header("location: http://localhost/muhammadiyah-kansai-back/admin/login.php");
    }

    $number = 1;
    $sql = "SELECT id, email_staff, create_at FROM staff";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_result($stmt, $staff_id, $staff_email, $create);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(isset($_GET["data"])){
        mysqli_stmt_close($stmt);
        $data = htmlspecialchars(trim($_GET["data"]));
        $sql = "SELECT id, email_staff, create_at FROM staff WHERE email_staff LIKE '%".$data."%' ORDER BY id ASC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_result($stmt, $staff_id, $staff_email, $create);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../../images/staff_logo/wrench.png">

    <title>List Staff || Staff Portal</title>
    <link rel="stylesheet" href="../../style/css/list_style.css">
    <link rel="stylesheet" href="../../../style/css/global_style.css">
    <link rel="stylesheet" href="../../style/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <script src="../js/navbar.js" defer></script>
    <style>
        td:nth-child(3){
            min-width: 18rem;
            text-transform: none;
        }
        td:nth-child(4){
            min-width: 3rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include '../include_content/navbar.php' ?>
    <main>
    <section>
        <div class="judul-container"><h1>staff list</h1></div>
        <form action="" method="get">
            <div class="search">
                <input type="search" name="data" class="box" placeholder="Search anything. . .">
                <button type="submit" class="box cari"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="container">
                <table>
                    <tbody>
                        <th>No</th>
                        <th>Staff ID</th>
                        <th>Email</th>
                        <th>Joined Since</th>
                        <th>Action</th>
                    </tbody>
                    <?php while(mysqli_stmt_fetch($stmt)){?>
                    <tr>
                        <td><?php echo $number++?></td>
                        <td><?php echo $staff_id?></td>
                        <td><?php echo $staff_email?></td>
                        <td><?php echo date("d-m-Y", strtotime($create))?></td>    
                        <td><a href="delete_staff.php?staff_id=<?php echo $staff_id?>"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    <?php } mysqli_stmt_close($stmt)?>
                </table>
            </div>
        </form>
    </section>
    </main>
</body>
</html>