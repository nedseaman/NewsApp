<?php
session_start();
require 'database.php';

// Check if user is logged in; if not logged in, can't delete comment
if(!hash_equals($_SESSION['token'], $_POST['token'])) {
	printf("Failed to delete comment. Log in and try again.");
	exit;
}

// passed along from previous page as a hidden variable (comments3.php), also making sure that the variable is the correct data type.
$id = (Int)$_POST['comment_id'];

//query to delete the comment from the comments table.
$stmt = $mysqli->prepare('delete from comments where comment_id=?');
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $id);
$stmt->execute();
//when done, head back to home page.
$stmt->close();
header('Location: home3.php');
exit;
?>