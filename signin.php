<!-- Soon => add regex to the password  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" 
    integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
     integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jquery file  -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- main css file -->
        <link rel="stylesheet" href="css/signin.css">
     <style>
        
     </style>
</head>
<body >
    <div id="particles-js"></div>
    
        <div id="modal" class="p-3 border  border-2 rounded-3 border-success text-success fw-bold text-center">
            Account Added Sucessfully ! <a href="index.php" target="_self">Go To App</a>
        </div>
    
    <div class="container w-75   row mx-auto ">
        <aside class="leftSide col-sm-12 col-md-7 ">
            <div class="headers d-flex gap-3 flex-column">
            <h1 class="orange">Welcome To</h1>
             <h1 class="orange">TO<span id="do">D<i class="fa-solid fa-circle-check"></i></span>
             <h1 class="orange">App</h1>
            </div>
             
        </aside>
        <aside class="rightSide col-sm-12 col-md-5 p-3 ">
            <div class="cont ">
                 <h1 class="orange">SIGN IN </h1>
          
                <form method="post"  class="p-4" id="form"  >
                    <div class="mb-4">
                        <label for="email" class="form-label orange ps-2">USERNAME</label>
                        <input type="text" class="form-control w-100 rounded-pill  my-1" id="username"  name="username" required >
                         <span class="errmsg text-danger ps-2" ></span>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label orange ps-2">PASSWORD</label>
                        <input type="password" class="form-control w-100 rounded-pill  my-1" id="password" name="password" required>
                        <span class="errmsg2 text-danger ps-2" ></span>
                        <div class="show-pword text-end py-1"><p id="ShowPassword">SHOW PASSWORD <i class="fa-regular fa-eye"></i></p></div>
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input " name="remember-me"  id="checkbox">
                        <label class="form-check-label orange" for="checkbox"> REMEMBER ME </label>
                    </div>
                    <button type="submit" name="submit" value="submit" id="subBtn" class="btn btn-primary w-100 rounded-pill">SUBMIT</button>
                </form>
                <div class="social-media">

                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="https://www.instagram.com/zak__mesbahi/"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://github.com/ZAKK1NG"><i class="fa-brands fa-github"></i></a>
                </div>
            </div>
        </aside>
    </div>
    <script>
        $(".errmsg").hide() ;
        $(".errmsg2").hide() ;
        $("#ShowPassword").click(function(){
            // toggling type (text , password ) to show pw
            let attr = $("#password").attr("type") ;
            if(attr =="password") {
                $("#password").attr("type" ,"text");
                $("#ShowPassword").html("HIDE PASSWORD <i class='fa-regular fa-eye'></i>")
            }
            else if (attr =="text") {
                $("#password").attr("type" ,"password");
                $("#ShowPassword").html("SHOW PASSWORD <i class='fa-regular fa-eye'></i>")
            }
        })
        $("#form").submit(function(e){
            e.preventDefault();
            let name = $("#username").val();
            let password = $("#password").val() ; 
            let rememberMe = $("#checkbox").is(":checked"); 
            if (password.length < 8 ){
                $(".errmsg2").text("Password Should be longer than 8 characters !");
                   $(".errmsg2").show();
            }
            else {
                $.ajax({
                method : "post" ,
                url : "Validation/signInValidation.php",
                data: {
                    username : name,
                    password : password,
                    rememberme : rememberMe ,
                    submit : "submit"
                }
                
            }).done(function(response){
             
                console.log("data sent");
                
                if (!response) {
                    console.log("false");
                   $(".errmsg").text("Username Already exists !");
                   $(".errmsg").show();
                }  else if (response) {
                    console.log("truee");
                    
                    $("#modal").css("top" , "8%");
                    
                    $("#username").val("") ;
                    $("#password").val("") ;
                }
            }) .fail(function(xhr){
                console.log(`Error ${xhr.status} : ${xhr.error}`);
            })
            }
            
            
        })
        
    </script>
     <!-- Particle js library -->
     <script type="text/javascript" src="assets/Particles js/particles.js"></script>
    <script type="text/javascript" src="assets/Particles js/app.js"></script>
</body>

  
</html>