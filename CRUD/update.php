<?php 
// it doesn't display the values sent by ajax in $_post
// add => if the oldname = new name (return none)
// if updated display a modal saying task updated !
session_start();

require "connection.php" ;
include "functions.php";

    
    $username = $_SESSION["name"]; 
    $task_old_name =sanitize($_POST["oldname"]) ;
    $task_new_name =sanitize($_POST["newname"]) ;
    $sql = "update  tasks set taskname = ?  where taskname = ? and username = ? ;";
    $st = $conn->prepare($sql);
    $st->execute([$task_new_name , $task_old_name , $username]);
    if($st->rowCount() == 1 ){
        echo true;

    } else {
        echo false;
    }




// with ajax update 
?>