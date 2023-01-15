<?php
    require '../include/connectDB.php';
    include '../include/session_handel.php';
    include '../include/list_member.include.php';

    $number = null;
    if(isset($_GET["page"])){
        $page = $_GET["page"];
        
        if($page == 1){
            $number = 0;
        }else{
            $number = ($page*10) - 10;
        }
    }else{
        $number = 0;
    }
    

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

    <title>Member List || Muhammadiyah Kansai</title>
</head>
<body>
    <?php include '../include_content/navbar.php' ?>
    <main>
        <section>
            <div class="judul-container"><h1>member list</h1></div>
            <form action="" method="get">
                <div class="search">
                    <input type="search" name="data" class="box" placeholder="Search anything. . .">
                    <button type="submit" class="box cari"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                
                <div class="container">
                    <table>
                        <tbody>
                            <th>No</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Birth</th>
                            <th>Citizen</th>
                            <th>Joined Since</th>
                            <th>Action</th>
                        </tbody>
                        <?php while(mysqli_stmt_fetch($stmt)){ $number++;?>
                        <tr>
                            <td><?php echo $number?></td>
                            <td><?php echo $id_user?></td>
                            <td><?php echo $name?></td>
                            <td class="email"><?php echo $email?></td>
                            <td><?php echo date("d F Y", strtotime($date))?></td>
                            <td><?php echo $citizen?></td>
                            <td><?php echo date("d F Y", strtotime($create))?></td>
                            <td>
                                <a href="member_view.php?user_id=<?php echo $id_user?>&fullname=<?php echo $name?>&action=edit" class="action-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="member_view.php?user_id=<?php echo $id_user?>&fullname=<?php echo $name?>&action=delete" class="action-btn"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php }?>
                    </table>
                </div>
                <div class="paggingnation">
                    <?php for($i=1; $i<= $pages; $i++){ if(isset($_GET["data"])){?>
                        <a class="number" href="?data=<?php echo $_GET["data"]?>&page=<?php echo $i?>"><?php echo $i?></a>
                    <?php } else{?>
                        <a href="?page=<?php echo $i?>"><?php echo $i?></a>
                    <?php } }?>
                </div>
                </form>
        </section>
    </main>
</body>
</html>