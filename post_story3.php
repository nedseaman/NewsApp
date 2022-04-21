<?php
session_start();
require 'database.php';

// Check if user is logged in; if not, then they can't post a story.
if(!hash_equals($_SESSION['token'], $_POST['token'])) {
	header('Location: story_failure3.html');
	exit;
}

//these variables are passed along from the post_story.html page, we are also making sure that the variables are the correct data type.
$title = (String)$_POST['title'];
$body = (String)$_POST['body'];
$link = (String)$_POST['link'];
$author = (String)$_SESSION['username'];

//query to insert a story into the stories table using the variables above
$stmt = $mysqli->prepare('insert into stories (author, title, body, link) values (?,?,?,?)');
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

//making sure the variables types are consistent.
$stmt->bind_param('ssss', $author, $title, $body, $link);
$stmt->execute();
$stmt->close();
header('Location: home3.php');
exit;

?>