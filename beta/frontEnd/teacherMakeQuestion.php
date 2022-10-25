<?php require_once("nav.php");?>
<h1>Create Questions</h1>
<?php
$error = "";
if(isset($_POST['create'])){
    $topic = $_POST['topic'];
    $difficulty = $_POST['difficulty'];
    $question = $_POST['question'];
    $testCase1 = $_POST['testCase1'];
    $testCase2 = $_POST['testCase2'];

    $data = array(
      "requestType" => "createQuestion",
      "topic" => $topic,
      "difficulty" => $difficulty,
      "question" => $question,
      "testCase1" => $testCase1,
      "testCase2" => $testCase2
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~kjs62/CS490Project-F22/beta/middleEnd/receiveRequest.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $server_output = curl_exec($ch);
    curl_close($ch);
    
    $recieved_array = json_decode($server_output,true);
    $error = $recieved_array['questionID'];
    var_dump($recieved_array);
}
?> 
<head><link rel="stylesheet" href="beta.css"></head>
<form method="post">
    <label>Topic</label>
    <br>
    <select name="topic">
      <option value="Variables">Variables</option>
      <option value="Conditionals">Conditionals</option>
      <option value="For Loops">For Loops</option>
      <option value="While Loops">While Loops</option>
      <option value="Lists">Lists</option>
    </select>
    
    <br>
    
    <label>Difficulty</label>
    <br>
    <select name="difficulty">
      <option value="Easy">Easy</option>
      <option value="Medium">Medium</option>
      <option value="Hard">Hard</option>
    </select>
    
    <br>
    
    <label>Question</label>
    <br>
    <textarea type="text" name="question" style="width: 42em;" required/></textarea>
    
    <br>
    
    <label>Test Case 1</label>
    <br>
    <textarea type="text" name="testCase1" style="width: 42em;" required/></textarea>
    
    <br>
    
    <label>Test Case 2</label>
    <br>
    <textarea type="text" name="testCase2" style="width: 42em;" required/></textarea>
    <br>
    
    <input type="submit" value="Create" name="create"/>
</form>

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

<?php echo $error ?>