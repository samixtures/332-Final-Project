<?php
	// Connection Info
	$servername = "mariadb";
	$username = "cs332a17";
	$password = "Weax4ieR";
	$dbname = "cs332a17";
		
	// Input from User
	$SSN = $_POST['SSN'];

	// Connect to DBS
	$link = new mysqli($servername, $username, $password,$dbname);
		
	// Check Connection
	if ($link->connect_error) {
		die('Could not connect: ' . $link->connect_error);
	}
				
	// 1a Given the social security number of a professor, list the titles, classrooms,
	// meeting days and time of his/her classes. */
	$query="SELECT C.Title, S.classroom, S.meeting_days, S.start_time ,S.end_time
			FROM COURSE C, SECTION S, PROFESSOR P 
			WHERE C.Course_id = S.Course_id AND P.SSN=S.Instructor AND S.Instructor=" .$SSN . ";";
				
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
		echo	"<h3><left> Class list for Professor SSN =" . $SSN . "</left></h3>";
		echo	'<table style="width:100%">
				<tr>
				<th>Class Title</th>
				<th>Classroom</th> 
				<th>Meeting Days</th>
				<th>Start Time</th>
				<th>End Time</th>
				</tr>';
		while($row = $result->fetch_assoc()) { 
			// Add each row to the table
			echo "<tr>";
			echo "<td>" . $row["Title"] . "</td>";
			echo "<td>" . $row["classroom"] . "</td>";
			echo "<td>" . $row["meeting_days"] . "</td>";
			echo "<td>" . $row["start_time"] . "</td>";
			echo "<td>" . $row["end_time"] . "</td>";		
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
