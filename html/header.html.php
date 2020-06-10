<?php

include '../php/mylib.php';

?>

<link rel="stylesheet" href="../main.css">
<div id="headerBody" class="horcenter">

	<img id="headerTitle" class="horcenter" src="../data/title.png"/> 
	
	<?php if(checkUserAuthNoRedirect()) { ?> 

		<a href="user.html.php"><button>User</button></a>  
		<a href="account.html.php"><button>Account</button></a> 
		<a href="messages.html.php"><button>Messages</button></a>
		
	<?php } ?>

	<?php if(checkAdminAuthNoRedirect()) { ?> 
		<a href="admin.html.php"><button>Admin</button></a> 
	<?php } ?>

	<?php if(checkUserAuthNoRedirect()) { ?>
		<a href="../php/logout.php"><button>Logout</button></a> 
	<?php } ?>

	<br/><br/>

	<?php if(checkUserAuthNoRedirect()) { ?> 
	<div> You are logged in as: <?php echo decryptUsername() ?> </div>
	<?php } ?>
	
</div>