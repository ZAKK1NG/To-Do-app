
<?php
require "../CRUD/connection.php";
include "../CRUD/functions.php";
header("location: ../index.php");
// Initialize response variable
$response = "";

// Check if form was submitted
if (isset($_POST["submit"])) {
    // Sanitize inputs
    $name = sanitize($_POST["username"]);
    $password = sanitize($_POST["password"]);

    // Check if username exists
    $st1 = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $st1->execute([$name]);

    if ($st1->rowCount() == 1) {
        $response = false; // Username already exists
    } else {
        // Insert new user
        $st2 = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?);");
        $st2->execute([$name, $password]);

        if ($st2->rowCount() == 1) {
            $response = true; // Account created successfully
        } else {
            $response = false ;
        }
    }

    // Output the response
    

    // Handle "remember me" functionality
    if (isset($_POST["rememberme"]) && $_POST["rememberme"] == true) {
        setcookie("username", $name, time() + 3600, "/");
        
        // Redirect to index.php Ensure no further code is executed after the redirect
        // header("Location: ../index.php"); won't work because you're using ajax   
        echo $response;
        
    }
}

?>
