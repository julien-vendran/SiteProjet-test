<?php
require_once 'ModelEmail.php';
$email=new ModelEmail($_GET['promo'],$_GET['email'],"",$_GET['obj']);
$email->save();
header('Location: index.php');
?>