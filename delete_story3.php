<?php
session_start();
require 'database.php';

// check to see is user is logged in; if not logged in, can't delete the story
if(!hash_equals($_SESSION['token'], $_POST['token'])) {
	printf("Failed to delete story. Log in and try again.");
	exit;
}

// passed along from previous page as a hidden variable (home3.php), also making sure that the variable is the correct data type
$id = (Int)$_POST['story_id'];

$stmt = $mysqli->prepare('delete from stories where story_id=?');
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();
header('Location: home3.php');
exit;

?>