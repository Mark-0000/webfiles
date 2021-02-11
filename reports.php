<?php
error_reporting(0);
session_start();
if ($_SESSION["isLoggedIn"] != 1) {
    header("Location: index.php");
}
if(($_SESSION["myid"]) != 1001){
    header("Location: home.php");
}
include_once 'dbh.php';
$_SESSION["currPage"] = "reports.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Basic - <?php echo $_SESSION["myid"] . " " . $_SESSION["myfname"]; ?></title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="basic.css">
    <link rel="stylesheet" href="table.css">
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
                    <li><a class="nav-link" href="home.php">Home</a></li>
                    <li><a class="nav-link" href="basic.php">Basic</a></li>
                    <li><a class="nav-link" href="custom.php">Custom</a></li>
                    <?php if ($_SESSION["myid"] == 1001) {
                        echo '<li><a class="nav-link" href="#">Reports</a></li>';
                    }
                    ?>
                </ul>
            </nav>
            <div class="logout">
                <a href="logout.php" class="nav-link" title="LOGOUT"><img src="./img/logout.png" alt=""></a>
            </div>
        </div>
        <hr>
        <div class="main">

            <div class="content">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 10%;">Student ID</th>
                            <th style="width: 15%;">First Name</th>
                            <th style="width: 15%;">Last Name</th>
                            <th style="width: 15%;">Record ID</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 15%;">Time</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 5%;"><button class="sbtn-chk">✓</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" style="height: 15px;">
                                <hr>
                            </td>
                        </tr>
                        <?php
                        $sql = "SELECT rp.rid, s.studentID, s.firstname, s.lastname, r.id, r.time, r.date, r.status from room811 r, student s, reports rp WHERE s.studentID = rp.uid AND r.id = rp.recordid;";
                        $stmt = $con->prepare($sql);
                        //$stmt->bind_param("isss", $myid, $timein, $timeout, $sdate);
                        $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo  "<tr title='Something!'>";
                                    echo "<td>" . $row["studentID"] . "</td>";
                                    echo "<td>" . $row["firstname"] . "</td>";
                                    echo "<td>" . $row["lastname"] . "</td>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["date"] . "</td>";
                                    echo "<td>" . $row["time"] . "</td>";
                                    echo "<td>" . $row["status"] . "</td>";
                                    echo "<td>" . "<button title='CHECKED' class='btn-check' onclick='onCheck(" . $row["rid"] . ")'>✓</button>"  . "</td>";
                                    
                                    //echo "<td><button onClick='myFunction(".$row["r.id"].")'>Report</button></td>";
                                    echo "</tr>";
                                }
                            }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>© 2020 - 2021 Mark Christian Albinto</p>
    </div>
    <script>
        function onCheck(rid) {
            window.location.href = "delete.php?rid=" + rid
        }
    </script>
</body>

</html>