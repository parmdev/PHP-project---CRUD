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
        header("Location: add.php");
        return;
    }

    if( !is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ){
        $_SESSION['error'] = "Mileage and year must be numeric";
        header("Location: add.php");
        return;
    }

                    
        $sql = "INSERT INTO autos (make, model, year, mileage) VALUES (:mk, :md, :yr, :mi)";
        //echo("<pre>\n".$sql."\n</pre>\n");
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage']));

        $_SESSION['success'] = "Record added";
        header("Location: index.php");
        return;
                    
    }



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
    echo '<h1>Tracking Autos for ';

    	if ( isset($_SESSION['name']) ) {
              echo htmlentities($_SESSION['name']);
    	}

    echo '</h1>';

    if ( isset($_SESSION['error']) ) {
          echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
          unset($_SESSION['error']);
    }  
?>

<form method="post">
<p>Make: <input type="text" name="make" size="40"></p>
<p>Model: <input type="text" name="model" size="40"></p>
<p>Year: <input type="text" name="year"></p>
<p>Mileage: <input type="text" name="mileage"></p>


<p>
<input type="submit" value="Add"/>
<input type="submit" name="cancel" value="Cancel">
</p>
</form>

</div>
</body>
</html>

