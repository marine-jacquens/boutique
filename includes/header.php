<?php
	require 'class/database.php';
	require 'class/users.php';
	$db = new Database();
	$user = new Users($db);
?>