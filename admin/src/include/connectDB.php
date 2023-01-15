<?php
    // LOCAL PC SERVER
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $DB = 'muhammadiyah_kansai';
    $conn = mysqli_connect($host, $username, $password, $DB);

    if(!$conn)
    {
        die("can't connect to database, contact administration");
        exit;
    }

    date_default_timezone_set("Asia/Jakarta");
?>