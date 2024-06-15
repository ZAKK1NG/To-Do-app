<?php


$response ="" ;
 
@include "../CRUD/functions.php"; //To fix : no file exists in such path error
@include "../CRUD/connection.php" ;

if(isset($_POST["submit"])){
    $user = sanitize($_POST["username"]) ;
    $password = sanitize($_POST["password"]);
    $remeberMe = $_POST["remember_me"];
  
     
    // fetching for user 
    $sql = "select username , password from users where username = ? and password = ? ;"; 
    $st = $conn->prepare($sql);
    $st->execute([$user , $password]);
    $returnedData = $st->fetch(PDO::FETCH_ASSOC);
     
    if($st->rowCount() !== 0){
      session_start();
      $_SESSION["name"] = $user ; 
      $response = true;
      echo $response; 
    
      if($remeberMe){
        setcookie("username" , $user , time()+3600 , "/");
      }
    } 
    
    
    
    
}


?>