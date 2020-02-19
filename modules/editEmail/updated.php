<?php
	require_once 'ModelEmail.php';
	ModelEmail::update($_GET['id'],$_GET['email'],$_GET['promo'],$_GET['obj']);
	header('Location: index.php');
?>