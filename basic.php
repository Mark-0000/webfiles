<?php
error_reporting(0);
session_start();
if ($_SESSION["isLoggedIn"] != 1) {
    header("Location: index.php");
}
include_once 'dbh.php';
$_SESSION["currPage"] = "basic.php";
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
                    <li><a class="nav-link" href="#">Basic</a></li>
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
        <div class="main">
            <div class="formcontainer">
                <form action="" method="POST" class="formbox">
                    <span class="tframe">
                    <span class="ftext">TIMEFRAME:</span>

                    <select name="stime" id="" required>
                        <option value="">Start - End</option>
                        <option value="09:00:0011:00:00">09:00 - 11:00</option>
                        <option value="11:00:0013:00:00">11:00 - 13:00</option>
                        <option value="13:00:0015:00:00">13:00 - 15:00</option>
                        <option value="15:00:0017:00:00">15:00 - 17:00</option>
                        <option value="17:00:0019:00:00">17:00 - 19:00</option>
                        <option value="19:00:0021:00:00">19:00 - 21:00</option>

                    </select>
                    </span>
                    <span class="ftext">DATE:</span>
                    <?php

                    echo "<select name='sdatey' id='' required>";
                    echo "<option value=''>Year</option>";
                    for ($i = 2020; $i <= 2030; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                    echo "</select>";
                    ?>-
                    <select name="sdatem" id="" required>
                        <option value="">Month</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>-
                    <?php

                    echo "<select name='sdated' id='' required>";
                    echo "<option value=''>Day</option>";
                    for ($i = 1; $i <= 31; $i++) {
                        $ix = sprintf("%02d", $i);
                        echo "<option value='$ix'>$ix</option>";
                    }
                    echo "</select>";
                    ?>
                    <span class="ftext">ROOM:</span>
                    <input type="text" name="sroom" size="4" maxlength="4" value="811" required></input>

                    <input type="submit" name="submit" value="Filter"></input>
                </form>
            </div>
            <div class="content">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 15%;">Student ID</th>
                            <th style="width: 20%;">First Name</th>
                            <th style="width: 20%;">Last Name</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 15%;">Time</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 5%;"><button class="sbtn-rep">!</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7  " style="height: 15px;">
                                <hr>
                            </td>
                        </tr>
                        <?php
                        if (isset($_POST["sdatey"], $_POST["sdatem"], $_POST["sdated"])) {
                            $myid = $_SESSION["myid"];
                            $stimer = $_POST["stime"];
                            $timein = substr($stimer, 0, 8);
                            $timeout = substr($stimer, 8);
                            $sdate = $_POST["sdatey"] . "-" . $_POST["sdatem"] . "-" . $_POST["sdated"];
                            $room = "room" . $_POST["sroom"];
                            if ($myid == 1001) {
                                $sql = "SELECT s.studentID, s.firstname, s.lastname, r.id, r.date, r.time, r.status FROM student s, $room r WHERE  s.rfid = r.rfid AND time BETWEEN ? AND ? AND date=? ORDER BY studentID, time;";
                                $stmt = $con->prepare($sql);
                                $stmt->bind_param("sss", $timein, $timeout, $sdate);
                            } else {
                                $sql = "SELECT s.studentID, s.firstname, s.lastname, r.id, r.date, r.time, r.status FROM student s, $room r WHERE studentID=? AND s.rfid = r.rfid AND time BETWEEN ? AND ? AND date=? ORDER BY studentID, time;";
                                $stmt = $con->prepare($sql);
                                $stmt->bind_param("isss", $myid, $timein, $timeout, $sdate);
                            }

                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo  "<tr>";
                                    echo "<td>" . $row["studentID"] . "</td>";
                                    echo "<td>" . $row["firstname"] . "</td>";
                                    echo "<td>" . $row["lastname"] . "</td>";
                                    echo "<td>" . $row["date"] . "</td>";
                                    echo "<td>" . $row["time"] . "</td>";
                                    echo "<td>" . $row["status"] . "</td>";
                                    echo "<td>" . "<button title='REPORT' class='btn-report' onclick='onReport(" . $row["id"] ."," . $row["studentID"] . ")'>!</button>" . "</td>";
                                    echo "</tr>";
                                }
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
        function onReport(id, sid) {
            window.location.href = "report.php?id=" + id +"&sid=" + sid
        }
    </script>
</body>

</html>