<?php
session_start();
require 'database.php';

//we have a separate php file for posting an edited comment so that we don't have duplicate comments in the database.

// Check if user is logged in; if not, then you can't edit the comment.
if(!hash_equals($_SESSION['token'], $_POST['token'])) {
	header('Location: comment_failure3.html');
	exit;
}

//variables from previous page, edit_comment3.php, to be used in sql query, also making sure that the variables are the correct data type.
$comment = (String)$_POST['comment'];
$id = (Int)$_POST['comment_id'];

//querying to update a comment in the comments table rather than create a new entry
$stmt = $mysqli->prepare('update comments set comment=? where comment_id=?');
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
//making sure the variables types are consistent.
$stmt->bind_param('si', $comment, $id);
$stmt->execute();
$stmt->close();
header('Location: home3.php');
exit;

?>