<?php 
// hide the delete link (convert to a js method)
// problem : remove the update input in case of not pressing enter 
// problem : data doesn't get trimmed when sending
// add done == true if checked
session_start() ;
  if (isset($_COOKIE["username"])){
    $_SESSION["name"] = $_COOKIE["username"];
  } 
  if(!isset($_SESSION["name"])){
    header("location:main.php"); 
  }
  
  require "CRUD/connection.php";
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
<body onload="check()">
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
            <div class="result w-50 py-5 mx-auto my-3 d-flex align-items-center justify-content-evenly">
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
          <div class="form d-flex mt-3 justify-content-center">
            <form id="taskadd"  action="CRUD/ajouter.php" method="post" class="d-flex w-50  justify-content-between ">
              <input type="text" class=" form-control rounded-pill d-flex justify-content-center" placeholder="write your next task" name="task" id="task" autocomplete="off">
            
              <div class="labelDiv  d-flex justify-content-center align-items-center">
                <label for="task" class="label"><button type="submit" value="submit" name="submit"  ><i class="fa-solid fa-plus"></i></button></label>
              </div>
            </form>
          </div>
    <!-- Task list -->
          <div id="taskList"  class="d-flex flex-column mt-2 align-items-center">
            
            <?php
              
            foreach ($tasklist as $t){
              if($t["done"] == 0 ){
                echo "<div class='taskItem'>
                        <div class='taskInfo'>
                        <label class='check' >
                          <input type='checkbox' name='checkTask' id='checkTask' onclick='Done(this)'>
                          <span class='custom-radio'></span>
                          <span id='taskName' for='checkTask'  class='taskName'>" . $t["taskname"] . "</span>
                        </label>
                      </div>
                      <div class='actions'> 
                        <a  class='update-link' id='update'  onclick='fct(this,event)'><i class='fa-regular fa-pen-to-square'></i></a>
                        <a href='CRUD/delete.php?name=". urlencode($t["taskname"]) ."' class='delete-link' id='delete' onclick='Del(this , event)'><i class='fa-solid fa-trash'></i></a> 
                      </div>
                    </div>" ; 
              }
              else if ($t["done"] == 1 ){
                
              echo "<div class='taskItem'>
                      <div class='taskInfo'>
                      <label class='check' >
                        <input type='checkbox' name='checkTask' id='checkTask' checked='true' onclick='Done(this)'>
                        <span class='custom-radio'></span>
                        <span id='taskName' for='checkTask'  class='taskName'>" . $t["taskname"] . "</span>
                      </label>
                      </div>
                      <div class='actions'> 
                        <a  class='update-link' id='update'  onclick='fct(this,event)'><i class='fa-regular fa-pen-to-square'></i></a>
                        <a href='CRUD/delete.php?name=". urlencode($t["taskname"]) ."' class='delete-link' id='delete' onclick='Del(this , event)'><i class='fa-solid fa-trash'></i></a> 
                      </div>
                    </div>" ; 
              }
            }
            
            ?>
          
            
            
          </div>
      </div>
    </div>
    
    
    <script>
      function check(){ 
        // to check the tasks that're done who's coming from the database 
        let inputs = document.getElementsByTagName("input"); 
        
        for(let i = 1 ; i < inputs.length ; i++){   
          let   name = inputs[i].nextElementSibling.nextElementSibling;
          if (inputs[i].checked) {
              name.style.textDecoration = "line-through";
              tasksDone++;
              document.getElementById("taskDone").textContent = tasksDone;
            } 
          }
      }
     
      function fct(atag, event) {
        event.preventDefault();
        let actions = atag.closest(".actions");
        let taskItem = actions.closest(".taskItem");
        let taskInfo = taskItem.querySelector(".taskInfo");
        let p = taskItem.querySelector("#taskName");

        let input = document.createElement("input");
        input.setAttribute("type", "text");

        input.setAttribute("id", "updatedtext");
        input.setAttribute("value", p.textContent);

        p.style.display = "none";
        setTimeout(() => {
          taskInfo.appendChild(input);
          input.focus();
        }, 200);

        actions.querySelector("#update").style.visibility = "hidden";
        actions.querySelector("#update").style.transition = "all 0.15s";
        let oldValue = input.value;

        input.onkeyup = (event) => {
            let taskInfo = input.parentElement.parentElement;

            // reaching the label for the task
            let text = input.parentElement.querySelector(".taskName");

            if (event.key == "Enter") {
                let newValue = input.value;

                text.textContent = newValue;

                text.style.display = "block";
                input.parentElement.removeChild(input);
                taskInfo.querySelector(".actions").querySelector("#update").style.visibility = "visible";
                sendChanges(oldValue, newValue);
            } 
        };
      }
      function sendChanges(oldVal, newVal) {
          $.ajax({
            url: "CRUD/update.php",
            method: "post",
            data: {
              oldname: oldVal,
              newname: newVal,
            }})
            
            .done((response) => {
                console.log("data sent !");
                console.log(response ? "executed": "not executed ");
              });
      }
      // to  import jquery inside js file you should install it as a module using npm 
      
      let tasksDone = 0;

      function Done(checkbox) {
        const elementParent = checkbox.closest(".taskInfo");
        const name = elementParent.querySelector("#taskName");
        if (checkbox.checked) {
          name.style.textDecoration = "line-through";
          tasksDone++;
          document.getElementById("taskDone").textContent = tasksDone;
        } 
        else {
          if (tasksDone !== 0) {
            name.style.textDecoration = "none";
            tasksDone--;
            document.getElementById("taskDone").textContent = tasksDone;
          } 
          else {
            name.style.textDecoration = "none";
            document.getElementById("taskDone").textContent = tasksDone;
          }
        }
        setTrue(name , checkbox);
      }
      function setTrue(taskname , checkbox){
        let task  = taskname.textContent; 
        $.ajax({
            url: "CRUD/CheckTasks.php",
            method : "post",
            data : {
              taskname : task ,
              checkbox_checked  : checkbox.checked ? "yes" : "no"
            }
        })
        .done((response)=>{
          console.log("done");
          console.log(response);
        })
        
      }

    </script>
    <script src="js/script.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
</body>
</html>
