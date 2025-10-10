<?php


	session_start();

	function getUser()
	{
		if(!isset($_SESSION['user']))
		{
			return "Guest";
		}

		$user = $_SESSION['user'];

		return $user;
	}

?>