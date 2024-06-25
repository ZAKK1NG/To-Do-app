//we will use them when user adds or deletes a task 
let tasksMade = document.querySelectorAll(".taskItem").length;
let tasksMadeText = document.querySelector("#tasksMade");
let tasksDone = 0;
let tasksDoneText = document.querySelector("#taskDone");
// adding the tasks variables to add click event later 
let taskAddInput = document.getElementById("task");
let taskAddBtn = document.getElementById("taskadd");

// adding event listeners when the content load's 
document.addEventListener("DOMContentLoaded", ()=>{
// to add the line-through styling to tasks that're done coming from the db
    let inputs = document.getElementsByTagName("input"); 
    for(let i = 1 ; i < inputs.length ; i++){   
    let   name = inputs[i].nextElementSibling.nextElementSibling;
    if (inputs[i].checked) {
        name.style.textDecoration = "line-through";
        tasksDone++;
        document.getElementById("taskDone").textContent = tasksDone;
      } 
    }
//selecting the btns to add a functionallity to them 
    let deleteLinks = document.querySelectorAll("#delete");
    let updateLinks = document.querySelectorAll("#update");
    let Checkboxes =document.querySelectorAll('#checkTask');

// adding the click event to delete the task for each delete link
    deleteLinks.forEach((link)=>{
      
      link.addEventListener("click" , ()=>{
          // getting the task name 
        let taskname = link.getAttribute("data-task");
        // traversing the dom to get the div element bcs we need it for deleting 
        let actions = link.closest(".actions");
        let parentDiv = actions.closest(".taskItem");
        // checking if the task is done so we reduce the tasksDone also 
        let Checked = parentDiv.querySelector(".taskInfo").querySelector(".check").querySelector("input").checked;
      
        $.ajax({
              method : "post",
              url : "CRUD/delete.php",
              data :{
                  task :taskname
              } ,
              success: function(response) {
                  if(response){
                    console.log("done");
                    tasksMade--;
                    tasksMadeText.textContent =tasksMade;
                    Checked ? tasksDone-- : null ;
                    tasksDoneText.textContent =tasksDone;
                    //making the fading animation
                    parentDiv.style.opacity = "0";
                    setTimeout(()=>{
                      // waiting untill the animation ends to remove the div from the tree 
                      parentDiv.remove();
                    },600);
                    
                    
                  }
                  else {
                    console.log("not done");
                  }
                },
              error: function(xhr) {
                  console.error('Error ' + xhr.status +": "+ xhr.error );
              }
          }) 
      })
    });
// update function for update icons
    updateLinks.forEach((link)=>{
        link.addEventListener("click" , ()=> {
            let actions = link.closest(".actions");
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
                    input.remove();
                    taskInfo.querySelector(".actions").querySelector("#update").style.visibility = "visible";
                    sendChanges(oldValue, newValue);
                    
                } 
            };
      })
      
      
    
    
    
  
    })
    
    Checkboxes.forEach((checkbox)=>{
      checkbox.addEventListener("click" , ()=>{
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
            tasksDoneText.textContent = tasksDone;
          } 
          else {
            name.style.textDecoration = "none";
            tasksDoneText.textContent = tasksDone;
          }
        }
        setTrue(name , checkbox);
      })
    });
});


taskAddBtn.addEventListener("click" , ()=>{
// to prevent user from adding empty tasks and whitespaces 
  if(taskAddInput.value.trim().length == 0){
    taskAddInput.value = "" ;
    alert("remplir le champ !");
  }
  else {
//selecting the div containing all the tasks "taskList"
    let mainDiv = document.querySelector("#taskList");
// selecting the first taskItem to put our new task above it 
    let firstTask = document.querySelector(".taskItem");
// creating a taskItem div for our new task 
    let divToInsert  =document.createElement("div");
    divToInsert.setAttribute("class" , "taskItem");
    divToInsert.innerHTML=`
    <div class='taskInfo'>
      <label class='check' >
        <input type='checkbox' name='checkTask' id='checkTask' >
          <span class='custom-radio'></span>
            <span id='taskName' for='checkTask'  class='taskName'>${taskAddInput.value}</span>
      </label>
    </div>
    <div class='actions'> 
        <a  class='update-link' id='update' data-task='${taskAddInput.value}' ><i class='fa-regular fa-pen-to-square'></i></a>
        <a  class='delete-link' id='delete' data-task='${taskAddInput.value}' ><i class='fa-solid fa-trash'></i></a> 
    </div>`;
//selecting the delete link of the new task to add the delete function
    let  deletebtn = divToInsert.querySelector(".actions").querySelector("#delete");
    deletebtn.addEventListener("click" , ()=>{
// getting the task name 
        let taskname = deletebtn.getAttribute("data-task");
// traversing the dom to get the div element bcs we need it for deleting 
        let actions = deletebtn.closest(".actions");
        let parentDiv = actions.closest(".taskItem");
// checking if the task is done so we reduce the tasksDone also 
        let Checked = parentDiv.querySelector(".taskInfo").querySelector(".check").querySelector("input").checked;
      
        $.ajax({
              method : "post",
              url : "CRUD/delete.php",
              data :{
                  task :taskname
              } ,
              success: function(response) {
                  if(response){
                    console.log("done");
                    tasksMade--;
                    tasksMadeText.textContent =tasksMade;
                    Checked ? tasksDone-- : null ;
                    tasksDoneText.textContent =tasksDone;
//making the fading animation
                    parentDiv.style.opacity = "0";
                    setTimeout(()=>{
// waiting untill the animation ends to remove the div from the tree 
                      parentDiv.remove();
                    },600);
                    
                    
                  }
                  else {
                    console.log("not done");
                  }
                },
              error: function(xhr) {
                  console.error('Error ' + xhr.status +": "+ xhr.error );
              }
          }) 
      })
//selecting the update link of the new task to add the update function
    let updatebtn = divToInsert.querySelector(".actions").querySelector("#update");
    updatebtn.addEventListener("click" , ()=> {
            let actions = updatebtn.closest(".actions");
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
                    input.remove();
                    taskInfo.querySelector(".actions").querySelector("#update").style.visibility = "visible";
                    sendChanges(oldValue, newValue);
                } 
            };
      })
//selecting the checkbox link of the new task to add the styling of line-through to the taskname  
    let checkbox =divToInsert.querySelector(".taskInfo").querySelector(".check").querySelector("input");
    checkbox.addEventListener("click" , ()=>{
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
            tasksDoneText.textContent = tasksDone;
          } 
          else {
            name.style.textDecoration = "none";
            tasksDoneText.textContent = tasksDone;
          }
        }
        setTrue(name , checkbox);
      });
    tasksMade++;
    tasksMadeText.textContent = tasksMade ;
    mainDiv.insertBefore(divToInsert , firstTask);
    addToDb(taskAddInput.value);
    taskAddInput.value = "" ;
  }
})
// addToDb() => to add the new task added by the user to the database
function addToDb(taskname){
  $.ajax({
      url: "CRUD/ajouter.php",
      method: "post",
      data: {
        task: taskname
      }})
      
      .done((response) => {
          console.log("data sent !");
          console.log(response ? "executed": "not executed ");
          console.log(response);
        });
}
//setTrue() => to set done=true  into the database
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
};
//sendChanges()=> to send updated task to the db to update it in the database
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
