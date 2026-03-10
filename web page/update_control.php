<?php
$conn = mysqli_connect("localhost","root","","smart_farm");

if(!$conn){
  die("DB Error");
}

$mode  = $_POST['mode'];
$pump  = $_POST['pump'];
$light = $_POST['light'];

mysqli_query($conn,"
  UPDATE control
  SET mode='$mode',
      pump='$pump',
      light='$light'
  WHERE id=1
");

echo "OK";
?>