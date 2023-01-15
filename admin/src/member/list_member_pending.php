<?php
    require '../include/connectDB.php';
    include '../include/session_handel.php';

    $sql = "SELECT id, name, email FROM account WHERE verified = 0";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_result($stmt, $id_user, $name, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }

    $number = 0;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../../style/css/list_style.css">
    <link rel="stylesheet" href="../../style/css/navbar.css">
    <link rel="stylesheet" href="../../../style/css/global_style.css">
    <script src="../js/navbar.js" defer></script>
    <style>
        td:first-child{
            width: 5rem;
        }
        td:nth-child(2){
            width: 5rem;
        }
        td:nth-child(3){
            width: 20rem;
        }
        td:nth-child(4){
            width: 20rem;
        }
        td:last-child{
            width: 6rem;
        }
    </style>

    <title>Member Pendding || Muhammadiyah Kansai</title>
</head>
<body>
    <?php include '../include_content/navbar.php' ?>
    <main>
        <section>
            <div class="judul-container"><h1>member pendding</h1></div>
            <form action="" method="get">
                <div class="container">
                    <table>
                        <tbody>
                            <th>No</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tbody>
                        <?php while(mysqli_stmt_fetch($stmt)){ $number++;?>
                        <tr>
                            <td><?php echo $number?></td>
                            <td><?php echo $id_user?></td>
                            <td><?php echo $name?></td>
                            <td class="email"><?php echo $email?></td>
                            <td><a href="member_view.php?user_id=<?php echo $id_user?>&fullname=<?php echo $name?>&action=delete" class="action-btn"><i class="fas fa-trash"></i></a></td>
                        </tr>
                        <?php } mysqli_stmt_close($stmt); ?>
                    </table>
                </div>
                </form>
        </section>
    </main>
</body>
</html>