<?php
    require 'admin/src/include/connectDB.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST["email"];
        $passw = $_POST["password"];

        $sql = "INSERT INTO staff(email_staff, password) VALUES(?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);
        $param_email = $email;
        $param_password = password_hash($passw, PASSWORD_DEFAULT);

        if(mysqli_stmt_execute($stmt)){
            echo $param_password . "<br>";
            echo $passw;
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <p>email</p>
        <input type="text" name="email">
        <p>password</p>
        <input type="text" name="password">
        <button type="submit">buat</button>
    </form>
</body>
</html>