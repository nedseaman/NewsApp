<?php
session_start();

require 'database.php';

// check if user is logged in, if not, then can't post a comment
if(!hash_equals($_SESSION['token'], $_POST['token'])) {
	header('Location: comment_failure3.html');
	exit;
}
//variables came from previous page (comment3.php) and session variable, also making sure that the variables are the correct data type.
$comment = (String)$_POST['comment'];
$story_id = (Int)$_POST['story_id'];
$author = (String)$_SESSION['username'];

//query to insert a comment story_id, author, and comment where the values will equal the previous variables
$stmt = $mysqli->prepare('insert into comments (story_id, author, comment) values (?,?,?)');
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
//making sure the variables types are consistent.
$stmt->bind_param('iss', $story_id, $author, $comment);
$stmt->execute();
$stmt->close();
//take us back to home page once we are done posting a comment.
header('Location: home3.php');
exit;

?>