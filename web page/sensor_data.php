<?php

$conn = mysqli_connect("localhost","root","","final_project_db");

if(!$conn){
    die("DB Error");
}

if(
   !isset($_GET['temp']) ||
   !isset($_GET['hum'])  ||
   !isset($_GET['soil']) ||
   !isset($_GET['pump']) ||
   !isset($_GET['light'])
){
    die("Missing Data");
}

$temp  = $_GET['temp'];
$hum   = $_GET['hum'];
$soil  = $_GET['soil'];
$pump  = $_GET['pump'];
$light = $_GET['light'];

$sql = "INSERT INTO sensor_data
        (temperature, humidity, soil_value, pump_status, light_status)
        VALUES
        ('$temp','$hum','$soil','$pump','$light')";

mysqli_query($conn,$sql);

echo "Saved";

mysqli_close($conn);
?>