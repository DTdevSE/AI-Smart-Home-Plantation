<?php
session_start();

/* Destroy All Session Data */
$_SESSION = array();
session_unset();
session_destroy();

/* Prevent Back Button Access */
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

/* Redirect to Login */
header("Location: login.php");
exit();
?>
