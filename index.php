<?php
error_reporting(0);
include_once 'dbh.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="./img/logo.svg">
</head>

<body>
    <form class="box" action="" method="POST">
        <h1>Login</h1>
        <input name="user" type="text" placeholder="Username" id="user" onfocus="set()">
        <input name="pass" type="password" placeholder="Password" id="pass" onfocus="set()">
        <span id="err">&nbsp</span>
        <input type="submit" value="SIGN IN">
    </form>

    <?php
    session_start();
    if (isset($_POST["user"], $_POST["pass"])) {
        $id = $_POST["user"];
        $passwd = $_POST["pass"];
        $sql = "SELECT * FROM student WHERE studentID=? AND passwd=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("is", $id, $passwd);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        

        if ($row > 0) {
            $_SESSION["isLoggedIn"] = true;
            $_SESSION["myid"] = $row["studentID"];
            $_SESSION["myfname"] = $row["firstname"];
            $_SESSION["mylname"] = $row["lastname"];
            $_SESSION["myrfid"] = $row["rfid"];
            header('Location: home.php');
            //echo 'found: ' . $row["studentID"] . '-' . $row["firstname"] . '-' . $row["lastname"];
        }else{
            echo "<script>";
            echo "document.getElementById('err').innerHTML = 'Login Failed!';";
            echo "</script>";
        }
        /*
        $user = $_POST["user"];
        $pass = $_POST["pass"];
        if ($user == "admin" && $pass == "admin") {
            $_SESSION["valid"] = true;
        } else {
            echo "<script>";
            echo "document.getElementById('err').innerHTML = 'Login Failed!';";
            echo "</script>";
        }*/
    }
    ?>
    <script>
        function set() {
            document.getElementById('err').innerHTML = '&nbsp';
        }
    </script>
</body>

</html>