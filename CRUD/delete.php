<?php 
// delete using ajax (not done )
session_start(); 
require "connection.php" ;
$username = $_SESSION["name"]; 
echo $username ."<br>"; 
$taskname =  $_GET["name"]; 
echo $taskname ; 
$sql = "delete from tasks where taskname = ? and username = ? "; 
$st = $conn->prepare($sql);
$st->execute([$taskname , $username]) ; 
if ($st->rowCount() == 1 ){
    echo "done !";
} else {
    echo "not done !";
}
header("location:../index.php");

?>