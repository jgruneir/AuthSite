<?php

include 'header.html.php';
checkLoginPageAuth();

?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			Login Page
		</title>
	</head>
	<body>
		<div class="horcenter" id="loginDiv">
			<form id="loginForm" class="horcenter" action="../php/login.php" method="post">  
				<div>
			  		<div>
			  			<label for="username">Username:</label> 
			  		</div>
					<input type="text" name="username" id="loginUsername"/>
				</div>  
			<div>
				<div>
					<label for="password">Password:</label>
				</div>
					<input type="password" name="password" id="loginPassword"/>
				</div>  
				<div>
					<input class="submit" type="submit" value="Login"/>
				</div>  
			</form>
		</div>
		<?php
			$error = '';
			if (isset($_GET["status"])) 
			{
				if ($_GET["status"] == 'invalid')
				{
					$error = "Invalid username or password.";
				}
				elseif ($_GET["status"] == 'logout')
				{
					$error = "Successfully logged out.";
				}
			?> <br></br> <div class="horcenter"> <?php echo $error; ?> </div> <?php
			}
		?> 
	</body>
</html>