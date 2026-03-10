<?php
$conn = mysqli_connect("localhost","root","","sensor_db");

$sql = "SELECT * FROM ldr_data ORDER BY id DESC LIMIT 1";
$res = mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($res);

echo json_encode($row);

mysqli_close($conn);
?>
