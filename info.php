<?php
//  phpinfo();


$username = "root@localhost";
$passwd = "X34G8gjNabFkcq";
$hostName = "localhost:3306";
$dbName = "fruits";

$conn = mysqli_connect($hostName, $username, $passwd, $dbName);

if (!$conn) {
    echo "connection not working";
}
