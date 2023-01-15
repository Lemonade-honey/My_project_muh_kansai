<?php
    require 'admin/src/include/connectDB.php';
    include 'include_main/include.profile.php';
    header("location: index.php", true, 301);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muhammadiyah Kansai || Profile</title>
    <link rel="stylesheet" href="style/css/profile_style.css">
    <link rel="stylesheet" href="style/css/global_style.css">
    <link rel="stylesheet" href="style/css/main_navbar_style.css">
</head>
<body>
    <?php
        include 'include_main/main_navbar.php';
    ?>
    <section>
        <form method="post">
        <div class="profile-container">
            <div class="sub-container">
                <div class="gambar">
                    <div class="picture-border"><img src="profile/<?php echo $profile_picture?>" alt=""></div>
                </div>
                <div class="negara">
                    <div id="flag_country"></div>
                </div>
                <div class="background">
                    <img src="images/sakura_tree.png" alt="">
                </div>
            </div>
            <div class="sub-container">
                <div class="data-user">
                    <div class="data">
                        <p>Full Name</p>
                        <input type="text" class="box capital" name="name" value="<?php echo $full_name?>" disabled>
                    </div>
                    <div class="data">
                        <p>Email</p>
                        <input type="text" class="box" id="email" value="<?php echo $email_user?>" disabled>
                    </div>
                    <div class="data">
                        <p>Date Birth</p>
                        <input type="text" class="box" id="date" name="date_birth" value="<?php echo date("d F Y", strtotime($date_birth))?>" disabled>
                    </div>
                    <div class="data">
                        <p>Handphone</p>
                        <input type="number" class="box" name="phone_number" value="<?php echo htmlspecialchars($phone_number)?>" disabled>
                    </div>
                    <div class="data">
                        <p>Address</p>
                        <textarea class="box" name="address" cols="30" rows="3" disabled><?php echo htmlspecialchars($address)?></textarea>
                    </div>
                    <div class="data">
                        <p>Skill</p>
                        <textarea class="box" name="skill" cols="30" rows="2" disabled><?php echo htmlspecialchars($skill)?></textarea>
                    </div>
                </div>
            </div>
            <div class="sub-container">
                <div class="data-user">
                    <div class="data">
                        <p>Job</p>
                        <input type="text" class="box" name="job" value="<?php echo htmlspecialchars($job)?>" disabled>
                    </div>
                    <div class="data">
                        <div class="isi">
                            <p>Line</p>
                            <img src="images/sosial-icons/line.png" alt="">
                        </div>
                        <input type="text" class="box" name="line" value="<?php echo htmlspecialchars($line)?>" disabled>
                    </div>
                    <div class="data">
                        <div class="isi">
                            <p>Instagram</p>
                            <img src="images/sosial-icons/instagram.png" alt="">
                        </div>
                        <input type="text" class="box" name="instagram" value="<?php echo $ig?>" disabled>
                    </div>
                    <div class="data">
                        <div class="isi">
                            <p>Twitter</p>
                            <img src="images/sosial-icons/twitter.png" alt="">
                        </div>
                        <input type="text" class="box" name="twitter" value="<?php echo $twt?>" disabled>
                    </div>
                    <div class="data">
                        <div class="isi">
                            <p>Joined</p>
                        </div>
                        <input type="text" class="box" value="<?php echo date("d-F-Y, H:i", strtotime($create_date))?>" id="bergabung" disabled>
                    </div>
                    <?php foreach($button as $btn){ echo $btn;}?>
                </div>
            </div>
        </div>
    </form>
</section>
<script>
    <?php echo $script?>
    document.getElementById("email").setAttribute("disabled", true);
    document.getElementById("date").setAttribute("disabled", true);
    document.getElementById("bergabung").setAttribute("disabled", true);
    
    let citizen = '<?php echo $citizen?>'
    let URL = `https://restcountries.com/v3.1/name/${citizen}`
    fetch(URL).then((Response) => Response.json()).then((data) =>{
        document.getElementById("flag_country").innerHTML = `<center><img class="bendera" src="`+ data[0].flags.svg +`"></img></center>`
        console.log(data[0].flags.svg)
    })
</script>
    <?php mysqli_stmt_close($stmt); mysqli_close($conn)?>
</body>
</html>