<?php
    // Prepare variables for database connection   
    $dbusername = "root";  // enter database username, I used "arduino" in step 2.2
    $dbpassword = "toor";  // enter database password, I used "arduinotest" in step 2.2
    $server = "localhost"; // IMPORTANT: if you are using XAMPP enter "localhost", but if you have an online website enter its address, ie."www.yourwebsite.com"
	$db_name = "dorm";
	$angka = $_GET['inc'];  //Linker =

	if ($_GET['inc']) {
		echo $_GET['inc'];
	}

	$angka1 = 2;
    // Connect to your database
    $conn = new mysqli($server, $dbusername, $dbpassword, $db_name);
	
	if ($conn->connect_error) {
		die("connection error");
	}
	
	echo "sukses";

    // Prepare the SQL statement
	//mysqli_query($conn, "INSERT INTO nomor(antrian) VALUES ($angka)");
	mysqli_query($conn, "UPDATE antrian set nomor_sekarang='".$angka1."'");
?>