<?php
$conn = mysqli_connect("localhost","root","","sensor_db");

$status = $_GET['status']; // ON or OFF

$sql = "UPDATE light_control
        SET status='$status',
            mode='MANUAL'
        WHERE id=1";

mysqli_query($conn,$sql);

echo "OK";
?>
