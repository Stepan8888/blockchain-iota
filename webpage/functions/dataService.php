<?php
    $mysqli = new mysqli("localhost", "root", "", "iotamp_db");
    if($mysqli->connect_error) {
        exit('Could not connect');
    }

    function resultToArray($result) {
        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    $query = 'SELECT * FROM readings WHERE id IN (SELECT MAX(id) FROM readings GROUP BY sensor_id)';
    $result = $mysqli->query($query);
    $rows = resultToArray($result);
    $result->free();

    $sum = 0;
    for($i = 0; $i < count($rows); $i++){
        $sum += $rows[$i]['energy_purchases'];
    }
    echo "$sum";
    $mysqli->close();
?>