<?php 
// delete using ajax (not done )
header("location:../index.php");
session_start(); 
require "connection.php" ;
$taskToDelete = $_POST["task"];
$username  = $_SESSION["name"];
$sql = "delete from tasks where taskname = ? and username = ? "; 
$st = $conn->prepare($sql);
$st->execute([$taskToDelete , $username]) ; 
if ($st->rowCount() == 1 ){
    echo true;
} else {
    echo false;
}


?>