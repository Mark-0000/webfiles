<?php
error_reporting(0);
$server="localhost";
$username="root";
$password="";
$dbname="nodemcuattendance";
$con=mysqli_connect($server,$username,$password,$dbname) or die(header('X-PHP-Response-Code: 503', true, 503));
