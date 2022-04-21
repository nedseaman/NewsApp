<?php
//just the logout php file
session_start();
session_destroy();
header("Location: home3.php");
exit;
?>