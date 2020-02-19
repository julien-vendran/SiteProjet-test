<?php

require '../../config/verification.php';

// on initialise le tableau qui sera retourné pour la recherche
$return = array(
  "name" => $infos["name"],
  "search" => array()
);

// on rempli le tableau ...
$return["search"][] = $infos["name"];
$return["search"][] = "Choisir Voeux";
$return["search"][] = "Classement Voeux";
$return["search"][] = "Classement Projets";



print json_encode($return);

?>
