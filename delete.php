<?php
include_once 'dbh.php';
$rid = $_GET["rid"];
echo $_SESSION["currPage"];
echo "Hello";
$sql = "DELETE FROM reports WHERE rid=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $rid);
$stmt->execute();
$con->close();
$currentPage = $_SESSION["currPage"];
echo $currentPage;
header("Location: reports.php");
?>