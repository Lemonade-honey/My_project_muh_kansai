<?php
    require '../include/connectDB.php';
    include '../include/view.include.php';
    include '../include/session_handel.php';

    session_start();
    error_reporting(E_ERROR);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style/css/global_style.css">
    <link rel="stylesheet" href="../../style/css/member_view.css">
    <link rel="stylesheet" href="../../style/css/navbar.css">
    <title>Member</title>
</head>
<body>
    <?php include '../include_content/navbar.php' ?>
    <main>
        <form action="" method="post">
            <section>
                <div class="container-member">
                    <div class="member-data">
                        <div class="gambar">
                            <img src="../../../profile/daffa.jpg" alt="">
                            <p>create at <?php echo date("d-m-Y, H:i", strtotime($create))?></p>
                        </div>
                        <div class="user-data">
                            <div class="data">
                                <p>name <span class="alert"><?php echo $name_err?></span></p>
                                <input type="text" name="name" class="box capital" value="<?php echo $name?>" disabled>
                            </div>
                            <div class="data">
                                <p>email <span class="alert"><?php echo $email_err?></span></p>
                                <input type="text" name="email" class="box" value="<?php echo $email?>" disabled>
                            </div>
                            <div class="data">
                                <p>date birth <span class="alert"><?php echo $date_birth_err?></span></p>
                                <input type="date" name="date_birth" class="box" value="<?php echo $date?>" disabled>
                            </div>
                            <div class="data">
                                <p>citizen <span class="alert"><?php echo $citizen_err?></span></p>
                                <select name="citizen" id="hasil" class="box" disabled>
                                    <option value="<?php echo $citizen?>" selected><?php echo $citizen?></option>
                                </select>
                            </div>
                            <div class="data">
                                <p>handphone <span class="alert"><?php echo $phone_err?></span></p>
                                <input type="number" name="phone" class="box" value="<?php echo $phone?>" disabled>
                            </div>
                            <div class="data">
                                <p>job <span class="alert"><?php echo $job_err?></span></p>
                                <input type="text" name="job" class="box" value="<?php echo $job?>" disabled>
                            </div>
                            <div class="data">
                                <p>skill <span class="alert"><?php echo $skill_err?></span></p>
                                <input type="text" name="skill" class="box" value="<?php echo $skill?>" disabled>
                            </div>
                            <?php foreach($button as $btn){echo $btn;}?>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </main>
    
    <script>
        <?php echo $script?>
        let target = document.getElementById("hasil")
        fetch("https://restcountries.com/v2/all")
        .then(res => res.json())
        .then(data => initialize(data))
        .catch(err => console.log("Error: ", err));
        
        function initialize(contriesData){
            countries = contriesData;
            let option = "";
            for(i in countries){
                negara = countries[i].name;
                value = countries[i].alpha3Code;
                var opt = document.createElement('option')
                opt.value = negara
                opt.innerHTML = negara
                target.appendChild(opt)
            }
        }
    </script>
</body>
</html>