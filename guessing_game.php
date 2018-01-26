<!DOCTYPE html>
<html lang="en">
<head>
  <title>Nan Deng</title>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
</head>

<body>
<h1>Welcome to my guessing game</h1>
<p>
<?php
  if ( ! isset($_GET['guess']) ) { 
    echo("Missing guess parameter");
  } else if ( strlen($_GET['guess']) < 1 ) {
    echo("Your guess is too short");
  } else if ( ! is_numeric($_GET['guess']) ) {
    echo("Your guess is not a number");
  } else if ( $_GET['guess'] < 32 ) {
    echo("Your guess is too low");
  } else if ( $_GET['guess'] > 32 ) {
    echo("Your guess is too high");
  } else {
    echo("Congratulations - You are right");
  }
$stuff = array('course' => 'PHP-Intro',
                'topic' => 'Arrays');
?>

</p>
</body>

</html>
