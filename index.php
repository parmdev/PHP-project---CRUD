<?php
require_once "pdo.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Pedro Pablo Aruata Mamani</title>
<?php require_once "bootstrap.php"; ?>
<style type="text/css">
  td{
  	padding: 1px 15px 1px 15px;
  	text-align: center;
  }
  tr:nth-child(even) {
  	background-color: #f2f2f2;
  }
  th{
	  background-color: #131759;
	  color:white;	
	  text-align: center;
  }
  </style>

</head>
<body>
<div class="container">
<h1>Welcome to Automobiles Database</h1>

<?php

if ( ! isset($_SESSION['name']) ) {
    //echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    //unset($_SESSION['success']);
			echo '<p><a href="login.php">Please log in</a></p>';
			echo '<p>Attempt to go to <a href="view.php">view.php</a> without logging in</p>';
	

			}else{
	
		
				$stmt = $pdo->query("SELECT make, model, year, mileage, auto_id FROM autos");
				$row = $stmt->fetch(PDO::FETCH_ASSOC);

				if($row===false){
						echo "No rows found";
				}else{
					if ( isset($_SESSION['success']) ) {
			          echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
			          unset($_SESSION['success']);
    					}

					echo('<table border="1">'."\n");
					echo '<thead><tr>';
					echo '<th>Make</th>';
					echo '<th>Model</th>';
					echo '<th>Year</th>';
					echo '<th>Mileage</th>';
					echo '<th>Action</th>';
					echo '</tr></thead>';
						$stmt = $pdo->query("SELECT make, model, year, mileage, auto_id FROM autos");
						while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

						    echo "<tr><td>";
						    echo(htmlentities($row['make']));
						    echo("</td><td>");
						    echo(htmlentities($row['model']));
						    echo("</td><td>");
						    echo(htmlentities($row['year']));
						    echo("</td><td>");
						    echo(htmlentities($row['mileage']));
						    echo("</td><td>");
						    echo('<a href="edit.php?auto_id='.$row['auto_id'].'">Edit</a> /');
						    echo('<a href="delete.php?auto_id='.$row['auto_id'].'">Delete</a>');
							echo("</td></tr>\n");
						}
					echo('</table>');
				}
			echo ' <p><a href="add.php">Add New Entry</a>';
			echo '<br>';
			echo '<br>';
			echo '<a href="logout.php">Logout</a></p> ';
		}

?>
</div>
</body>
</html>
