<?php require_once("nav.php");?>
<h1>View Graded Exams</h1>
<head><link rel="stylesheet" href="beta.css"></head>

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
    $TakenExamInfo = array();
    
    if($examAttempts != NULL){
      for($i = 0; $i < count($examAttempts); $i++)
      {
        if($examAttempts[$i][0] == $_SESSION['user'])
        {
            if(!in_array($examAttempts[$i][1], $TakenExamID))
            {
                array_push($TakenExamID, $examAttempts[$i][1]);
                array_push($TakenExamInfo, $examAttempts[$i]);
            }
        }
      }
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
?> 

<?php if (count($TakenExamID) > 0): ?>
        <div class="list-group">
          <?php $count = 0; ?>
            <form method="get" action="studentViewGradedExam.php">
              <?php for ($i = 0; $i < count($TakenExamID); $i+=1): ?>
                
                <label>
                <?php echo($examName[$i]); ?>:
                </label>
                
                <?php if ($TakenExamInfo[$i][12] == 1): ?>
                <button type="submit" name="examId" value=<?php echo($TakenExamID[$i]); ?> >
                View Exam Score
                </button>
                <?php else: ?>
                Waiting to be Released
                <?php endif; ?>
                <br>
                
              <?php endfor; ?>
            </form>
        </div>
<?php else: ?>
<p>No results</p>
<?php endif; ?>