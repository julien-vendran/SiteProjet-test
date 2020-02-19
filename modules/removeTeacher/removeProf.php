<?php
    //require_once 'index.php';
   	require 'ModelProf.php';
   	$log=$_GET['login'];
	ModelProf::removeProf($log); 
    header('Location: index.php');
    //echo "<script>alert('Prof supprimé')</script>"; 
?>
