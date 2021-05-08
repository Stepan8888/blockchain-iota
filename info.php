<?php
//  phpinfo();
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$username = "root";
$passwd = "X34G8gjNabFkcq";
// $hostName = "vmi566217.contaboserver.net";
$hostName = "localhost";
$dbName = "fruits";

$conn = mysqli_connect($hostName, $username, $passwd, $dbName);

if (!$conn) {
    echo "cosfsafs";
    echo "connection not working";
    $sql = "SELECT * FROM fruits";
    // mysqli_query($sql);
}
