<?php 
// function to validate data 

function sanitize($data) {
    
    $data = trim($data);  // Correct usage of trim
    $data = stripslashes($data); 
    $data = htmlspecialchars($data);
    return $data; 
}

?>