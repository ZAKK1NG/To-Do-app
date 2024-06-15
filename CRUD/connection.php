<?php 
$dsn = "mysql:host=localhost;dbname=task_management;charset=UTF8";
try {
    $conn = new PDO($dsn , "root" , "Z@ki2004");
    $conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    return $conn ;
       



   
} catch(PDOException $e){
    die( "error : " . $e->getMessage()); 
}

?>