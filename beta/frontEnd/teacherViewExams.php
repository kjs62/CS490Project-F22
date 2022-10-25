<?php session_start(); ?>
<?php

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
    
    $TakenExamID = array();
    $StudentId = array();
    $StudentExamInfo = array();
    
    //Get exams submitted by student 1
    if($examAttempts != NULL){
      for($i = 0; $i < count($examAttempts); $i++)
      {
        if($examAttempts[$i][0] == 1)
        {
            if(!in_array($examAttempts[$i][1], $TakenExamID))
            {
                array_push($TakenExamID, $examAttempts[$i][1]);
                array_push($StudentId, 1);
                array_push($StudentExamInfo, $examAttempts[$i]);
            }
        }
      }
    }
    
    $temp = array();
    $tempExamInfo = array();
    //Get exams submitted by student 2  
    if($examAttempts != NULL)
    {
      for($i = 0; $i < count($examAttempts); $i++)
        {
          if($examAttempts[$i][0] == 2)
          {
              if(!in_array($examAttempts[$i][1], $temp))
              {
                  array_push($temp, $examAttempts[$i][1]);
                  array_push($tempExamInfo, $examAttempts[$i]);
                  array_push($StudentId, 2);
              }
          }
        }
      }
      
      //combine results from both students
      for($i = 0; $i < count($temp); $i++)
      {
        array_push($TakenExamID, $temp[$i]);
        array_push($StudentExamInfo, $tempExamInfo[$i]);
      }
    
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

    $examName = array();
    for($i = 0; $i < count($TakenExamID); $i++)
    {
      for($j = 0; $j < count($examQuestions); $j++)
      {
        if($TakenExamID[$i] == $examQuestions[$j][0])
        {
          array_push($examName, $examQuestions[$j][3]);
          break;
        }
      }
    }
    
    if(isset($_POST["examIndex"]))
    {
    
      $data = array(
        'requestType' => 'gradeExam',
        'examID' => $TakenExamID[$_POST['examIndex']],
        'studentID' => $StudentId[$_POST['examIndex']]
      );
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~kjs62/CS490Project-F22/beta/middleEnd/receiveRequest.php");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $server_output = curl_exec($ch);
      curl_close($ch);
      
      header("Refresh:0");
    }
    
    if(isset($_POST["PublishexamIndex"]))
    {
    
      $data = array(
        'requestType' => 'getExam',
        'examID' => $TakenExamID[$_POST['PublishexamIndex']]
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
      
      for($i = 0; $i < count($AllExamQuestions); $i++)
      {
        $data = array(
          'requestType' => 'update',
          'specifier' => 'examAttempt',
          'examID' => $TakenExamID[$_POST['PublishexamIndex']],
          'studentID' => $StudentId[$_POST['PublishexamIndex']],
          'questionID' => $AllExamQuestions[$i][1],
          'attemptNum' => '1',
          'updateColumn' => 'IsPublished',
          'updateValue' => 1
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $server_output = curl_exec($ch);
        curl_close($ch);
      }
      
      header("Refresh:0");
    }
    
    if(isset($_POST["ModifyexamIndex"]))
    {
      $studentID = $StudentId[$_POST["ModifyexamIndex"]];
      $examID=$TakenExamID[$_POST["ModifyexamIndex"]];
      header("Location: teacherModifyExam.php?examID=$examID&studentID=$studentID");
    }
    
    if(isset($_POST["ViewexamIndex"]))
    {
      $studentID = $StudentId[$_POST["ViewexamIndex"]];
      $examID=$TakenExamID[$_POST["ViewexamIndex"]];
      header("Location: teacherViewStudentExam.php?examID=$examID&studentID=$studentID");
    }
?> 




<?php require_once("nav.php");?>
<h1>View Taken Exams</h1>
<head><link rel="stylesheet" href="beta.css"></head>

<?php if (count($TakenExamID) > 0): ?>
        <div class="list-group">
          <?php $count = 0; ?>
            <form method="post">
              <?php for ($i = 0; $i < count($TakenExamID); $i+=1): ?>
                
                <label>
                <?php echo($examName[$i]); ?> 
                for student <?php if($StudentId[$i] == 1): ?>
                kjs62
                <?php else: ?>
                sgs6
                <?php endif; ?>
                :
                </label>
                
                <?php if ($StudentExamInfo[$i][5] != NULL ): ?>
                <?php if ($StudentExamInfo[$i][12] == 0): ?>
                  <button type="submit" name="ModifyexamIndex" value=<?php echo($i); ?> >
                  Modify/View
                  </button>
                  <button type="submit" name="PublishexamIndex" value=<?php echo($i); ?> >
                  Publish
                  </button>
                <?php else: ?>
                  Exam has already been published and cannot be modified
                  <button type="submit" name="ViewexamIndex" value=<?php echo($i); ?> >
                  View
                  </button>
                <?php endif; ?>
                
                <?php else: ?>
                <button type="submit" name="examIndex" value=<?php echo($i); ?> >
                Autograde
                </button>
                <?php endif; ?>
                <br>
                <br>
              <?php endfor; ?>
            </form>
        </div>
<?php else: ?>
<p>No results</p>
<?php endif; ?>