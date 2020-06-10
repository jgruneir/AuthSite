<?php

include "../php/mylib.php";
include "../php/config.php";

$link = dbConnect();

	$sender = "admin";
	$recipient = "user";
	$message = "hello";

	$ivKE = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
	$ivKI = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

	$KE = openssl_random_pseudo_bytes(16);

	$encryptedMessage = openssl_encrypt($message, $cipher, $KE, 0, $ivKE);
	$KI = openssl_encrypt($message, $cipher, $KE, 0, $ivKI);

	$encryptedKE = openssl_encrypt($KE, $cipher, $masterKey, 0, $ivKE);
	$encryptedKI = openssl_encrypt($KI, $cipher, $masterKey, 0 ,$ivKI);

	$ivKE = base64_encode($ivKE);
	$ivKI = base64_encode($ivKI);

	echo($message."<br>");
	echo($ivKE."<br>");
	echo($ivKI."<br>");
	echo($encryptedKE."<br>");
	echo($encryptedKI."<br>");

	$query = "INSERT INTO messages (sender, recipient, message, ivKE, ivKI, KE, KI) VALUES ('{$sender}', '{$recipient}', '{$message}', '{$ivKE}', '{$ivKI}', '{$encryptedKE}', '{$encryptedKI}')";
	$result = mysqli_query($link, $query);

?>