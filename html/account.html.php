<?php

include 'header.html.php';
checkUserAuth();

?>
<!DOCTYPE html>
<html>
	<head>
		<title> Account </title>
	</head>
	<body>
		<div id="passChangeDiv" class="horcenter">
			<h2> Change Password: </h2>
			<form action="../php/account.php" method="post" id="passChangeForm" >  

			  <div><label for="oldpass">Enter Old Password:  

			    <input type="password" name="oldpass" id="oldpass"/></label>  

			  </div>  

			  <div><label for="oldpass2">Enter Old Password Again:  

			    <input type="password" name="oldpass2" id="oldpass2"/></label>

			  </div>  

			  <div><label for="newpass">Enter New Password:  

			    <input type="password" name="newpass" id="newpass"/></label>  

			  </div>  

			  <div><label for="newpass2">Enter New Password Again:  

			    <input type="password" name="newpass2" id="newpass2"/></label>  

			  </div>  

			  <div><input type="submit" value="Update Password"/></div>  

			</form>

			<?php
				if (isset($_GET["status"])) 
				{
					if ($_GET["status"] == 'nomatch') 
					{
						echo "Old passwords did not match.";
					}
					elseif ($_GET["status"] == 'success') 
					{
						echo "Password successfully changed!";
					}
					elseif ($_GET["status"] == 'incorrectpassword')
					{
						echo "Old password did not match current password.";
					}
					elseif ($_GET["status"] == 'newnomatch')
					{
						echo "New passwords did not match.";
					}
				}
			?>
		</div>

		<?php 

		include 'footer.html.php';

		?>
	</body>
</html>