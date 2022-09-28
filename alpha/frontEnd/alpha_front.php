<?php
$error = "";
if(isset($_POST['submit'])){
    $ucid = $_POST['UCID'];
    $password = $_POST['password'];

    //$data = "requestType=login&ucid=$ucid&password=$password";

    $data = array(
      "requestType" => "login",
      "ucid" => $ucid,
      "password" => $password
    );
    
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://afsaccess4.njit.edu/~kjs62/CS490Project-F22/alpha/middleEnd/receiveRequest.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $server_output = curl_exec($ch);
    curl_close($ch);
    
    $recieved_array = json_decode($server_output,true);
    //echo $recieved_array['loginStatus'];
    //echo $recieved_array['accountType'];
    if (strcmp($recieved_array['loginStatus'],"True")==0){
        if(strcmp($recieved_array['accountType'], "Teacher") == 0){
          die(header("Location: professor.php"));
          exit;
        }
        else if(strcmp($recieved_array['accountType'], "Student") == 0){
          die(header("Location: student.php"));
          exit;
        }
    }
    else{
        $error = "Bad Credentials, Try again";
    }
}
?>  
<h1>CS490 Login</h1>
<form action method="post">  
<div>
    <label for="UCID">Username/UCID</label>
    <input type="text" name="UCID" required/>
</div>
<div>
    <label for="pw">Password</label>
    <input type="password" id="pw" name="password"/>
</div>
<input type="submit" value="Login" name="submit"/>
</form>
<?php echo $error ?>
<head>
    <link rel="stylesheet" href="alpha.css">
</head> 