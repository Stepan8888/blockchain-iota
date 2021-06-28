<?php
require "connect.php";
$id = intval($_GET['id']);
$query = "DELETE FROM sensors WHERE id = '$id'";
if(mysqli_query($conn, $query)){
header("Location: ../adminPanel.php");
}
$conn->close();
?>