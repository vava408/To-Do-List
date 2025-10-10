<?php

	session_start();
	
	if(isset($_SESSION['user_id']))
	{
		return "Username";
	}

	$userId = $_SESSION['user_id'];

	

	return $user;

?>