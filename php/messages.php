<?php

include '../html/header.html.php';

$link = dbConnect();
$username = decryptUsername();
$queryReceived = "SELECT * FROM messages WHERE recipient = '{$username}'";
$querySent = "SELECT * FROM messages WHERE sender = '{$username}'";

$resultReceived = mysqli_query($link, $queryReceived);
$resultSent = mysqli_query($link, $querySent);

$received = array();
$sent = array();

while ($row = mysqli_fetch_array($resultReceived))
{
	array_push($received, $row);
}

while ($row = mysqli_fetch_array($resultSent))
{
	array_push($sent, $row);
}

//Sending message
if(isset($_POST['recipientName']))
{
	include "config.php";

	$recipient = $_POST['recipientName'];
	$message = $_POST['messageBody'];
	$sender = decryptUsername();

	$link = dbConnect();

	$ivKE = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
	$ivKI = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

	$KE = openssl_random_pseudo_bytes(16);

	$encryptedMessage = openssl_encrypt($message, $cipher, $KE, 0, $ivKE);
	$KI = openssl_encrypt($message, $cipher, $KE, 0, $ivKI);

	$encryptedKE = openssl_encrypt($KE, $cipher, $masterKey, 0, $ivKE);
	$encryptedKI = openssl_encrypt($KI, $cipher, $masterKey, 0 ,$ivKI);

	$ivKE = base64_encode($ivKE);
	$ivKI = base64_encode($ivKI);

	$query = "INSERT INTO messages (sender, recipient, message, ivKE, ivKI, KE, KI) VALUES ('{$sender}', '{$recipient}', '{$encryptedMessage}', '{$ivKE}', '{$ivKI}', '{$encryptedKE}', '{$encryptedKI}')";
	$result = mysqli_query($link, $query);

	if(!$result)
	{
	  $error = mysqli_error($link);
	  if (substr($error, 0, 64)  == "Cannot add or update a child row: a foreign key constraint fails")
	  {
	  	header('Location: ../html/messages.html.php?status=invalidusername');
	  	exit();
	  }
	  else
	  {
		$output = 'Error fetching rows: ' . mysqli_error($link);
		setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
		header('Location: ../html/error.html.php');
		exit();  
	  }

	}

	header('Location: ../html/messages.html.php?status=messagesent');
}

if(isset($_POST['delMessageID']))
{
	$ID = $_POST['delMessageID'];

	$link = dbConnect();

	$query = "DELETE FROM messages WHERE ID = '{$ID}'";
	$result = mysqli_query($link, $query);

	if(!$result)
	{
	  $output = 'Error fetching rows: ' . mysqli_error($link);
	  setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
	  header('Location: ../html/error.html.php');
	  exit();  
	}

	header('Location: ../html/messages.html.php?status=messagedeleted');
}
?>