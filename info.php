<?php
//  phpinfo();


$username = "root@localhost";
$passwd = "X34G8gjNabFkcq";
$hostName = "vmi566217.contaboserver.net";
$dbName = "fruits";

$conn = mysqli_connect($hostName, $username, $passwd, $dbName);

if (!$conn) {
    echo "cos";
    echo "connection not working";
}
