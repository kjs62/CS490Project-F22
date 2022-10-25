<?php session_start(); ?>
<?php

    if(count($_GET) != 0)
    {
      $_SESSION['examId'] = $_GET["examID"];
    }
    
    
    $data = array(
      'requestType' => 'getExam',
      'examID' => $_SESSION['examId']
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~kjs62/CS490Project-F22/beta/middleEnd/receiveRequest.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $server_output = curl_exec($ch);
    curl_close($ch);
    
    $recieved_array = json_decode($server_output,true);
    
    $examQuestions = $recieved_array['examIDRows'];
    
    $QuestionPoints = array();
    $QuestionIds = array();
    
    for($i = 0; $i < sizeOf($examQuestions); $i++)
    {
      array_push($QuestionIds, $examQuestions[$i][1]);
      array_push($QuestionPoints, $examQuestions[$i][2]);
    }
    
    $examQuests = array();
    
    for($i = 0; $i < count($QuestionIds); $i++)
    {
      $data = array(
        'requestType' => 'getQuestions',
        'questionID' => $QuestionIds[$i]
      );
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~kjs62/CS490Project-F22/beta/middleEnd/receiveRequest.php");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $server_output = curl_exec($ch);
      curl_close($ch);
      
      $recieved_array = json_decode($server_output,true);
      
      array_push($examQuests, $recieved_array['questionRow']);
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
    $formatAnswerString = array();
    
    for($i = 0; $i < count($examAttempts); $i++)
    {
      if($examAttempts[$i][0] == $_GET['studentID'])
      {
        if($examAttempts[$i][1] == $_SESSION['examId'])
        {
          array_push($questionAnswers, $examAttempts[$i]);
        }
      }
    }
    
    if(isset($_POST['submitChanges']))
    {
      for($i = 0; $i < count($_POST['functionName']); $i++)
      {
          $data = array(
            'requestType' => 'update',
            'specifier' => 'examAttempt',
            'studentID' => $_GET["studentID"],
            'examID' => $_GET["examID"],
            'questionID' => $QuestionIds[$i],
            'attemptNum' => '1',
            'updateColumn' => 'Comments',
            'updateValue' => $_POST['comments'][$i]
          );
          
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
            'studentID' => $_GET["studentID"],
            'examID' => $_GET["examID"],
            'questionID' => $QuestionIds[$i],
            'attemptNum' => '1',
            'updateColumn' => 'AdjustedPointsA',
            'updateValue' => $_POST['testCase1'][$i]
          );
          
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
            'studentID' => $_GET["studentID"],
            'examID' => $_GET["examID"],
            'questionID' => $QuestionIds[$i],
            'attemptNum' => '1',
            'updateColumn' => 'AdjustedPointsB',
            'updateValue' => $_POST['testCase2'][$i]
          );
          
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
            'studentID' => $_GET["studentID"],
            'examID' => $_GET["examID"],
            'questionID' => $QuestionIds[$i],
            'attemptNum' => '1',
            'updateColumn' => 'AdjustedPointsFunction',
            'updateValue' => $_POST['functionName'][$i]
          );
          
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~sgs6/CS490Project-F22/beta/backEnd/backEndAPI.php");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          $server_output = curl_exec($ch);
          curl_close($ch);

                  $functionNamePoints = $questionAnswers[$i][6];
                  $testAPoints = $questionAnswers[$i][9];
                  $testBPoints = $questionAnswers[$i][10];
                  if($_POST['testCase1'][$i] != "")
                  {
                    $testAPoints = $_POST['testCase1'][$i];
                  }
                  
                  if($_POST['testCase2'][$i] != "")
                  {
                    $testBPoints = $_POST['testCase2'][$i];
                  }

                  
                  if($_POST['functionName'][$i] != "")
                  {
                    $functionNamePoints = $_POST['functionName'][$i];
                  }
          
          $currentScore = $functionNamePoints + $testAPoints + $testBPoints;
          
          $data = array(
            'requestType' => 'update',
            'specifier' => 'examAttempt',
            'studentID' => $_GET["studentID"],
            'examID' => $_GET["examID"],
            'questionID' => $QuestionIds[$i],
            'attemptNum' => '1',
            'updateColumn' => 'AutogradePoints',
            'updateValue' => $currentScore
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
?>

<?php require_once("nav.php");?>
<h1>Viewing/Modifying Exam Grading: <?php echo $examQuestions[0][3]; ?></h1>
<head><link rel="stylesheet" href="beta.css"></head>

<style>
table, th, td {
  border:1px solid black;
}
</style>

<?php if (count($examQuests) > 0): ?>
        <div class="list-group">
          <?php $totalScore = 0; ?>
          <?php $count = 0; ?>
            <form method="post">
              <?php for ($i = 0; $i < count($examQuests); $i+=1): ?>
                
                <?php $totalScore += $questionAnswers[$i][5]; ?>
                
                <label>
                Question <?php echo($i+1); ?>: <br>
                <?php echo($examQuests[$i][1]); ?><br>
                Point Value: <?php echo($QuestionPoints[$i]); ?>
                <br>
                </label>
                <br>
                
                <label>
                Your answer: <br>
                <?php echo str_replace("\t", "&nbsp;&nbsp;&nbsp;", nl2br($questionAnswers[$i][4])); ?><br>
                </label>
                <br>
                
                <label>
                Test Case 1: <br>
                <?php echo($examQuests[$i][4]); ?><br>
                </label>
                <br>
                
                <label>
                Test Case 2: <br>
                <?php echo($examQuests[$i][5]); ?><br>
                </label>
                <br>
        
                <table>
                  <tr>
                    <th></th>
                    <th>Points Worth</th>
                    <th>Points Received</th>
                    <th>Point Override</th>
                  </tr>
                  <tr>
                    <th>Function Name</th>
                    <td>5</td>
                    <td><?php echo($questionAnswers[$i][6]); ?></td>
                    <td>
                    <input type="text" name="functionName[]" value="<?php echo($questionAnswers[$i][13]); ?>">
                    
                    </input>
                    </td>
                  </tr>
                  <tr>
                    <th>Test Case 1</th>
                    <td><?php echo(($QuestionPoints[$i]-5)/2); ?></td>
                    <td><?php echo($questionAnswers[$i][9]); ?></td>
                    <td>
                    <input type="text" name="testCase1[]" value="<?php echo($questionAnswers[$i][7]); ?>">
                    
                    </input>
                    </td>
                  </tr>
                  <tr>
                    <th>Test Case 2</th>
                    <td><?php echo(($QuestionPoints[$i]-5)/2); ?></td>
                    <td><?php echo($questionAnswers[$i][10]); ?></td>
                    <td>
                    <input type="text" name="testCase2[]" value="<?php echo($questionAnswers[$i][8]); ?>">
                    
                    </input>
                    </td>
                  </tr>
                  <tr>
                    <th>Comments</th>
                    <td colspan="3">
                    <input type="text" name="comments[]" value="<?php echo($questionAnswers[$i][11]); ?>" >
                    
                    </input>
                    </td>
                  </tr>
                <table>
                
                <label>
                Points for this problem: <br>
                <?php echo($questionAnswers[$i][5]); ?>/<?php echo($QuestionPoints[$i]); ?>
                <br>
                </label>
                <br>
        
                <br><br>
              <?php endfor; ?>
            
          <h3>Final Score:</h3>
          <?php echo $totalScore; ?>/100
          <br><br>
          
          <button type="submit" name="submitChanges" value=<?php echo($examID[$i]); ?> >
          Make Changes
          </button>
          </form>
        </div>
<?php else: ?>
<p>Exam Does Not Exist</p>
<?php endif; ?>