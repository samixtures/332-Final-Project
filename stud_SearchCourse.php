<?php
	// Connection Info
	$servername = "mariadb";
	$username = "cs332a17";
	$password = "Weax4ieR";
	$dbname = "cs332a17";
		
	// Input from User
	$cid = $_POST['cid'];

	// Connect to DBS
	$link = new mysqli($servername, $username, $password,$dbname);
		
	// Check Connection
	if ($link->connect_error) {
		die('Could not connect: ' . $link->connect_error);
	}
				
	// 1a Given the social security number of a professor, list the titles, classrooms,
	// meeting days and time of his/her classes. */
	
	$query="SELECT S.Section_id, classroom, meeting_days, start_time, end_time, Count(E.CWID)
			FROM COURSE C, ENROLL_RECORD E, SECTION S
			WHERE E.Course_id = S.Course_id AND S.Course_id = C.Course_id AND
			E.Section_id = S.Section_id AND E.Course_id=" .$cid  . " GROUP BY(S.Section_id);";
	
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
		echo	"<h3><left> Sections for Course#=" . $cid . "</left></h3>";
		echo	'<table style="width:100%">
				<tr>
				<th>Section Number</th>
				<th>Classroom</th> 
				<th>Meeting Days</th>
				<th>Start Time</th>
				<th>End Time</th>
				<th>Students Enrolled</th>
				</tr>';
		while($row = $result->fetch_assoc()) { 
			// Add each row to the table
			echo "<tr>";
			echo "<td>" . $row["Section_id"] . "</td>";
			echo "<td>" . $row["classroom"] . "</td>";
			echo "<td>" . $row["meeting_days"] . "</td>";
			echo "<td>" . $row["start_time"] . "</td>";
			echo "<td>" . $row["end_time"] . "</td>";	
			echo "<td>" . $row["Count(E.CWID)"] . "</td>";
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
