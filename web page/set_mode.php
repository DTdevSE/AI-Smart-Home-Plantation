<?php

$conn = mysqli_connect("localhost","root","","sensor_db");

$mode = $_GET['mode'];   // AUTO or MANUAL

$sql = "UPDATE light_control
        SET mode='$mode'
        WHERE id=1";

mysqli_query($conn,$sql);

echo "OK";
?>
