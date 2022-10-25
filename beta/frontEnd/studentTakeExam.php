<?php session_start(); ?>
<?php
    if(count($_GET) != 0)
    {
      $_SESSION['examId'] = $_GET["examId"];
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
    
    if(isset($_POST['submitExam']))
    {
        for($i = 0; $i < sizeOf($examQuestions); $i++){
          $data = array(
            "studentID" => (int)$_SESSION["user"],
            "examID" => (int)$_SESSION['examId'],
            "questionID" => (int)$QuestionIds[$i],
            "attemptID" => 1,
            "questionAnswer" => $_POST['questionAnswer'][$i],
            "requestType" => "submitExam"
          );
          
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~kjs62/CS490Project-F22/beta/middleEnd/receiveRequest.php");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          $server_output = curl_exec($ch);
          curl_close($ch);

        }
        header("Location: takeExam.php");
        exit();
    }
?>
<?php require_once("nav.php");?>

<h1>Taking Your Exam: <?php echo $examQuestions[0][3]; ?></h1>
<head><link rel="stylesheet" href="beta.css"></head>

<?php if (count($examQuests) > 0): ?>
        <div class="list-group">
          <?php $count = 0; ?>
            <form method="post" action="studentTakeExam.php">
              <?php for ($i = 0; $i < count($examQuests); $i+=1): ?>
                
                <label>
                Question <?php echo($i+1); ?>: <br>
                <?php echo($examQuests[$i][1]); ?><br>
                Point Value: <?php echo($QuestionPoints[$i]); ?>
                <br>
                </label>
                
                <br>
                
                <label>
                Test Case 1: <br>
                <?php echo($examQuests[$i][4]); ?><br>
                </label>
                
                <label>
                Test Case 2: <br>
                <?php echo($examQuests[$i][5]); ?><br>
                </label>
                <br>
                
                
                <textarea id="answerText" rows="10" cols="50" name="questionAnswer[]"></textarea>
                
                <br><br>
                
              <?php endfor; ?>
              <input type="submit" name="submitExam" value="Submit Exam"/>
            </form>
        </div>
<?php else: ?>
<p>Exam Does Not Exist</p>
<?php endif; ?>

<script>

var textareas = document.getElementsByTagName('textarea');

for(var i = 0; i < textareas.length; i++){
    textareas[i].onkeydown = function(e){
        if(e.keyCode==9 || e.which==9){
            e.preventDefault();
            var s = this.selectionStart;
            this.value = this.value.substring(0,this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
            this.selectionEnd = s+1; 
        }
    }
}

</script>