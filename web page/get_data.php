<?php
$conn = mysqli_connect("localhost","root","","smart_farm");

$sql = "SELECT * FROM farm_data ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn,$sql);

if($row = mysqli_fetch_assoc($result)){
    echo json_encode($row);
} else {
    echo json_encode(["error"=>"No data"]);
}
?>