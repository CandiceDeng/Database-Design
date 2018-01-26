<?php
session_start();
if (isset($_SESSION['name'])){
    unset($_SESSION['name']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Nan Deng - Autos Database</title>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
</head>
<body>
	<h1>Welcome to Autos Database</h1>
	<p>
	<a href="login.php">Please Log In</a>
	</p>
    <p>Attempt to go to
        <a href="view.php">view.php</a> without logging in - it should fail with an error message.</p>
    <p>Attempt to go to
        <a href="add.php">add.php</a> without logging in - it should fail with an error message.</p>
</body>
</html>