<?php

	session_start();
	
	if(isset($_SESSION['user']))
	{
		return "Username";
	}

	$user = $_SESSION['user'];

	return $user;

?>