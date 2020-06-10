<?php

include '../php/admin.php';
checkAdminAuth();

?>
<!DOCTYPE html>
<html>
	<head>
		<title> Administration </title>
	</head>
	<body>
		<br/>
		<h2 class="horcenter">Welcome to the Admin page! </h2>
		<div id="tablediv" class="horcenter">
			<table id="userTable">
				<tr>
					<th> Username </th>
					<th> Admin? </th>
					<!-- <th> Password (hashed) </th> -->
				</tr>
				<?php foreach ($users as $user): ?>
				<tr>
					<td> <?php echo $user['username'] ?> </td>
					<td> <?php cleanAdmin($user['admin']) ?> </td>
					<!-- <td id="passwordCell"> <?php echo $user['password'] ?> </td> -->
 					<td> 
						<form action="../php/admin.php" method="post">
							<input type="text" style="display:none" value= <?php echo $user['username'] ?> name="changeroleuser" id="changeroleuser"/>
							<input type="text" style="display:none" value= <?php echo $user['admin'] ?> name="changeroleadmin" id="changeroleadmin"/>
							<input type="submit" value="Change role" />
						</form>
					</td> 
					<td>
						<form action="../php/admin.php" method="post">
							<input type="text" style="display:none" value= <?php echo $user['username'] ?> name="changepassuser" id="changepassuser"/>
							<input type="text" name="changepass" placeholder="New Password..." id="changepass"/>
							<input type="submit" value="Change password" />
						</form>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
			<table id="addUserTable">
				<tr>
					<form action="../php/admin.php" method="post">
						<td> <input type="text" name="addusername" placeholder="Username" id="addusername"/> </td>
						<td> <input type="text" name="addpassword" placeholder="Password" id="addpassword"/> </td>
						<td> <input type="text" name="addadmin" placeholder="Admin? (true or false)" id="addadmin"/> </td>
						<td> <input type="submit" value="Add" name="add"/> </td>
					</form>
				</tr>
				</tr>
			</table>
			<form action="../php/admin.php" method="post" id="delUserForm">
				<input type="submit" value="Delete user:"/>
				<div style="display: inline">
	   				<input type="text" name="delusername" placeholder="Username" id="delusername"/>
				</div>
			</form>
			<?php
				if (isset($_GET["status"])) 
				{
					if ($_GET["status"] == 'passwordchanged')
					{
						echo "Password changed.";
					}
					elseif ($_GET["status"] == 'rolechanged')
					{
						echo "Role changed.";
					}
					elseif ($_GET["status"] == 'useradded')
					{
						echo "User added.";
					}
					elseif ($_GET["status"] == 'userdeleted')
					{
						echo "User deleted.";
					}
				}
			?>
		</div>
	</body>

</html>
<?php 

include 'footer.html.php';

?>