<?php
session_start();
require 'database.php';

//we have this page so that we can avoid duplicate stories within the stories table

// Check if user is logged in, if not, then the user can't edit the story
if(!hash_equals($_SESSION['token'], $_POST['token'])) {
	header('Location: story_failure3.html');
	exit;
}

//getting variables from edit_story3.html form, also making sure that the variables are the correct data type.
$title = (String)$_POST['title'];
$body = (String)$_POST['body'];
$link = (String)$_POST['link'];
$id = (Int)$_POST['story_id'];

//query to update the stories rather than add a new one to the stories table.
$stmt = $mysqli->prepare('update stories set title=?, body=?, link=? where story_id=?');
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

//making sure the variables types are consistent.
$stmt->bind_param('sssi', $title, $body, $link, $id);
$stmt->execute();
$stmt->close();
//after you're done editing your comment, go back to the home page.
header('Location: home3.php');
exit;

?>