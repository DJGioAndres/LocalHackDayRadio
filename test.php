<?php
	$servername = "";
	$username = "";
	$password = "";
	$dbname = "";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {

		die("Connection failed: " . $conn->connect_error);
	}
	echo "Connected successfully";

	$sql = "INSERT INTO Songs (Artist, Title_Description, SongFile)
		VALUES ('John Doe', 'Dope Song', 'dopeSong.mp3')";

	if (mysqli_query($conn, $sql)) {

		printf("New record created successfully");

	} else {

		printf("Error");
	}

	mysqli_close($conn);
?>
