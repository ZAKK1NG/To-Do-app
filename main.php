<?php  
//add see password button  and remember me button 
//add custom checkbox for rememeber me 
include "Validation/login.php";
if(isset($_COOKIE["username"])){
  header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <!-- jquery file  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- main css file -->
    <link rel="stylesheet" href="css/mainfile.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
  <div id="particles-js"></div>
    <div class="wrap">
      <!-- background video & scroll reveal  soon  -->
      <div class="content">
          <h1>Stay Organized, Stay Productive</h1>
          <p>Join us to manage your tasks efficiently. Sign up now to create your personalized to-do list!</p>
          <div class="btnGroup" >
            <a   class="callToAction1" id="logIn">Get Started</a>
            <a href="signin.php" class="callToAction" id="SignIn">Sign In </a>
          </div>
            
      </div>
      <div class="modal hide">
        <form  method="post" id="form">
          <div class="header">
              <p>Log In </p>
              <i class="fa-solid fa-xmark"></i> 
          </div>
          <div class="body">
              <input type="text"   placeholder="Your Username" name="username" id="username" autocomplete="off" required>
              <input type="password"   placeholder="Your Password" name="password" id="password"  required>
              <p for="rememberMe"><input type="checkbox" name="rememberMe" id="rememberMe" value="true" class="form-check-input"> Remember Me</p>
              <span class="errMsg">Username or Password is incorrect</span>
          </div>
          <div class="footer">
            <input type="submit" value="Submit"   name="submit" id="modalBtn">
          </div>
        </form>
      </div>
    </div>

        
  <script>
         $(document).ready(function() {
              $("#logIn").click(function(event) {
            
                  $(".modal").removeClass("hide") ;
                  $(".errMsg").hide();
                  $(".modal").addClass("active");
              });

              $("#form").submit(function(event) {
        
                  event.preventDefault();
                  $.ajax({
                      method: "POST",
                      url: "Validation/login.php",
                      data: {
                        username: $("#username").val(),
                        password: $("#password").val(),
                        remember_me : $("#rememberMe").val(),
                        submit: "submit"
                            }})
                      .done(function(response) {     
                          if(!response){
                            $(".errMsg").show();
                          }
                          else if(response) {
                            $(".modal").removeClass("active") ;
                            $(".errMsg").hide();
                            $(".modal").addClass("hide");
                            $("#username").val("");
                            $("#password").val("");
                            window.open("index.php" ,"_self");
                          }})
                      .fail(function() {
                            console.log("Infos not sent!");
                          });
      
              });
              $(".fa-xmark").click(function(){
                    $(".modal").addClass("hide");
                    $(".modal").removeClass("active") ;
                    $("#username").val("");
                    $("#password").val("");
                })
              });
  
  </script>
  <!-- Particle js library -->
  <script type="text/javascript" src="assets/Particles js/particles.js"></script>
  <script type="text/javascript" src="assets/Particles js/app.js"></script>
</body>
</html>
