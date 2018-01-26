<?php
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
$error = '';

if(isset($_POST['submit'])){
    $username = $_POST['who'];
    $attempt = $_POST['pass'];
    $salted_attempt = hash('md5', $salt.$attempt);

    if(strlen($username) === 0 or strlen($attempt) === 0){
        $error = 'User name and password are required';
    }
    elseif($salted_attempt !== $stored_hash){
        $error = 'Incorrect password';
    }
    else{
        header("Location: game.php?name=".urlencode($_POST['who']));
    }
}

if(isset($_POST['cancel'])){
    header("Location: login.php");
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
    <h1>Please Log In</h1>
    <form method="post">
        <p style="color:red"><?= $error ?></p>
        <label for="who">User Name</label>
        <input type="text" name="who" id="who"><br/>
        <label for="pass">Password</label>
        <input type="text" name="pass" id="pass"><br/><br/>

        <input type="submit" name="submit" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    </div>
</body>
</html>