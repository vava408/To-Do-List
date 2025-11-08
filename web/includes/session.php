<?php

function sessionStart($userName, $userid)
{
	session_start();
	
	if (isset($userName)) {
		$_SESSION['user'] = $userName;
		$_SESSION['user_id'] = $userid;
	} else {
		$_SESSION['user'] = 'guest';
		$_SESSION['user_id'] = 0;
	}
	
	//echo "Session started. User: " . $_SESSION['user'] . " (ID: " . $_SESSION['user_id'] . ")<br>";
}
?>	