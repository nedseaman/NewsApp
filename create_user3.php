<?php
session_start();

require 'database.php';

//taking variables from previous page to use for checking if usernames are already in use and to hash password, also making sure that the variables are the correct data type.
$user = (String)$_POST['user'];
$password = (String)$_POST['password'];

//querying database for usernames
$stmt = $mysqli->prepare('select username from users');
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();
$stmt->bind_result($username);

// checking that new username is not duplicate of other username already in use
while($stmt->fetch()) {
	if($user == $username) {
		printf("Username already in user. Please try again.");
		exit;
	}
}

// username is not in use so we will register new user
$stmt = $mysqli->prepare('insert into users (username, pass) values (?,?)');
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

// hashing password, yay computer security, making sure that the variable types are consistent
$stmt->bind_param('ss', $user, password_hash($password,PASSWORD_DEFAULT));
$stmt->execute();
$stmt->close();
header('Location: home3.php');
exit;
?>