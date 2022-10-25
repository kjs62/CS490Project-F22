<?php
$requestType = $_POST['requestType'];




//For students and teachers to login
if(strcmp($requestType, 'login') == 0)
{

  $data = array(
    'ucid' => $_POST['ucid'],
    'password' => $_POST['password'],
    'requestType' => 'login'
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




//For teachers, to create questions for exams
else if(strcmp($requestType, 'createQuestion') == 0)
{
  $diff = 0;
  if($_POST['difficulty'] == 'Easy')
  {
    $diff = 0;
  }
  else if($_POST['difficulty'] == 'Medium')
  {
    $diff = 1;
  }
  else if($_POST['difficulty'] == 'Hard')
  {
    $diff = 2;
  }
  
  $data = array(
    'questionToAsk' => $_POST['question'],
    'difficulty' => $diff,
    'topic' => $_POST['topic'],
    'testA' => $_POST['testCase1'],
    'testB' => $_POST['testCase2'],
    'requestType' => 'create',
    'specifier' => 'question'
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





else if(strcmp($requestType, 'getAllQuestions') == 0)
{
  $data = array(
    'questionID' => $_POST['questionID'],
    'requestType' => 'get',
    'specifier' => 'allQuestions'
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





else if(strcmp($requestType, 'getQuestions') == 0)
{
  $data = array(
    'questionID' => $_POST['questionID'],
    'requestType' => 'get',
    'specifier' => 'question'
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





//For students, when taking an exam and need to view and answer question
else if(strcmp($requestType, 'getExam') == 0)
{
  $data = array(
    'examID' => $_POST['examID'],
    'requestType' => 'get',
    'specifier' => 'exam'
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





//For teachers, to create an exam with selected questions
else if(strcmp($requestType, 'createExam') == 0)
{
  $data = array(
    'questionID' => $_POST['questionID'],
    'questionPoint' => $_POST['questionPoint'],
    'examID' => $_POST['examID'],
    'requestType' => 'create',
    'specifier' => 'exam',
    'examName' => $_POST['examName']
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
    'requestType' => 'get',
    'specifier' => 'allExams'
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
            "studentID" => (int)$_POST["studentID"],
            "examID" => (int)$_POST["examID"],
            "attemptID" => 1,
            "questionID" => (int)$_POST["questionID"],
            "questionAnswer" => $_POST["questionAnswer"],
            "specifier" => 'examAttempt',
            "requestType" => 'create'
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



//For both, to get all Exam attempts
else if(strcmp($requestType, 'getExams') == 0)
{
  $data = array(
    'requestType' => 'get',
    'specifier' => 'allExamAttempts'
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




//For both, to get all Exam attempts
else if(strcmp($requestType, 'allExamAttempts') == 0)
{
  $data = array(
    'requestType' => 'get',
    'specifier' => 'allExamAttempts'
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



//For teacher/grader, to get Exam attempts for a specific student and exam
else if(strcmp($requestType, 'getExamAttempt') == 0)
{
  $data = array(
    'requestType' => 'get',
    'specifier' => 'examAttempt',
    'studentID' => $_POST['studentID'],
    'examID' => $_POST['examID'],
    'attemptID' => 1
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
    $examID = $_POST['examID'];
    $studentID = $_POST['studentID'];
  
    $data = array(
      'requestType' => 'getExam',
      'examID' => $examID
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~kjs62/CS490Project-F22/beta/middleEnd/receiveRequest.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $server_output = curl_exec($ch);
    curl_close($ch);
    
    $recieved_array = json_decode($server_output,true);
    
    $AllExamQuestions = $recieved_array['examIDRows'];
    
    //Lists all Question Ids in order
    $IndividualExamIDs = array();
    //Lists maximum points per question in order
    $MaxGradePerQuestion = array();
    
    //Actual Question (including name of function!!)
    $actualQuestionString = array();
    //Lists testCase1
    $testCase1Arr = array();
    //Lists testCase2
    $testCase2Arr = array();
    
    for($i = 0; $i < count($AllExamQuestions); $i++)
    {
      array_push($IndividualExamIDs, $AllExamQuestions[$i][1]);
      array_push($MaxGradePerQuestion, $AllExamQuestions[$i][2]);
      
      $data = array(
        'requestType' => 'getQuestions',
        'questionID' => $IndividualExamIDs[$i]
      );
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~kjs62/CS490Project-F22/beta/middleEnd/receiveRequest.php");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $server_output = curl_exec($ch);
      curl_close($ch);
      
      $recieved_array = json_decode($server_output,true);
      
      $questionInfo = $recieved_array['questionRow'];
      
      array_push($actualQuestionString, $questionInfo[1]);
      array_push($testCase1Arr, $questionInfo[4]);
      array_push($testCase2Arr, $questionInfo[5]);
      
    }    
    
    $data = array(
      'requestType' => 'allExamAttempts'
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~kjs62/CS490Project-F22/beta/middleEnd/receiveRequest.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $server_output = curl_exec($ch);
    curl_close($ch);
    
    $recieved_array = json_decode($server_output,true);
    
    $examAttempts = $recieved_array['examAttemptRows'];
    
    $questionAnswers = array();
    
    for($i = 0; $i < count($examAttempts); $i++)
    {
      if($examAttempts[$i][0] == $studentID)
      {
        if($examAttempts[$i][1] == $examID)
        {
          array_push($questionAnswers, $examAttempts[$i][4]);
        }
      }
    }
    
    
    //ACTUAL GRADING ASPECT
    $sender = array();
    $testFile = 'examGrade.py';
    for($i = 0; $i < count($questionAnswers); $i++)
    {
      $currentPoints = $MaxGradePerQuestion[$i];
      $functionName = explode(" ", ltrim($actualQuestionString[$i]))[4];
      
      $brokenDownAnswer = explode(" ", $questionAnswers[$i]);
      $userTypedFunctionName = explode("(", $brokenDownAnswer[1]);
      
      $data = array(
        'requestType' => 'update',
        'specifier' => 'examAttempt',
        'studentID' => $studentID,
        'examID' => $examID,
        'questionID' => $IndividualExamIDs[$i],
        'attemptNum' => 1,
        'updateColumn' => 'FunctionNamePoints',
        'updateValue' => 5
      );
      
      if($userTypedFunctionName[0] != $functionName)
      {
        $currentPoints = $currentPoints - 5;
        $questionAnswers[$i] = str_replace($userTypedFunctionName[0], $functionName, $questionAnswers[$i]);
        $data = array(
        'requestType' => 'update',
        'specifier' => 'examAttempt',
        'studentID' => $studentID,
        'examID' => $examID,
        'questionID' => $IndividualExamIDs[$i],
        'attemptNum' => 1,
        'updateColumn' => 'FunctionNamePoints',
        'updateValue' => 0
      );
      }
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $server_output = curl_exec($ch);
      curl_close($ch);
      
      $testCase1Call = explode(" should", $testCase1Arr[$i])[0];
      file_put_contents($testFile, $questionAnswers[$i] . "\nprint($testCase1Call)");
      
      $output=null;
      $retval=null;
      
      exec('python examGrade.py', $output, $retval);
      $testCase1Answer = explode("return ", $testCase1Arr[$i])[1];
      
      $data = array(
        'requestType' => 'update',
        'specifier' => 'examAttempt',
        'studentID' => $studentID,
        'examID' => $examID,
        'questionID' => $IndividualExamIDs[$i],
        'attemptNum' => 1,
        'updateColumn' => 'TestPointsA',
        'updateValue' => ($MaxGradePerQuestion[$i]-5)/2
      );
      
      if($output[0] != $testCase1Answer)
      {
        $currentPoints -= ($MaxGradePerQuestion[$i]-5)/2;
        $data = array(
          'requestType' => 'update',
          'specifier' => 'examAttempt',
          'studentID' => $studentID,
          'examID' => $examID,
          'questionID' => $IndividualExamIDs[$i],
          'attemptNum' => 1,
          'updateColumn' => 'TestPointsA',
          'updateValue' => 0
        );
      }

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $server_output = curl_exec($ch);
      curl_close($ch);
      
      $testCase2Call = explode(" should", $testCase2Arr[$i])[0];
      file_put_contents($testFile, $questionAnswers[$i] . "\nprint($testCase2Call)");
      $output=null;
      $retval=null;
      
      exec('python examGrade.py', $output, $retval);
      $testCase2Answer = explode("return ", $testCase2Arr[$i])[1];
      
      $data = array(
        'requestType' => 'update',
        'specifier' => 'examAttempt',
        'studentID' => $studentID,
        'examID' => $examID,
        'questionID' => $IndividualExamIDs[$i],
        'attemptNum' => '1',
        'updateColumn' => 'TestPointsB',
        'updateValue' => ($MaxGradePerQuestion[$i]-5)/2
      );
      
      if($output[0] != $testCase2Answer)
      {
        $currentPoints -= ($MaxGradePerQuestion[$i]-5)/2;
        $data = array(
          'requestType' => 'update',
          'specifier' => 'examAttempt',
          'studentID' => $studentID,
          'examID' => $examID,
          'questionID' => $IndividualExamIDs[$i],
          'attemptNum' => 1,
          'updateColumn' => 'TestPointsB',
          'updateValue' => 0
        );
      }

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $server_output = curl_exec($ch);
      curl_close($ch);

      $data = array(
        'requestType' => 'update',
        'specifier' => 'examAttempt',
        'studentID' => $studentID,
        'examID' => $examID,
        'questionID' => $IndividualExamIDs[$i],
        'attemptNum' => '1',
        'updateColumn' => 'AutogradePoints',
        'updateValue' => $currentPoints
      );
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $server_output = curl_exec($ch);
      curl_close($ch);
      array_push($sender, $data);
    }
}
?>