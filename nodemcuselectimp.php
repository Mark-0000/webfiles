<?php
$server = "localhost";
$username = "root"; //THE DEFAULT USERNAME OF THE DATABASE
$password = "";
$dbname = "nodemcuattendance";
$con = mysqli_connect($server, $username, $password, $dbname) or die("unable to connect");
$rfid = $_GET["RFID"];
$sql = "SELECT rfid from student WHERE rfid=$rfid";
$result = mysqli_query($con, $sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo  $row["rfid"];
  }
}
