<?php
//  phpinfo();


$username = "root";
$passwd = "X34G8gjNabFkcq";
$hostName = "127.0.0.1";
$dbName = "contaboServer";

$conn = mysqli_connect($hostName, $username, $passwd, $dbName);

if (!$conn) {
    echo "connection not working";
}
