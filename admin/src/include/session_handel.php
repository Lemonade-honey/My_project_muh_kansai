<?php
    error_reporting(E_ERROR);
    session_start();
    if(!isset($_SESSION["staff_loggedin"]) && $_SESSION["staff_loggedin"] != true){
        header("location: http://localhost/muhammadiyah-kansai-back/admin/login.php");
    }

    function balik($data){
        $data = str_replace("~*+", "'", $data);
        return $data;
    }

    function replace($data){
        $data = str_replace("'", "~*+", $data);
        return $data;
    }
?>