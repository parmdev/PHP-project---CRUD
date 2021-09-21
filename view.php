<?php 
session_start();
require_once "pdo.php";

	if ( ! isset($_SESSION['name']) ) {
  			die('Not logged in');
		}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php require_once "bootstrap.php";?>
    <title>Pedro Pablo Aruata Mamani</title>
</head>
<body>
<div class="container">
<h1>Tracking Autos for 
	<?php
	if ( isset($_SESSION['name']) ) {
    echo htmlentities($_SESSION['name']);
	}?></h1>

<?php 
if ( isset($_SESSION['success']) ) {
  echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
  unset($_SESSION['success']);
}
?>

<h2>Automobiles</h2>

<?php
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<ul>\n";
foreach ( $rows as $row ) {
    echo "<li>";
    echo htmlentities($row['year'])." ".htmlentities($row['make'])." / ".htmlentities($row['mileage']);
    echo "</li>";
          }
echo "</ul>\n";
?>

<a href="add.php">Add New</a> | <a href="logout.php">Logout</a> 

</div>
</body>
</html>

