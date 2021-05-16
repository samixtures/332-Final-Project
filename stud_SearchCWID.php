<?php
	// Connection Info
	$servername = "mariadb";
	$username = "cs332a17";
	$password = "Weax4ieR";
	$dbname = "cs332a17";
		
	// Input from User
	$cwid = $_POST['cwid'];

	// Connect to DBS
	$link = new mysqli($servername, $username, $password,$dbname);
		
	// Check Connection
	if ($link->connect_error) {
		die('Could not connect: ' . $link->connect_error);
	}
				
	/* 2b Given the campus wide ID of a student, list all courses the student took and the grades. */

	$query="SELECT C.Title, E.Course_id, E.Section_id, E.Grade
			FROM STUDENT S, COURSE C, ENROLL_RECORD E
			WHERE S.CWID=E.CWID AND E.Course_id=C.Course_id AND 
			 S.CWID=" .$cwid  .";";
	
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
		echo	"<h3><left> Academic history for CWID#" . $cwid . "</left></h3>";
		echo	'<table style="width:100%">
				<tr>
				<th>Title</th>
				<th>Course ID</th> 
				<th>Section ID</th>
				<th>Grade</th>
				</tr>';
		while($row = $result->fetch_assoc()) { 
			// Add each row to the table
			echo "<tr>";
			echo "<td>" . $row["Title"] . "</td>";
			echo "<td>" . $row["Course_id"] . "</td>";
			echo "<td>" . $row["Section_id"] . "</td>";
			echo "<td>" . $row["Grade"] . "</td>";
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
