<?php

$conn = mysqli_connect("localhost","root","","sensor_db");

if(!$conn){
    die("DB Error");
}

// Latest DHT reading
$sql = "SELECT temperature, humidity
        FROM dht_data
        ORDER BY id DESC
        LIMIT 1";

$res = mysqli_query($conn,$sql);

$data = mysqli_fetch_assoc($res);

// If no data yet
if(!$data){
    $data = [
        "temperature" => 0,
        "humidity" => 0
    ];
}

echo json_encode($data);

mysqli_close($conn);
?>
