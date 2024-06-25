<?php  
session_start(); 
include "functions.php";
require "connection.php" ; 
 header("location: ../index.php");
$username = $_SESSION["name"]; 
 
    if(!empty($_POST["task"])){
          
            $task = sanitize($_POST["task"]); 
            $sql = "insert into tasks(username,taskname)  values (?, ?);";
            $st = $conn->prepare($sql);
            $st->execute([$username , $task]);        
            if ($st->rowCount()==1){
                echo true;
            } 
            else {
                echo false;
            }
    }
     
 


?>