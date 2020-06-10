<?php

include 'mylib.php';

//Artificial delay
sleep(2);

$username = $_POST['username'];
$password = $_POST['password'];

$link = dbConnect();

$query = "SELECT * FROM user_credentials WHERE username='{$username}'";
$result = mysqli_query($link, $query);  

if (!$result)  
{  
  $output = 'Error fetching rows: ' . mysqli_error($link);
  setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
  header('Location: ../html/error.html.php');
  exit();  
}

$row = mysqli_fetch_array($result);

//If username is invalid
if ($row == null) 
{
  header('Location: ../html/index.html.php?status=invalid');
  exit();  
}

//Check password validity
if (password_verify($password, $row['password']))
{
  generate_cookies($link, $username);
  header('Location: ../html/user.html.php');
}
else
{
  header('Location: ../html/index.html.php?status=invalid');
}

function generate_cookies($sqlink, $uname)
{
  $seckey = generateRandomString();
  $ip = $_SERVER['REMOTE_ADDR'];
  $username = $uname;
  $link = $sqlink;

  $dbClear = "DELETE FROM cookie_information WHERE username = '{$username}' and IP = '{$ip}'";
  mysqli_query($link, $dbClear);

  $dbPush = "INSERT INTO cookie_information (username, IP, security_key) VALUES ('{$username}', '{$ip}', '{$seckey}')";
  mysqli_query($link, $dbPush);

  setcookie("csp1_jag13047_cookie2", $ip, time()+7200, "/CSE4707/prj1jag13047/", "localhost");
  setcookie("csp1_jag13047_cookie3", $seckey, time()+7200, "/CSE4707/prj1jag13047/", "localhost");
}

//http://stackoverflow.com/questions/4356289/php-random-string-generator
//Used to generate security key
function generateRandomString() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    $length = 100;
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>