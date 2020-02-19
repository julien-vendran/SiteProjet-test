<?php

session_start();

require '../../../config/DB.php';

$return = array(
  "error" => 0,
  "reponse" => ""
);

$current_user = $_SESSION['uid'];

//on regarde si il est pas deja dans un groupe
$sql="SELECT *
	FROM Groupe
    WHERE loginChef = '".$current_user."' 
    OR login2 = '".$current_user."' 
    OR login3 = '".$current_user."' 
    OR login4 = '".$current_user."' 
    OR login5 = '".$current_user."' 
    OR login6 = '".$current_user."'";
$rep = bdd::$pdo->query($sql);
$result = $rep->rowCount();

//si est deja dans un groupe
if($result == 0)
  $return["reponse"] = "no";
else {
  $return["reponse"] = "yes";
}

print json_encode($return);

?>