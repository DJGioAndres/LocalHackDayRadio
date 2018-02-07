
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Local Hack Day Radio</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/4-col-portfolio.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">FIU | Local Hack Day Radio</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="upload.html">Upload</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">About</a>
              <span class="sr-only">(current)</span>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
    	<?php

	$servername = "localhost";
	$username = "HackRadio";
	$password = "7895123HR";
	$dbname = "RadioDatabase";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
		
		die("Connection failed: " . $conn->connect_error);
	}

	echo "Connected successfully";


	$targetSong_dir = "songs/";
	$targetAlbum_dir = "albumCovers/";

	$songFileName = basename($_FILES['userfile']['name'][0]);
	$albumFileName = basename($_FILES['userfile']['name'][1]);

	$songFileName = str_replace(" ", "_", $songFileName);
	$albumFileName = str_replace(" ", "_", $albumFileName);

	$targetSong_file = $targetSong_dir . $songFileName;
	$targetAlbum_file = $targetAlbum_dir . $albumFileName;

	$uploadOk = 1;

	$songFileType = $_FILES['userfile']['type'][0];
	$albumFileType = $_FILES['userfile']['type'][1];

	$songFileSize = $_FILES['userfile']['size'][0];
	$albumFileSize = $_FILES['userfile']['size'][1];

	$artist = $_POST['artist'];
	$songTitle = $_POST['songTitle'];
	$genre = $_POST['genre'];

	echo "Song Filetype: " . $songFileType . "</br>";
	echo "Album Filetype: " . $albumFileType . "</br>";
	echo "Song File size: " . $songFileSize . "</br>";
	echo "Album File size: " . $albumFileSize . "</br>";

	if ($songFileType !== 'audio/mp3') {
		echo "Song file is not mp3. </br>";
		$uploadOk = 0;
	}

	if (($albumFileType !== 'image/jpeg') && ($albumFileType !== 'image/jpg') && ($albumFileType !== 'image/png')) {
		echo "Image file is not jpeg or png. </br>";
		$uploadOk = 0;
	}

	if (($songFileSize == 0) || ($albumFileSize == 0)) {
		echo "Error: One of the files are empty </br>";
		$uploadOk = 0;
	}

	if (($songFileSize > 128000000) || ($albumFileSize > 128000000)) {
		echo "Error: One of the files is too large </br>";
		$uploadOk = 0;
	}

	if (file_exists($targetSong_file)) {
	    echo "Sorry, file already exists. </br>";
	    $uploadOk = 0;	
	}

	if (file_exists($targetAlbum_file)) {
	    echo "Sorry, file already exists. </br>";
	    $uploadOk = 0;	
	}

	if ($uploadOk == 0) {
		echo "ERROR: File failed to upload </br>";
	} else {
		if ((move_uploaded_file($_FILES['userfile']['tmp_name'][0], $targetSong_file)) && (move_uploaded_file($_FILES['userfile']['tmp_name'][1], $targetAlbum_file))) {
			echo "Files were uploaded successfully! </br>";

			$sql = "INSERT INTO Songs (Artist, Title_Description, SongFile, Genre, AlbumCover)
					VALUES ('$artist', '$songTitle', '$targetSong_file', '$genre', '$targetAlbum_file')";

			if (mysqli_query($conn, $sql)) {
		
				printf("New record created successfully");
	
			} else {
		
				printf("Error recording to the database </br>");
			}

		} else {
			echo "Sorry, there was an error uploading your files.";
		}
	}

?>
    <!-- /.container -->
    <div class="form-group">
            <div>
              <a href="upload.html" style="border: 2px black;" >Ok</a>
            </div>
          </div>
    </div>
    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; FIU Local Hack Day Radio LLC 2017</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
