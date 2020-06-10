<?php

include 'header.html.php';

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Error</title>
		<meta http-equiv="refresh" content="4;url=index.html.php"/>
	</head>
	<body class="horcenter">
		<br/> 
		<h3>
			<?php

			if (isset($_COOKIE["csp1_jag13047_cookie4"])) 
			{
				$errorText = $_COOKIE['csp1_jag13047_cookie4'];
				echo $errorText;
			}
			else
			{
				echo('Unidentified Error.');
			}
			?> 
		</h3> 

		<div>
			Redirecting to home page in 4 seconds...
		</div>

		<?php

		include 'footer.html.php';

		?>

	</body>
</html>