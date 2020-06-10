<?php

include '../php/messages.php';
checkUserAuth();

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title> Messages </title>
	</head>
	<body id="messagesBody">
		<div id="receivedMessages">
			<table>
				<tr>
					<th>
						Sender
					</th>
					<th>
						Date Received
					</th>
					<th>
						Message
					</th>
				</tr>
				<?php foreach($received as $msg): ?>
				<tr>
					<td>
						<?php echo($msg['sender']); ?>
					</td>
					<td>
						<?php echo($msg['time']); ?> 
					</td>
					<td>
						<?php echo(decryptMessage($msg['message'], $msg['ivKE'], $msg['ivKI'], $msg['KE'], $msg['KI'])); ?>
					</td>
					<td> 
						<form action="../php/messages.php" method="post">
							<input type="text" style="display:none" value= <?php echo $msg['ID'] ?> name="delMessageID" id="delMessageID"/>
							<input type="submit" value="Delete" />
						</form>
					</td> 
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<div id="sentMessages">
			<table>
				<tr>
					<th>
						Recipient
					</th>
					<th>
						Date Sent
					</th>
					<th>
						Message
					</th>
				</tr>
				<?php foreach($sent as $msg): ?>
				<tr>
					<td>
						<?php echo($msg['recipient']); ?>
					</td>
					<td>
						<?php echo($msg['time']); ?> 
					</td>
					<td>
						<?php echo(decryptMessage($msg['message'], $msg['ivKE'], $msg['ivKI'], $msg['KE'], $msg['KI'])); ?>
					</td>
					<td> 
						<form action="../php/messages.php" method="post">
							<input type="text" style="display:none" value= <?php echo $msg['ID'] ?> name="delMessageID" id="delMessageID"/>
							<input type="submit" value="Delete" />
						</form>
					</td> 
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<div id="sendMessage">
			<form action="../php/messages.php" method="post" id="sendMessageForm">
				<input type="submit" value="Send a message:"/>
				<div style="display: inline">
	   				<input type="text" name="recipientName" placeholder="Username" id="recipientName"/>
	   				<input type="text" name="messageBody" placeholder="Message" id="messageBody"/>
				</div>
			</form>
		</div>

		<?php
			if (isset($_GET["status"])) 
			{
				if ($_GET["status"] == 'messagesent')
				{
					echo "Message sent.";
				}
				elseif ($_GET["status"] == 'messagedeleted') 
				{
					echo "Message deleted.";
				}
				elseif ($_GET["status"] == 'invalidusername') 
				{
					echo "Invalid username.";
				}
				else
				{
					echo($_GET["status"]);
				}
			}
		?>
	</body>
</html>

<?php 

include 'footer.html.php';

?>