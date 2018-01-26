<?php

# Logging in 
if(isset($_GET['name'])){
    $username = $_GET['name'];
}
else{
    die("Name parameter missing");
}

# Game Selection
function check($human, $computer){
    if($human == $computer){
        return "Tie";
    }
    elseif($human == $computer + 1 || $human == 0 && $computer == 2){
        return "You Win";
    }
    else{
        return "You Lose";
    }
}
$names = ["Rock", "Paper", "Scissors"];
$show = "Please select a strategy and press Play.";
if(isset($_POST['submit'])){
    $human = $_POST['human'];

    if($human == -1){
        $show = "Please select a strategy and press Play.";
    }
    elseif($human > -1 and $human < 3){
        $computer = Rand(0,2);
        $result = check($human, $computer);
        $show = "Your Play=$names[$human] Computer Play=$names[$computer] Result=$result";
    }
    else{
        $show = "";
        for($c=0;$c<3;$c++) {
            for($h=0;$h<3;$h++) {
                $r = check($h, $c);
                $show .= "Human=$names[$h] Computer=$names[$c] Result=$r\n";
            }
        }
    }
}
# Logging out
if(isset($_POST['logout'])){
    header("Location: index.php");
}

?>


<!DOCTYPE html>
<head>
  <title>Nan Deng's Login Page</title>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  <style>
  body {
  padding-top: 50px;
  }
  .starter-template {
  padding: 40px 15px;
  text-align: center;
  }
  </style>
</head>

<body>
    <div class="container">
    <h1>Rock Paper Scissors</h1>
    <p>Welcome: <?= $username?></p>

    <form method="post">
        <select name="human">
            <option value="-1">Select</option>
            <option value="0">Rock</option>
            <option value="1">Paper</option>
            <option value="2">Scissors</option>
            <option value="3">Test</option>
        </select>
        <input type="submit" name="submit" value="Play">
        <input type="submit" name="logout" value="Logout">
    </form>

    <pre><?= $show?></pre>
    </div>
</body>
</html>