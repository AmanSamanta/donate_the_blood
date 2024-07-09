<?php

// $connection =mysqli_connect("localhost", "root", "","donatetheblood");

$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password is set for root
$database = "donatetheblood";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";



//start

// Assume these arrays are from POST data
$name = isset($_POST['name']) ? $_POST['name'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$city = isset($_POST['city']) ? $_POST['city'] : '';
$contact = isset($_POST['contact']) ? $_POST['contact'] : '';
$savelifedata = isset($_POST['savelifedata']) ? $_POST['savelifedata'] : '';

// Make sure $date is initialized
$date = date("Y-m-d");


?>