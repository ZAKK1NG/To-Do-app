<?php  
include "functions.php";
header("location: ../index.php");
session_start(); 
$username = $_SESSION["name"]; 
require "connection.php" ; 
if(isset($_POST["submit"]) ){
    if(!empty($_POST["task"])){
        $task = sanitize($_POST["task"]); 
        $sql = "insert into tasks(username,taskname)  values (?, ?);";
        $st = $conn->prepare($sql);
        $st->execute([$username , $task]);
        
    } else {
        die(); 
    }
   
};


?>