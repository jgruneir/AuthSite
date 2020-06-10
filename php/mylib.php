<?php



//Connect to MySQL database, returns the connection.
function dbConnect()
{
	$link = mysqli_connect('localhost', 'root', 'admin1'); 

	if (!$link) 
	{ 
	  $output = 'Unable to connect to the database server.'; 
  	  setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
  	  header('Location: ../html/error.html.php');
  	  exit();  
	}

	if (!mysqli_set_charset($link, 'utf8')) 
	{ 
	  $output = 'Unable to set database connection encoding.'; 
  	  setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
  	  header('Location: ../html/error.html.php');
  	  exit(); 
	}

	if (!mysqli_select_db($link, 'db_jag13047')) 
	{ 
	  $output = 'Unable to locate the db_jag13047 database.'; 
  	  setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
  	  header('Location: ../html/error.html.php');
  	  exit(); 
	}

	return $link;
}

function decryptMessage($encryptedMsg, $ivKE, $ivKI, $encryptedKE, $encryptedKI) 
{
	include "config.php";

	$ivKE = base64_decode($ivKE);
	$ivKI = base64_decode($ivKI);
	$KE = openssl_decrypt($encryptedKE, $cipher, $masterKey, 0, $ivKE);
	$KI = openssl_decrypt($encryptedKI, $cipher, $masterKey, 0, $ivKI);
	$msg = openssl_decrypt($encryptedMsg, $cipher, $KE, 0, $ivKE);

	if(openssl_encrypt($msg, $cipher, $KE, 0, $ivKI) != $KI)
	{
		$msg = "Message corrupted.";
	}
	return $msg;
}

//Gets the username of the currently logged in user by querying the databases with the security code in cookie3
function decryptUsername()
{
	$link = dbConnect();

	if(!isset($_COOKIE['csp1_jag13047_cookie3']))
	{
		return false;
	}
	else
	{
		$seckey = $_COOKIE['csp1_jag13047_cookie3'];
		$query = "SELECT * FROM cookie_information WHERE security_key = '{$seckey}'";
		$result = mysqli_query($link, $query);

		if (!$result)  
		{  
			$output = 'Error fetching rows: ' . mysqli_error($link);  
	  	  	setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
	  	  	header('Location: ../html/error.html.php');
	  	  	exit(); 
		}
		else
		{
			$row = mysqli_fetch_array($result);
			return $row['username'];
		}
	}
}

//Verifies the correct user is logged in
function checkUserAuth()
{
	$link = dbConnect();

	if (!isset($_COOKIE['csp1_jag13047_cookie3']))
	{
		$output = "Access Denied. Please login.";
		setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
		header('Location: ../html/error.html.php');
	}
	else
	{
		#$uname = $_COOKIE['csp1_jag13047_cookie1'];
		$uname = decryptUsername();
		$ip = $_COOKIE['csp1_jag13047_cookie2'];
		$seckey = $_COOKIE['csp1_jag13047_cookie3'];
		$query = "SELECT * FROM cookie_information WHERE username = '{$uname}' and IP = '{$ip}'";
		$result = mysqli_query($link, $query);

		if (!$result)  
		{  
		  $output = 'Error fetching rows: ' . mysqli_error($link);  
  	  	  setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
  	  	  header('Location: ../html/error.html.php');
  	  	  exit(); 
		}

		$row = mysqli_fetch_array($result);
		if($row['security_key'] == $seckey)
		{
			return true;
		}
		else
		{
			$output = 'Authentication Error';
			setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
  	  		header('Location: ../html/error.html.php');
  	  		exit(); 
		}
	}
}

function checkUserAuthNoRedirect()
{
	$link = dbConnect();

	if (!isset($_COOKIE['csp1_jag13047_cookie3']))
	{
		return false;
	}
	else
	{
		#$uname = $_COOKIE['csp1_jag13047_cookie1'];
		$uname = decryptUsername();
		$ip = $_COOKIE['csp1_jag13047_cookie2'];
		$seckey = $_COOKIE['csp1_jag13047_cookie3'];
		$query = "SELECT * FROM cookie_information WHERE username = '{$uname}' and IP = '{$ip}'";
		$result = mysqli_query($link, $query);

		if (!$result)  
		{  
		  $output = 'Error fetching rows: ' . mysqli_error($link);  
  	  	  setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
  	  	  header('Location: ../html/error.html.php');
  	  	  exit(); 
		}

		$row = mysqli_fetch_array($result);
		if($row['security_key'] == $seckey)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

//Verifies the login page can be viewed (i.e. user is not logged in)
function checkLoginPageAuth()
{
	if(isset($_COOKIE['csp1_jag13047_cookie3']))
	{
		header('Location: ../html/user.html.php');
	}
	else
	{
		return true;
	}
}
function checkLoginPageAuthNoRedirect()
{
	if(isset($_COOKIE['csp1_jag13047_cookie3']))
	{
		return false;
	}
	else
	{
		return true;
	}
}

//Verifies the user is an admin
function checkAdminAuth()
{
	$link = dbConnect();
	if (!isset($_COOKIE['csp1_jag13047_cookie3']))
	{
		$output = "Access Denied. Please login.";
		setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
		header('Location: ../html/error.html.php');
	}
	else
	{
		#$uname = $_COOKIE['csp1_jag13047_cookie1'];
		$uname = decryptUsername();
		$query = "SELECT * FROM user_credentials WHERE username = '{$uname}'";
		$result = mysqli_query($link, $query);

		if (!$result)  
		{  
		  $output = 'Error fetching rows: ' . mysqli_error($link);  
  	  	  setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
  	  	  header('Location: ../html/error.html.php');
  	  	  exit(); 
		}

		$row = mysqli_fetch_array($result);
		if ($row['admin'] == 1)
		{
			return true;
		}
		else 
		{
			$output = 'Admin access is required to view this page.';
			setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
  	  		header('Location: ../html/error.html.php');
  	  		return false;
		}
	}
}
function checkAdminAuthNoRedirect()
{
	$link = dbConnect();
	if (!isset($_COOKIE['csp1_jag13047_cookie3']))
	{
		return false;
	}
	else
	{
		#$uname = $_COOKIE['csp1_jag13047_cookie1'];
		$uname = decryptUsername();
		$query = "SELECT * FROM user_credentials WHERE username = '{$uname}'";
		$result = mysqli_query($link, $query);

		if (!$result)  
		{  
		  $output = 'Error fetching rows: ' . mysqli_error($link);  
  	  	  setcookie("csp1_jag13047_cookie4", $output, 0, "/CSE4707/prj1jag13047/", "localhost"); 
  	  	  header('Location: ../html/error.html.php');
  	  	  exit(); 
		}

		$row = mysqli_fetch_array($result);
		if ($row['admin'] == 1)
		{
			return true;
		}
		else 
		{
  	  		return false;
		}
	}
}

?>