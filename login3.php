<?php
session_start();

//the user and pass from the login3.html page form, also making sure that the variables are the correct data type.
$user = (String) $_POST['user'];
$pass = (String) $_POST['pass'];

require 'database.php';

//query to select all columns from users table where the username will equal $user
$stmt = $mysqli->prepare("select * from users where username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

//making sure the variable type is consistent ($user is a String).
$stmt->bind_param('s',$user);
$stmt->execute();
//bind results to variables that we can use to compare to results from query
$stmt->bind_result($username, $password);

//check if username and password matches any of the usernames and passwords in from database
$stmt->fetch();
//password security things.
if(password_verify($pass, $password)){
    $_SESSION['username'] = $username;
    $_SESSION['token'] = bin2hex(random_bytes(32));
    header("Location: home3.php");
    exit;
} else {
    printf("Incorrect password.");
    exit;
}

//if username doesn't exist, then we print this.
$stmt->close();
printf("User does not exist.");
exit;

?>