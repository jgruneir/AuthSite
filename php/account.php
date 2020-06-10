<?php

include 'mylib.php';

$oldpass = $_POST['oldpass'];
$oldpass2 = $_POST['oldpass2'];
$newpass = $_POST['newpass'];
$newpass2 = $_POST['newpass2'];

if($oldpass != $oldpass2)
{
	header('Location: ../html/account.html.php?status=nomatch');
}
elseif($newpass != $newpass2) 
{
	header('Location: ../html/account.html.php?status=newnomatch');
}
else
{
	$link = dbConnect();
	#$username = $_COOKIE['csp1_jag13047_cookie1'];
	$username = decryptUsername();

	$query = "SELECT * FROM user_credentials WHERE username = '{$username}'";
	$result = mysqli_query($link, $query);  
	if (!$result)  
	{  
	  $output = 'Error fetching rows: ' . mysqli_error($link);
	  setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
	  header('Location: ../html/error.html.php');
	  exit();  
	}

	$row = mysqli_fetch_array($result);
	if (password_verify($oldpass, $row['password']))
	{
		$hashednewpass = password_hash($newpass, PASSWORD_DEFAULT);
		$query = "UPDATE user_credentials SET password = '{$hashednewpass}' WHERE username = '{$username}'";
		mysqli_query($link, $query);
		header('Location: ../html/account.html.php?status=success');
	}
	else
	{
		header('Location: ../html/account.html.php?status=incorrectpassword');
	}
}
?>