<?php
function getDB(){
    global $db;
    //this function returns an existing connection or creates a new one if needed
    //and assigns it to the $db variable
    if(!isset($db)) {
        try{
            $connection_string = "mysql:host=sql1.njit.edu;dbname=kjs62;
;charset=utf8mb4";
            $db = new PDO($connection_string, "kjs62", "PaperFlamingo44!");
        }
        catch(Exception $e){
            var_export($e);
            $db = null;
        }
    }
    return $db;
}

$db = getDB();

$requestType = $_POST['requestType'];



//For students and teachers to login
if(strcmp($requestType, 'login') == 0)
{

  $data = array(
    'ucid' => $_POST['ucid'],
    'password' => $_POST['password'],
    'requestType' => $_POST['requestType']
  );
  
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/alpha/backEnd/backEndAPI.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $server_output = curl_exec($ch);
  
  curl_close ($ch);
  
  echo $server_output;
}



//For teachers, to create questions for exams
else if(strcmp($requestType, 'createQuestion') == 0)
{
  $data = array(
    'question' => $_POST['question'],
    'difficulty' => $_POST['difficulty'],
    'topic' => $_POST['topic'],
    'testCase1' => $_POST['testCase1'],
    'testCase2' => $_POST['testCase2'],
    'requestType' => $_POST['requestType']
  );
  
  /*
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $server_output = curl_exec($ch);
  
  curl_close ($ch);
  
  echo $server_output;
  */
  echo json_encode($data);
}


//USING PERSONAL DB FOR THIS
//For teachers, when creating an exam and need to view questions to place them into exams
else if(strcmp($requestType, 'getQuestions') == 0)
{
  
  $conn = new mysqli("sql1.njit.edu", "kjs62", "PaperFlamingo44!", "kjs62");
  $sql = "SELECT id, account_number, account_type from Accounts where id < 20 order by id ASC";
  $result = $conn->query($sql);
  
  $id = array();
  $accNum = array();
  $accType = array();
  
  if ($result->num_rows > 0) {
  // output data of each row
    while($row = $result->fetch_assoc()) {
      array_push($id, $row["id"]);
      array_push($accNum, $row["account_number"]);
      array_push($accType, $row["account_type"]);
    }
  }
  $conn->close();
  
  $data = array(
    'id' => $id,
    'accNum' => $accNum,
    'accType' => $accType
  );
  
  echo json_encode($data);
  /*
  
  $data = array(
    'requestType' => $_POST['requestType']
  );
  
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $server_output = curl_exec($ch);
  
  curl_close ($ch);
  
  echo $server_output;
  */
}



//For students, when taking an exam and need to view and answer question
else if(strcmp($requestType, 'getExamQuestion') == 0)
{

/*
  $data = array(
    'requestType' => $_POST['requestType']
  );
  
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $server_output = curl_exec($ch);
  
  curl_close ($ch);
  
  echo $server_output;
  */
  $examId = $_POST['examId'];
  $conn = new mysqli("sql1.njit.edu", "kjs62", "PaperFlamingo44!", "kjs62");
  $sql = "SELECT * from Accounts where id = $examId";
  $result = $conn->query($sql);
  
  $info = array();
  
  if ($result->num_rows > 0) {
  // output data of each row
    while($row = $result->fetch_assoc()) {
      array_push($info, $row);
    }
  }
  $conn->close();
  
  $data = array(
    'info' => $info
  );
  
  echo json_encode($data);
  
}



//For teachers, to create an exam with selected questions
else if(strcmp($requestType, 'createExam') == 0)
{
  $data = array(
    'question' => $_POST['question'],
    'difficulty' => $_POST['difficulty'],
    'questionTopic' => $_POST['questionTopic'],
    'testcase1' => $_POST['testcase1'],
    'testcase2' => $_POST['testcase2'],
    'requestType' => $_POST['requestType']
  );
  
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $server_output = curl_exec($ch);
  
  curl_close ($ch);
  
  echo $server_output;
}



//For teachers, to modify autograded exams
else if(strcmp($requestType, 'teacherGradedExams') == 0)
{
  $data = array(
    'requestType' => $_POST['requestType']
  );
  
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $server_output = curl_exec($ch);
  
  curl_close ($ch);
  
  echo $server_output;
}



//For students, to show what exams they can take
else if(strcmp($requestType, 'examsToBeTaken') == 0)
{
  $data = array(
    'requestType' => $_POST['requestType']
  );
  
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $server_output = curl_exec($ch);
  
  curl_close ($ch);
  
  echo $server_output;
}



//For students, to show exam scores (if released)
else if(strcmp($requestType, 'gradedExams') == 0)
{
  $data = array(
    'requestType' => $_POST['requestType']
  );
  
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $server_output = curl_exec($ch);
  
  curl_close ($ch);
  
  echo $server_output;
}



//For students, to submit exam
else if(strcmp($requestType, 'submitExam') == 0)
{
  $data = array(
    'requestType' => $_POST['requestType']
  );
  
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $server_output = curl_exec($ch);
  
  curl_close ($ch);
  
  echo $server_output;
}



//For teachers, to publish/unpublish exams
else if(strcmp($requestType, 'publishExam') == 0)
{
  $data = array(
    'requestType' => $_POST['requestType']
  );
  
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $server_output = curl_exec($ch);
  
  curl_close ($ch);
  
  echo $server_output;
}


//For Teachers, to autograde exams
else if(strcmp($requestType, 'gradeExam') == 0)
{
/*
  $inputAnswers = $_POST['inputAnswers']; //CHANGE THIS WHEN VALUE IS KNOWN
  $maxScorePerQuestion = $_POST['maxScorePerQuestion']; //CHANGE THIS WHEN VALUE IS KNOWN
  
  $scorePerQuestion = array();
  
  
  
  //get Questions from Exam using QuestionIds
  $data = array(
      'requestType' => 'retrieveExamQuestions',
      'examId' => $_POST['examId'] //CHANGE THIS WHEN VALUE IS KNOWN
  );
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL,"https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $server_output = curl_exec($ch);
  
  curl_close ($ch);
  $questions = json_decode($server_output, true);
  //
  
  for($i = 0; $i < QUESTION_COUNT; $i++) //CHANGE THIS WHEN VALUE IS KNOWN
  {
    $answer = $inputAnswers[$i];
    $question = $questions[$i]['question'];
    $testcase1 = $questions[$i]['testcase1'];
    $testcase2 = $questions[$i]['testcase2'];
  }
  
  
*/
  //$codeExecFile =  '/afs/cad.njit.edu/u/n/p/kjs62/public_html/cs490grader.py';
  $data = array(
    'exam' => 'cheese'
  );

  echo json_encode($data);
}
?>