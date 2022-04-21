<?php

// need to include this file in every php file there is in order to access the database.

$mysqli = new mysqli('localhost', 'nmseaman', 'Tribe2300$', 'news');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}

?>