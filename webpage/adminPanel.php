﻿<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
            integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css"
          integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel="stylesheet" href="css/panel_style.css">
    <script src=script.js></script>
    <script src=../backEnd/nodeFiles/connection.js></script>
    <title>Admin Panel</title>
    <?php

    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "X34G8gjNabFkcq";
    $dbname = "iotamp_db";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }

    function deleteFromDb($key) {
        $key = htmlentities($_GET['lora_key']);
        $query = "DELETE FROM sensors WHERE lora_key = ?";
        $stmt->bind_param('s', $key);
        $stmt->execute();
        $stmt->close();
    }

    function createSensor($conn, $sensorName, $loraKey, $walletAddress, $twitchStream) {
            $loraKey = htmlentities($_POST['lora_key']);
            $walletAddress = htmlentities($_POST['walletAddress']);
            $twitchStream = htmlentities($_POST['twitchStream']);
            $sensorName = htmlentities($_POST['sensorName']);
            $sql = "INSERT INTO sensors (sensor_name, lora_key, wallet_address, twitch) VALUES (?, ?, ?, ?)";
            $stmt->bind_param('ssss',$sensorName, $loraKey, $walletAddress, $twitchStream);
            $stmt->execute();
            $stmt->close();
        }

        function changeUsername($conn, $user) {
            $currentUser = $_SESSION('username');
            $user = htmlentities($_POST['username']);
            $sql = "UPDATE users SET user_name = ? WHERE user_name = ?";
            $stmt->bind_param('ss', $user, $currentUser);
            $stmt->execute();
            $stmt->close();
        }

        function changePassword($conn, $user, $pass) {
            $user = $_SESSION('username');
            $pass = htmlentities($_POST['password']);
            $sql = "UPDATE users SET password = ? WHERE user_name = ?";
            $stmt->bind_param('ss', $pass, $user);
            $stmt->execute();
            $stmt->close();
        }
    ?>
</head>
<body>
<header>
    <h3>WELCOME TO THE ADMIN PANEL!</h3>
    <button class="btn btn-primary" id="logout" onclick="goToPage('logout.php')" name>Logout &nbsp;<i class="fas fa-sign-out-alt"></i></button>

</header>
<div id="sensors">
<?php
    $sql = "SELECT id, lora_key, wallet_address FROM sensors";
    $result = $conn -> query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        ?>
        <div class="card">
        <i class="fas fa-edit" onclick="show('block')"></i> <i class="fas fa-trash" onclick="deleteConfirm()"></i>
        <div class="card-body">
        <?php
        echo '<h5 class="card-title">Sensor name ' . $row["id"] . '</h5>';
        echo '<p class="card-text">Lora key: ' . $row["lora_key"] . '</p>';
        echo '<p class="card-text">Wallet: ' . $row["wallet_address"] . '</p>';
        ?>
        <p class="card-text">Twitch stream URL: URL</p>
        </div>
        </div>
        <?php
        }
    }
    $conn->close();
?>


    <div class="card" id="addSensor" onclick="showAddSensor('block')">
        <i class="icon-fixed-width"></i>
        <div class="card-body">
            <p class="card-text"><i class="fas fa-plus"></i></p>
            <h5 class="card-title">Add sensor</h5>
        </div>
    </div>


</div>
<hr>

<h3 id="settings"><i class="fas fa-cogs"></i> Settings:</h3>
<div id="container">
<form>
    <div class="mb-3">
        <label class="form-label">Change Conversion:</label>
        <input type="text" name="conversion" class="form-control" placeholder="Kph/IOTA">
        <input type="submit" name="conversion" class="btn btn-primary" value="Submit">
    </div>

</form>

<form>
    <div class="mb-3">
        <label class="form-label">Change Username:</label>
        <input type="text" name="conversion" class="form-control" placeholder="Username">
        <input type="submit" name="conversion" class="btn btn-primary" value="Submit">
    </div>
</form>

<form>
    <div class="mb-3">
        <label class="form-label">Change Password:</label>
        <input type="password" name="conversion" class="form-control" placeholder="Password">
        <input type="submit" name="conversion" class="btn btn-primary" value="Submit">
    </div>
</form>
</div>

<div class="gray" id="gray" onclick="show('none')"></div>
<div class="gray" id="grayAddSensor" onclick="showAddSensor('none')"></div>
<div id="popUp">
    <i class="fa fa-window-close" aria-hidden="true" onclick="show('none')"></i>
    <h2>Sensor name1</h2>
        <div class="form-group" id="popUp-formBlock">
            <label>Lora key:</label>
            <input type="text" class="form-control" placeholder="KEY">
        </div>
        <div class="form-group">
            <label>Wallet:</label>
            <input type="text" class="form-control" placeholder="FireFly wallet address">
        </div>
        <div class="form-group">
            <label>Twitch stream URL:</label>
            <input type="text" class="form-control" placeholder="https://www.twitch.tv/example.com">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<div id="popUpAddSensor">
    <i class="fa fa-window-close" aria-hidden="true" onclick="showAddSensor('none')"></i>

    <h2>Add Sensor</h2>
        <form>
        <div class="form-group" id="popUp-formBlock">
            <label>Sensor name:</label>
            <input type="text" class="form-control" placeholder="Sensor name">
        </div>
    <form>
        <div class="form-group" id="popUp-formBlock">
            <label>Lora key:</label>
            <input type="text" class="form-control" placeholder="KEY">
        </div>
        <div class="form-group">
            <label>Wallet:</label>
            <input type="text" class="form-control" placeholder="FireFly wallet address">
        </div>
        <div class="form-group">
            <label>Twitch stream URL:</label>
            <input type="text" class="form-control" placeholder="https://www.twitch.tv/example.com">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>