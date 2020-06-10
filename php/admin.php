<?php

include '../html/header.html.php';

$link = dbConnect();
$query = "SELECT * FROM user_credentials";

$result = mysqli_query($link, $query);

//To generate table
$users = array();

while ($row = mysqli_fetch_array($result))
{
	array_push($users, $row);
}

//Adding a user
if(isset($_POST['addusername']))
{
	$username = $_POST['addusername'];
	$password = $_POST['addpassword'];
	$admin = $_POST['addadmin'];
	$hashedpassword = password_hash($password, PASSWORD_DEFAULT);

	if($admin > 1)
	{
		$admin = true;
	}

	$link = dbConnect();

	$query = "INSERT INTO user_credentials (username, password, admin) VALUES ('{$username}', '{$hashedpassword}', {$admin})";
	$result = mysqli_query($link, $query);

	if(!$result)
	{
	  $output = 'Error fetching rows: ' . mysqli_error($link);
	  setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
	  header('Location: ../html/error.html.php');
	  exit();  
	}

	header('Location: ../html/admin.html.php?status=useradded');
}

//Deleting a user
if(isset($_POST['delusername']))
{
	$username = $_POST['delusername'];

	$link = dbConnect();

	$query = "DELETE FROM user_credentials WHERE username = '{$username}'";
	$result = mysqli_query($link, $query);

	if(!$result)
	{
		$output = 'Error fetching rows: ' . mysqli_error($link);
		setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
		header('Location: ../html/error.html.php');
		exit();  
	}

	header('Location: ../html/admin.html.php?status=userdeleted');
}

//Changing role of a user
if(isset($_POST['changeroleuser']))
{
	$username = $_POST['changeroleuser'];
	$admin = $_POST['changeroleadmin'];

	$link = dbConnect();

	if($admin == 0)
	{
		$query = "UPDATE user_credentials SET admin = 1 WHERE username = '{$username}'";
	}
	else
	{
		$query = "UPDATE user_credentials SET admin = 0 WHERE username = '{$username}'";
	}

	$result = mysqli_query($link, $query);

	if(!$result)
	{
		$output = 'Error fetching rows: ' . mysqli_error($link);
		setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
		header('Location: ../html/error.html.php');
		exit();  
	}

	header('Location: ../html/admin.html.php?status=rolechanged');
}

//Changing a user's password
if(isset($_POST['changepass']))
{
	$username = $_POST['changepassuser'];
	$newpass = $_POST['changepass'];
	$newpasshashed = password_hash($newpass, PASSWORD_DEFAULT);

	$link = dbConnect();

	$query = "UPDATE user_credentials SET password= '{$newpasshashed}' WHERE username='{$username}'";
	$result = mysqli_query($link, $query);

	if(!$result)
	{
		$output = 'Error fetching rows: ' . mysqli_error($link);
		setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
		header('Location: ../html/error.html.php?');
		exit();  
	}

	header('Location: ../html/admin.html.php?status=passwordchanged');
}

//Changes 0/1s into true/false
function cleanAdmin($value) {
	if($value == 0)
	{
		echo 'false';
	}
	else
	{
		echo 'true';
	}
}

?>