<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nodemcuattendance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$rfid = $_GET['RFID'];
$sql = "INSERT INTO room811 (id, rfid, time, date, status) VALUES (NULL,'$rfid', CURRENT_TIME(), CURRENT_DATE(), 'enter')";
if ($conn->query($sql) === TRUE) {
  echo "1 Row inserted succesfully.";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
