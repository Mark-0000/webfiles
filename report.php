<?php
session_start();
include_once 'dbh.php';
$id = $_GET["id"];
$sid = $_GET["sid"];
$sql = "INSERT INTO reports (uid, recordid) VALUES (?,?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $sid, $id);
$stmt->execute();
$con->close();
$currentPage = $_SESSION["currPage"];
header("Location: $currentPage");
?>