<?php
//  phpinfo();
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$username = "root";
$passwd = "X34G8gjNabFkcq";
// $hostName = "vmi566217.contaboserver.net";
$hostName = "localhost";
$dbName = "food";

$conn = mysqli_connect($hostName, $username, $passwd, $dbName);

if (!$conn) {
    // echo "cosfsafs";
    echo mysqli_connect_error();
    echo "connection not working";
} else {
    $sql = "SELECT * FROM fruits";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"] . " " . $row["name"] . "<br>";
        }
    } else {
        echo "0 results";
    }
}
