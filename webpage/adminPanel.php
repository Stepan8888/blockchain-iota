<!DOCTYPE html>

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

    require "functions/connect.php";

    function changeUsername($conn, $user) {
        $currentUser = $_SESSION('username');
        $user = htmlentities($_POST['username']);
        $sql = "UPDATE users SET user_name = ? WHERE user_name = ?";
        if(mysqli_query($conn, $sql)){
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $user, $currentUser);
            $stmt->execute();
        }
        $conn->close();
    }

    function changePassword($conn, $user, $pass) {
        $user = $_SESSION('username');
        $pass = htmlentities($_POST['password']);
        $sql = "UPDATE users SET password = ? WHERE user_name = ?";
        if(mysqli_query($conn, $sql)){
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $pass, $user);
            $stmt->execute();
        }
        $conn->close();
    }
    ?>
</head>
<body>
<header>
    <h3>WELCOME TO THE ADMIN PANEL!</h3>
    <button class="btn btn-primary" id="logout" onclick="goToPage('functions/logout.php')" name>Logout &nbsp;<i class="fas fa-sign-out-alt"></i></button>

</header>
<div id="sensors">
<?php
    $sql = "SELECT id, lora_key, wallet_address, twitch FROM sensors";

    if($result = mysqli_query($conn, $sql)){
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            ?>
            <div class="card">
            <i class="fas fa-edit" onclick="show('block')"></i> <i class="fas fa-trash" onclick="goToPage('functions/delete.php?id=<?php echo $row['id']?>')"></i>
            <div class="card-body">
            <?php
            echo '<h5 class="card-title">Sensor name ' . $row["id"] . '</h5>';
            echo '<p class="card-text">Lora key: ' . $row["lora_key"] . '</p>';
            echo '<p class="card-text">Wallet: ' . $row["wallet_address"] . '</p>';
            echo '<p class="card-text">YouTube stream URL: ' . $row["twitch"] . '</p>';
            ?>
            </div>
            </div>
            <div id="popUp">
                <i class="fa fa-window-close" aria-hidden="true" onclick="show('none')"></i>
                <form method="post" action="functions/update.php?id=<?php echo $row["id"]?>">
                    <h2>Update Sensor</h2>
                    <div class="form-group" id="popUp-formBlock">
                        <label>Lora key:</label>
                        <input type="text" class="form-control" placeholder="KEY" name="updateKey">
                    </div>
                    <div class="form-group">
                        <label>Wallet:</label>
                        <input type="text" class="form-control" placeholder="FireFly wallet address" name="updateAddress">
                    </div>
                    <div class="form-group">
                        <label>YouTube stream URL:</label>
                        <input type="text" class="form-control" placeholder="https://www.youtube.com/embed/u3ninsiw5f4" name="updateTwitch">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <?php
            }
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


<div id="popUpAddSensor">
    <i class="fa fa-window-close" aria-hidden="true" onclick="showAddSensor('none')"></i>
    <h2>Add Sensor</h2>
        <form>
        <div class="form-group" id="popUp-formBlock">
            <label>Sensor name:</label>
            <input type="text" class="form-control" placeholder="Sensor name" name="sensorName">
        </div>
        <div class="form-group" id="popUp-formBlock">
            <label>Lora key:</label>
            <input type="text" class="form-control" placeholder="KEY" name="loraKey">
        </div>
        <div class="form-group">
            <label>Wallet:</label>
            <input type="text" class="form-control" placeholder="FireFly wallet address" name="walletAddress">
        </div>
        <div class="form-group">
            <label>YouTube stream URL:</label>
            <input type="text" class="form-control" placeholder="https://www.youtube.com/embed/u3ninsiw5f4" name="twitchStream">
        </div>
        <button type="submit" class="btn btn-primary" name="addSensor">Submit</button>
    </form>
</div>
</body>
</html>