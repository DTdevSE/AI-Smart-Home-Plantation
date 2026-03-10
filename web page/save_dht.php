<?php

$conn = mysqli_connect("localhost","root","","sensor_db");

if(!$conn){
    die("DB Error");
}

if(
   !isset($_GET['temp']) ||
   !isset($_GET['hum'])  ||
   !isset($_GET['ldr'])  ||
   !isset($_GET['status'])
){
    die("Missing Data");
}

$temp   = $_GET['temp'];
$hum    = $_GET['hum'];
$ldr    = $_GET['ldr'];
$status = $_GET['status'];

$sql = "INSERT INTO dht_data
        (temperature, humidity, ldr_value, light_status)
        VALUES
        ('$temp','$hum','$ldr','$status')";

if(mysqli_query($conn,$sql)){
    echo "Saved";
}else{
    echo "Error";
}

mysqli_close($conn);
?>