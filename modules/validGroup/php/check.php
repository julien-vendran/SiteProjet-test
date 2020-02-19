<?php

session_start();

require '../../../config/DB.php';

$return = array(
  "error" => 0,
  "check" => ""
);

$current_user = $_SESSION['uid'];

//On récupère le validGroup de l'user
$sql="SELECT validGroup FROM Utilisateurs WHERE login='".$current_user."'";
$rep = bdd::$pdo->query($sql);
$result = $rep->fetchAll();

//on regarde si il a deja valider
if($result[0]["validGroup"] == "")
  $return["check"] = "yes";
else {
  $return["check"] = "no";
}

//on regarde s'il est dans un groupe
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

//si a pas de groupe
if($result == 0){
  $return["check"] = "group";
}

print json_encode($return);

?>
