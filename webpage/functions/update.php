<?php
require "connect.php";
$key = htmlentities($_POST['updateKey']);
$address = htmlentities($_POST['updateAddress']);
$twitch = htmlentities($_POST['updateTwitch']);
$id = $_GET['id'];
$sql = "UPDATE sensors SET lora_key='$key', wallet_address='$address', twitch='$twitch' WHERE id='$id'";
if(mysqli_query($conn, $sql)) {
    header("Location: ../adminPanel.php");
} else {
    echo mysqli_error($conn);
}
?>