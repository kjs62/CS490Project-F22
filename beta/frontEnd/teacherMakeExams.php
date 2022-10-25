<?php require_once("nav.php");?>
<h1>Create Exams</h1>
<head><link rel="stylesheet" href="beta.css"></head>

<?php

$gotQuestions = array();

    $data = array(
      'requestType' => 'getAllQuestions'
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~kjs62/CS490Project-F22/beta/middleEnd/receiveRequest.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $server_output = curl_exec($ch);
    curl_close($ch);
    
    $recieved_array = json_decode($server_output,true);
    
    if($recieved_array['questionRows'] != NULL)
    {
      for($i = 0; $i < count($recieved_array['questionRows']); $i++)
      {
        array_push($gotQuestions, $recieved_array['questionRows'][$i]);
      }
      
      for($i = 0; $i < count($recieved_array['questionRows']); $i++)
      {
        if($recieved_array['questionRows'][$i][2] == "0")
          $gotQuestions[$i][2] = "Easy";
        else if($recieved_array['questionRows'][$i][2] == "1")
          $gotQuestions[$i][2] = "Medium";
        else if($recieved_array['questionRows'][$i][2] == "2")
          $gotQuestions[$i][2] = "Hard";
      }
    }
        
    if(isset($_POST['createExam']))
    { 
      $counter = 0;
      for($i = 0; $i < count($_POST["Scores"]); $i++)
      {
        $counter += $_POST["Scores"][$i];
      }
      
      if($counter != 100)
      {
        $error = "Make sure total is equal to 100!";
      }
      else
      {
        $data = array(
          'requestType' => 'examsToBeTaken'
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~kjs62/CS490Project-F22/beta/middleEnd/receiveRequest.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $server_output = curl_exec($ch);
        curl_close($ch);
        
        $recieved_array = json_decode($server_output,true);
        
        $examQuestions = $recieved_array['examRows'];
        
        $maxID = 0;
        
        for($i = 0; $i < count($examQuestions); $i++)
        {
          if($examQuestions[$i][0] > $maxID)
          {
            $maxID = $examQuestions[$i][0];
          }
        }
        
        for($i = 0; $i < count($_POST["Scores"]); $i++)
        {
        
          $data = array(
            'requestType' => 'createExam',
            'questionID' => $_POST["Ids"][$i],
            'questionPoint' => $_POST["Scores"][$i],
            'examID' => $maxID+1,
            'examName' => $_POST['examName']
          );
          
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~kjs62/CS490Project-F22/beta/middleEnd/receiveRequest.php");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          $server_output = curl_exec($ch);
          curl_close($ch);
          
          $examName = $_POST['examName'];
          $error = "$examName Created";
          
        }
      }
    }
?> 

<h3>Question Bank</h3>

<h3><?php echo $error; ?></h3>

<div class="leftalign" id="questionBank">

</div>

<script type="text/javascript">

var passedArray = <?php echo json_encode($gotQuestions); ?>;

function addQuestion(oldElement)
{
  const addDiv = document.createElement("div");
  
  let addId = 'Added';
  addId += oldElement;
  addDiv.id = addId;
  
  addDiv.innerHTML = `Question: ${passedArray[oldElement][1]}<br>Topic: ${passedArray[oldElement][3]}<br>Difficulty: ${passedArray[oldElement][2]}<br><label>Question Point Worth</label><br>`;
  
  const addID = document.createElement("input");
  addID.type = "hidden";
  addID.value = passedArray[oldElement][0];
  addID.name = "Ids[]";
  
  const addNode = document.createElement("input");
  addNode.type = "number";
  addNode.max = 100;
  addNode.min = 1;
  addNode.name = "Scores[]";
  
  const removeDivButton = document.createElement("input");
  removeDivButton.type = "button";
  removeDivButton.value = "Remove Question";

  removeDivButton.setAttribute("onclick", `removeQuestion(${oldElement})`);
  
  addDiv.appendChild(addNode);
  addDiv.innerHTML += "<br>";
  
  addDiv.appendChild(addID);
  addDiv.innerHTML += "<br>";
  
  addDiv.appendChild(removeDivButton);
  addDiv.innerHTML += "<br><br>";
  
  document.getElementById("questionsSelected").appendChild(addDiv);
  document.getElementById(oldElement).remove();
}

function removeQuestion(oldElement)
{ 
  let id = "Added";
  id += oldElement;
  
  const questionInBank = document.getElementById(id);
  questionInBank.style.display = "block";
  
  document.getElementById(id).remove();
  repopBank(oldElement);
}



function repopBank(oldElement)
{
  const addQuest = document.createElement("div");
    addQuest.id = oldElement;
    addQuest.innerHTML = `Question: ${passedArray[oldElement][1]}<br>Topic: ${passedArray[oldElement][3]}<br>Difficulty: ${passedArray[oldElement][2]}`;
    
    const addQuestion = document.createElement("input");
    addQuestion.type = "button";
    addQuestion.id = oldElement;
    addQuestion.name = passedArray[oldElement][0];
    addQuestion.value = "Add Question";
    
    var currentItem = passedArray[oldElement][0];
    
    addQuestion.setAttribute("onclick", `addQuestion(${oldElement})`);
    
    addQuest.innerHTML += "<br>";
    
    addQuest.appendChild(addQuestion);
    addQuest.innerHTML += "<br><br>";
    
    document.getElementById("questionBank").appendChild(addQuest);
}
</script>






<script type="text/javascript">
  var passedArray = <?php echo json_encode($gotQuestions); ?>;
  
  for(var i = 0; i < passedArray.length; i++)
  {
    console.log(passedArray[i]);
    
    const addQuest = document.createElement("div");
    addQuest.id = i;
    addQuest.style.display = "block";
    addQuest.innerHTML = `Question: ${passedArray[i][1]}<br>Topic: ${passedArray[i][3]}<br>Difficulty: ${passedArray[i][2]}`;
    
    const addQuestion = document.createElement("input");
    addQuestion.type = "button";
    addQuestion.name = passedArray[i][0];
    addQuestion.value = "Add Question";
    
    addQuestion.setAttribute("onclick", `addQuestion(${i})`);
    
    addQuest.innerHTML += "<br>";
    
    addQuest.appendChild(addQuestion);
    addQuest.innerHTML += "<br><br>";
    
    document.getElementById("questionBank").appendChild(addQuest);
  }
  
</script>

<h3>Added Questions</h3>
<p>Total Score must equal 100</p>
<form method="post">
  <div class="rightalign" id="questionsSelected">
  
  </div>
  
  <label>Exam Name:</label>
  <input type="text" name="examName" required/>
  
  <input type="submit" value="Create" name="createExam"/>
</form>