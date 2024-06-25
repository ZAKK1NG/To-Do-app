<?php 
session_start();

require "connection.php" ;
include "functions.php";
header("location: ../index.php");
$username = $_SESSION["name"]; 
$task = sanitize($_POST["taskname"]) ;
$checked  = $_POST["checkbox_checked"];

if($checked == "yes"){
        $sql = "update  tasks set done = true  where taskname = ? and username = ? ;";
            $st = $conn->prepare($sql);
            $st->execute([ $task  , $username]);
            if($st->rowCount() == 1 ){
                echo "task is true now";
        
            } else {
                echo "error true";
            }

    } 
else if ($checked == "no"){
    $sql = "update  tasks set done = false  where taskname = ? and username = ? ;";
            $st = $conn->prepare($sql);
            $st->execute([ $task  , $username]);
            if($st->rowCount() == 1 ){
                echo "task is false now";
        
            } else {
                echo "error false";
            }
}


?>