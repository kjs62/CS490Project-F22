<?php require_once("nav.php");?>
<?php session_start(); ?>
<h1>Take Exams</h1>
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
    
    if($examAttempts != NULL)
    {
      for($i = 0; $i < count($examAttempts); $i++)
      {
        if($examAttempts[$i][0] == $_SESSION['user'])
        {
            if(!in_array($examAttempts[$i][1], $TakenExamID))
            {
                array_push($TakenExamID, $examAttempts[$i][1]);
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
    
    $examID = array();
    $examInfo = array();
    
    for($i = 0; $i < count($examQuestions); $i++)
    {
      if(!in_array($examQuestions[$i][0], $examID))
      {
        if(!in_array($examQuestions[$i][0], $TakenExamID))
        {
          array_push($examID, $examQuestions[$i][0]);
          array_push($examInfo, $examQuestions[$i]);
        }
      }
    }
?> 

<?php if (count($examID) > 0): ?>
        <div class="list-group">
          <?php $count = 0; ?>
            <form method="get" action="studentTakeExam.php">
              <?php for ($i = 0; $i < count($examID); $i+=1): ?>
                
                <label>
                <?php if($examInfo[$i][3] == NULL): ?>Exam Number <?php echo($examID[$i]); ?><?php else: ?><?php echo($examInfo[$i][3]); ?><?php endif; ?>
                </label>
                
                <button type="submit" name="examId" value=<?php echo($examID[$i]); ?> >
                Take Exam
                </button>
                <br>
                
              <?php endfor; ?>
            </form>
        </div>
<?php else: ?>
<p>No results</p>
<?php endif; ?>