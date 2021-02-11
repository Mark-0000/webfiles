<?php
include_once 'dbh.php';
error_reporting(0);
session_start();
if ($_SESSION["isLoggedIn"] != 1) {
    header("Location: index.php");
}
$_SESSION["currPage"] = "home.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home - <?php echo $_SESSION["myid"] . " " . $_SESSION["myfname"]; ?></title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="home.css">
    <link rel="icon" href="./img/logo.svg">
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="title-logo">
                <img src="./img/logo.svg" alt="logo" />
                <h4 class="title">NodeMCU Project</h4>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a class="nav-link" href="#">Home</a></li>
                    <li><a class="nav-link" href="basic.php">Basic</a></li>
                    <li><a class="nav-link" href="custom.php">Custom</a></li>
                    <?php if ($_SESSION["myid"] == 1001) {
                        echo '<li><a class="nav-link" href="reports.php">Reports</a></li>';
                    }
                    ?>
                </ul>
            </nav>
            <div class="logout">
                <a href="logout.php" class="nav-link" title="LOGOUT"><img src="./img/logout.png" alt=""></a>
            </div>
        </div>
        <hr>
        <section class="mslide">
            <div class="intro">
                <div class="intro-text">
                    <h1><?php echo $_SESSION["myfname"] . " " . $_SESSION["mylname"] . "</h1><b><h2>ID: " .  $_SESSION["myid"]; ?></h2>
                        <p>
                            RFID: <?php echo $_SESSION["myrfid"]; ?></b><br><br>
                            Search Student Attendance Records with Basic and Custom Search.
                        </p>
                </div>
                <div class="cta">
                    <a href="basic.php"><button class="cta-basic">Basic Search</button></a>
                    <a href="custom.php"><button class="cta-custom">Custom Search</button></a>
                    <?php if ($_SESSION["myid"] == 1001) {
                        echo '<a href="reports.php"><button class="cta-report">Reports</button></a>';
                    }
                    ?>
                </div>
            </div>
            <div class="cover">
                <img src="./img/img.png" alt="table image" />
            </div>
        </section>


    </div>
    <div class="footer">
        <p>© 2020 - 2021 Mark Christian Albinto</p>
    </div>
</body>

</html>