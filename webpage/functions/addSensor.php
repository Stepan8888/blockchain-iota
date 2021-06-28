<?php
require "connect.php";

$loraKey = htmlentities($_POST['loraKey']);
$walletAddress = htmlentities($_POST['walletAddress']);
$twitchStream = htmlentities($_POST['twitchStream']);
$sensorName = htmlentities($_POST['sensorName']);
$query = "INSERT INTO sensors (sensor_name, lora_key, wallet_address, twitch) VALUES ('$sensorName', '$loraKey', '$walletAddress', '$twitchStream')";
if(mysqli_query($conn, $query)){
    header("Location:adminPanel.php");
} else {
    echo "Error: " . $query . mysqli_error($conn);
}
?>