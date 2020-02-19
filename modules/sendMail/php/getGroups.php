<?php

session_start();

require '../../../config/DB.php';

$return = array(
    "error" => 0,
    "groups" => ""
);
$tab=array();
$req = "SELECT DISTINCT promotion FROM Utilisateurs";
$reqProj = bdd::$pdo->prepare($req);
$reqProj->execute();
$tab = $reqProj->fetchAll(PDO::FETCH_ASSOC);
$return['groups']=$tab;
print json_encode($return);
/*foreach ($return['groups'] as $value) {
	echo $value['promotion'];
}*/
?>