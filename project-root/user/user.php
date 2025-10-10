<?php
session_start();

function getUser() {
	return $_SESSION['user'] ?? 'guest';
}

	$user = $_SESSION['user'];

	return $user;

?>