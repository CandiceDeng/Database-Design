<?php
require_once "pdo.php";
require_once "Utility.php";
session_start();
checkLogin();

if ( isset($_SESSION['edit_error']) ) {
    echo '<p style="color:red">'.$_SESSION['edit_error']."</p>\n";
    unset($_SESSION['edit_error']);
}

if ( isset($_POST['submit'])) {
    $msg = validateProfile();
    if (is_string($msg)){
        $_SESSION['error'] = $msg;
        header("Location: edit.php?profile_id=".$_REQUEST['profile_id']);
        return;
    }

    $msg = validatePos();
    if (is_string($msg)){
        $_SESSION['error'] = $msg;
        header("Location: add.php");
        return;
    }

    $sql = "UPDATE Profile SET first_name = :fst, last_name = :lst, email = :em, headline = :hl, summary = :sum WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':fst' => $_POST['first_name'],
        ':lst' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':hl' => $_POST['headline'],
        ':sum' => $_POST['summary'],
        ':profile_id' => $_POST['profile_id']));

    $stmt = $pdo->prepare('DELETE FROM Position WHERE profile_id=:pid');
    $stmt->execute(array( ':pid' => $_REQUEST['profile_id']));

    $rank = 1;
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['year'.$i]) ) continue;
        if ( ! isset($_POST['desc'.$i]) ) continue;
        $year = $_POST['year'.$i];
        $desc = $_POST['desc'.$i];

        $stmt = $pdo->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES ( :pid, :rank, :year, :desc)');
        $stmt->execute(array(
                ':pid' => $_REQUEST['profile_id'],
                ':rank' => $rank,
                ':year' => $year,
                ':desc' => $desc)
        );
        $rank++;
    }    
    $_SESSION['success'] = 'Profile Saved';
    header("Location: index.php");
    return;
}

$positions = loadPos($pdo, $_REQUEST['profile_id']);

$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

$first = htmlentities($row['first_name']);
$last = htmlentities($row['last_name']);
$email = htmlentities(($row['email']));
$headline = htmlentities($row['headline']);
$summary = htmlentities($row['summary']);
$profile_id = $row['profile_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Nan Deng's Resume Registry - Edit Profile</title>
  <script src="js/jquery.js"></script>
  <script src="js/jquery_ui.js"></script>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta charset="UTF-8">
</head>

<body>
    <h1>Editing Profile for UMSI</h1>
    <?php
    flashMessages();
    ?>
    <form method="post">
        <input type="hidden" name="profile_id" value="<?= $profile_id ?>">
        <p>First Name:
            <input type="text" name="first_name" value="<?= $first ?>"></p>
        <p>Last Name:
            <input type="text" name="last_name" value="<?= $last ?>"></p>
        <p>Email:
            <input type="text" name="email" value="<?= $email ?>"></p>
        <p>Headline:
            <input type="text" name="headline" value="<?= $headline ?>"></p>
        <p>Summary:</p>
        <textarea name="summary" rows="7" cols="40"><?= $summary ?></textarea>

        <?php
        $countPos = 0;
        echo('<p>Position: <input type="button" id="addPos" name="addPos" value=" + ">'."\n");
        echo('<div id="position_fields">'."\n");
        if (count($positions) > 0){
            foreach ($positions as $position){
                $countPos ++;
                echo('<div class="position" id="position'.$countPos.'">');
                echo('<p>Year: <input type="text" name="year'.$countPos.'" value="'.$position['year'].'" />
                                <input type="button" value="-" onclick="$(\'#position'.$countPos.'\').remove();return false;"></p>');
                echo('<textarea name="desc'.$countPos.'" rows="8" cols="80">'."\n");
                echo(htmlentities($position['description'])."\n");
                echo("\n</textarea>\n</div>\n");
            }
        }
        echo("</div></p>\n");
        ?>

        <p>
            <input type="submit" name="submit" value="Save"/>
            <input type="button" name="submit" value="Cancel" onclick="location.href='index.php'"></p>
    </form>
    <script type="text/javascript">
        countPos= <?= $countPos ?>;
        $(document).ready(function(){
            window.console && console.log('Document ready called');
            $('#addPos').click(function(event){
                event.preventDefault();
                if (countPos >= 9){
                    alert("Maximum of seven position entries exceeded");
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