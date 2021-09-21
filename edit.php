 <?php
session_start();
require_once "pdo.php";
if ( ! isset($_SESSION['name']) ) {
  die('ACCESS DENIED');
}

if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;         
}


if( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']) ){


    if( strlen($_POST['make'])<1 || strlen($_POST['model'])<1 || strlen($_POST['year'])<1 || strlen($_POST['mileage'])<1 ){
        $_SESSION['error']="All field are required";
        header("Location: edit.php?auto_id=".$_POST['auto_id']);
        return;
    }

    if( !is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ){
        $_SESSION['error'] = "Mileage and year must be numeric";
        header("Location: edit.php?auto_id=".$_POST['auto_id']);
        return;
    }

                    
        $sql = "UPDATE autos SET make=:mk,
            model=:md, year=:yr, mileage=:mi
            WHERE auto_id = :auto_id";
        //echo("<pre>\n".$sql."\n</pre>\n");
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'],
        ':auto_id' => $_POST['auto_id']));

        $_SESSION['success'] = "Record updated";
        header("Location: index.php");
        return;
                    
    }
// Guardian: Make sure that user_id is present
if ( !isset($_GET['auto_id']) ) {
  $_SESSION['error'] = "Missing auto_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: index.php' ) ;
    return;
}



$ma = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$ye = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$auto_id = $row['auto_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php require_once "bootstrap.php"; ?>
    <title>Pedro Pablo Aruata Mamani</title>
</head>
<body>
<div class="container">

<?php 
// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>

<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $ma ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $mo ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $ye ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $mi ?>"></p>
<input type="hidden" name="auto_id" value="<?= $auto_id ?>">
<input type="submit" value="Save">
<input type="submit" name="cancel" value="Cancel">

</form>

</div>
</body>
</html>

