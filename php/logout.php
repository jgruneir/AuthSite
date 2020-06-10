<?php

include 'mylib.php';

$username = decryptUsername();

$ip = $_COOKIE['csp1_jag13047_cookie2'];

unset($_COOKIE['csp1_jag13047_cookie2']);
unset($_COOKIE['csp1_jag13047_cookie3']);
unset($_COOKIE['csp1_jag13047_cookie4']);

setcookie("csp1_jag13047_cookie2", "", time()- 360, "/CSE4707/prj1jag13047/", "localhost");
setcookie("csp1_jag13047_cookie3", "", time()- 360, "/CSE4707/prj1jag13047/", "localhost");
setcookie("csp1_jag13047_cookie4", "", time()- 360, "/CSE4707/prj1jag13047/", "localhost");

$link = dbConnect();

$query = "DELETE FROM cookie_information WHERE IP = '{$ip}' AND username = '{$username}'";
mysqli_query($link, $query);

header('Location: ../html/index.html.php?status=logout');


?>