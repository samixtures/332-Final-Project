<?php
	// Connection Info
	$servername = "mariadb";
	$username = "cs332a17";
	$password = "Weax4ieR";
	$dbname = "cs332a17";
		
	// Input from User
	$sid = $_POST['sid'];
	$cid = $_POST['cid'];

	//echo var_dump($_POST);
	//echo '<br>';
	// Connect to DBS
	$link = new mysqli($servername, $username, $password,$dbname);
		
	// Check Connection
	if ($link->connect_error) {
		die('Could not connect: ' . $link->connect_error);
	}
	
	// 1b Given a course number and a section number, count how many students
	// get each distinct grade, i.e. ‘A’, ‘A-’, ‘B+’, ‘B’, ‘B-’, etc.
	$query=	 "SELECT Grade, Count(Grade) 
			 FROM ENROLL_RECORD E, SECTION S
			 WHERE E.Section_id = S.Section_id AND E.Course_id = S.Course_id  
			 AND E.Section_id=" . $sid . " AND E.Course_id=". $cid. " GROUP BY Grade;";
		
	$result = $link->query($query);
	
	// Setup HTML Table
	echo 	'<html>
			<body>
			<style> table, th, td 
			{
			   border: 1px solid black;
               border-collapse: collapse;
             }
			 </style>';
	 
	// Display query results
	if($result->num_rows > 0){
		echo	"<h3><left> Grade distribution for Course#".$cid." and Section#". $sid."</left></h3>";
		//echo	"<h3><left> Grade distribution </left></h3>";
		echo	'<table style="width:100%">
				<tr>
				<th>Grade</th>
				<th> # of Students</th> 
				</tr>';
		while($row = $result->fetch_assoc()) { 
			// Add each row to the table
			echo "<tr>";
			echo "<td>" . $row["Grade"] . "</td>";
			echo "<td>" . $row["Count(Grade)"] . "</td>";
			echo "</tr>";			
		}
		echo "</table";
	} else {
		echo "No Results";
	}
	echo '</body></html>';
			
	// Close DB connection
	$link->close();
?>
