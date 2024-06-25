<?php 
// hide the delete link (convert to a js method)
// problem : remove the update input in case of not pressing enter 
// problem : data doesn't get trimmed when sending
// add done == true if checked
// complete delete and update functions 
session_start() ;
require "CRUD/connection.php";
  if (isset($_COOKIE["username"])){
    $_SESSION["name"] = $_COOKIE["username"];
  } 
  if(!isset($_SESSION["name"])){
    header("location:main.php"); 
  }
  
  $sql = "select taskname , done from tasks where username = ? order by DateAjout desc ;";
  $st = $conn->prepare($sql) ;
  $st->execute([$_SESSION["name"]]);
  $tasklist = $st->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>To Do App </title>
    <link rel="stylesheet" href="css/index.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- font awesome cdn  -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
</head>
<body>
    <div class="main">
      <div class="container-fluid sticky-top">
        <div class="container">
          <div class="navbar">
            <p>TO <span>DO</span></p>
            <a href="exit.php" onclick="confirm('are you sure to quit ?') ? window.location.href = 'exit.php': event.preventDefault()"><i class="fa-solid fa-right-from-bracket"></i></a>
          </div>
        </div>
      </div>
      <div class="container">
          
  <!-- Resultat  -->
          <div class="header mt-5 d-flex justify-content-center"> 
            <div class="result  py-5  my-3 d-flex align-items-center justify-content-evenly">
              <div class="aside ">
                <p class="fs-3 fw-semibold m-0">Todo Done </p>
                <p class="keepitup m-0">keep it up <span><?php echo $_SESSION["name"] ?></span></p>
              </div>
              <div class="aside d-flex justify-content-center ">
                  <div class="stats">
                        <p>
                          <span id="taskDone">0 </span>
                                /
                          <span id="tasksMade"><?php echo $st->rowCount() ;?></span>
                        </p>
                  </div>
              </div>
            </div>
          </div>
  <!-- Formulaire  -->
          <div class="  d-flex mt-3 justify-content-center">
            <div class="d-flex w-50  justify-content-between ">
              <input type="text" class=" form-control rounded-pill d-flex justify-content-center" placeholder="write your next task" id="task" autocomplete="off">
            
              <div class="labelDiv d-flex justify-content-center align-items-center"  id="taskadd">
                <label for="task" class="label"><button type="submit"><i class="fa-solid fa-plus"></i></button></label>
              </div>
            </div>
          </div>
    <!-- Task list -->
          <div id="taskList"  class="d-flex flex-column mt-2 align-items-center">
            <?php  
              foreach ($tasklist as $t){
                if($t["done"] == 0 ){
                  echo "<div class='taskItem'>
                        <div class='taskInfo'>
                        <label class='check' >
                          <input type='checkbox' name='checkTask' id='checkTask' >
                          <span class='custom-radio'></span>
                          <span id='taskName' for='checkTask'  class='taskName'>" . $t["taskname"] . "</span>
                        </label>
                      </div>
                      <div class='actions'> 
                        <a  class='update-link' id='update' data-task='".$t["taskname"]."' ><i class='fa-regular fa-pen-to-square'></i></a>
                        <a  class='delete-link' id='delete' data-task='".$t["taskname"]."' ><i class='fa-solid fa-trash'></i></a> 
                      </div>
                    </div>" ; 
              }
              else if ($t["done"] == 1 ){
                
              echo "<div class='taskItem'>
                      <div class='taskInfo'>
                      <label class='check' >
                        <input type='checkbox' name='checkTask' id='checkTask' checked >
                        <span class='custom-radio'></span>
                        <span id='taskName' for='checkTask'  class='taskName'>" . $t["taskname"] . "</span>
                      </label>
                      </div>
                      <div class='actions'> 
                        <a  class='update-link' id='update' data-task='".$t["taskname"]."'><i class='fa-regular fa-pen-to-square'></i></a>
                        <a class='delete-link' id='delete' data-task='".$t["taskname"]."'><i class='fa-solid fa-trash'></i></a> 
                      </div>
                    </div>" ; 
              }
            }  
            ?>  
          </div>
      </div>
    </div>
    <script src="js/script.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
</body>
</html>
