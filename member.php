<?php
    require 'admin/src/include/connectDB.php';
    include 'include_main/include.member.php';
    include 'include_main/session_manage.php';
    header("location: index.php", true, 301);
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style/css/member_style.css">
    <link rel="stylesheet" href="style/css/global_style.css">
    <link rel="stylesheet" href="style/css/main_navbar_style.css">
    <link rel="stylesheet" href="style/css/footer_index.css">
    <style>
        .container{
            min-height: 50vh;
        }
    </style>

    <title>Muhammadiyah Kansai || Member</title>
</head>
<body>
    <?php
        // include 'include_main/main_navbar.php';
    ?>
    <section>
        <form action="" method="get">
            <div class="pencarian">
                <input type="search" class="box" name="data" placeholder="Search...">
                <button type="submit" class="box btn">cari</button>
            </div>
            <div class="container">
                <div class="list-anggota">
                    <?php while(mysqli_stmt_fetch($stmt)){
                        if($profile_picture == null){
                            $profile_picture = "blank_null.png";
                        }else{
                            $scan = file_exists('./profile/' . $profile_picture);
                            if($scan == 1){
                                $profile_picture = $profile_picture;
                            }
                            else{
                                $profile_picture = "blank_null.png";
                            }    
                        }
                    ?>
                    <div class="card-anggota">
                        <div class="atas">
                            <div class="gambar">
                                <img loading="lazy" src="profile/<?php echo $profile_picture?>" alt="profile picture user">
                            </div>
                            <div class="data-anggota">
                                <div class="data">
                                    <img src="profile/simbol/profile.png" alt="">
                                    <p style="text-transform: uppercase;"><?php echo $name?></p>
                                </div>
                                <div class="data">
                                    <img src="profile/simbol/email.png" alt="">
                                    <p style="text-transform: none; text-decoration: underline;"><?php echo $email?></p>
                                </div>
                            </div>
                        </div>
                        <div class="bawah">
                            <a href="http://localhost/muhammadiyah-kansai-back/profile.php?user_id=<?php echo $id_user?>&user_name=<?php echo $name?>" class="btn">see profile</a>
                        </div>
                    </div>
                    <?php }?>
                </div>
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

    <?php
        include 'include_main/main_footer.php'
    ?>
</body>
</html>