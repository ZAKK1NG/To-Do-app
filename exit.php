<?php 
    session_start(); 
    session_destroy(); 
    setcookie("username" ,  $_COOKIE["username"] , time()-3600 , "/"  );
    header("location:main.php");
?>