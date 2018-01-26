<?php
require_once "pdo.php";
require_once "Utility.php";
session_start();
checkLogin();

if(isset($_POST['add'])){
    $msg = validateProfile();
    if (is_string($msg)){
        $_SESSION['error'] = $msg;
        header("Location: add.php");
        return;
    }

    $msg = validatePos();
    if (is_string($msg)){
        $_SESSION['error'] = $msg;
        header("Location: add.php");
        return;
    }

    $sql = "INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) VALUES (:uid, :fst, :lst, :em, :hl, :sum)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fst' => $_POST['first_name'],
        ':lst' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':hl' => $_POST['headline'],
        ':sum' => $_POST['summary']));
    $profile_id = $pdo->lastInsertId();
    
    $rank = 1;
    for( $i=1; $i<=9; $i++ ){
        if (!isset($_POST['year'.$i])) continue;
        if (!isset($_POST['desc'.$i])) continue;
        $year = $_POST['year'.$i];
        $desc = $_POST['desc'.$i];
        $stmt = $pdo->prepare("INSERT INTO Position (profile_id ,rank, year, description) VALUES (:pid, :rank, :year, :desc)");
        $stmt->execute(array(
            ':pid' => $profile_id,
            ':rank' => $rank,
            ':year' => $year,
            ':desc' => $desc));
        $rank++;
    }

    $_SESSION['success'] = "Profile Added";
    header("Location: index.php");
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Nan Deng's Resume Registry - Add New</title>
  <script src="js/jquery.js"></script>
  <script src="js/jquery_ui.js"></script>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
</head>

<body>
<div class="container">
    <h1>Adding Profile for UMSI</h1>
    <?php
        flashMessages();
    ?>
    <form method="post">
        <p>First Name:
            <input type="text" name="first_name"/></p>
        <p>Last Name:
            <input type="text" name="last_name"/></p>
        <p>Email:
            <input type="text" name="email"/></p>
        <p>Headline:
            <input type="text" name="headline"/></p>
        <p>Summary:
            <textarea name="summary" rows="7" cols="40"></textarea></p>
        <p>Position: <input type="button" id="addPos" name="addPos" value=" + ">
            <div id="position_fields"></div>
        </p>
        <p><input type="submit" name="add" value="Add"></p>
        <p><input type="button" value="Cancel" onclick="location.href='index.php'"></p>
    </form>
</div>
<script type="text/javascript">
countPos= 0;
$(document).ready(function(){
    window.console && console.log('Document ready called');
    $('#addPos').click(function(event){
        event.preventDefault();
        if (countPos >= 9){
            alert("Maximum of nine position entries exceeded");
            return;
        }
        countPos++;
        window.console && console.log("Adding position "+countPos);
        $('#position_fields').append(
            '<div id="position'+countPos+'">\
            <p>Year: <input type="text" name="year'+countPos+'" value="" />\
            <input type="button" value="-"\
                onclick="$(\'#position'+countPos+'\').remove();return false;"></p>\
            <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
            </div>');
    });
});
</script>
</body>
</html>