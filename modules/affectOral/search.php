<?php

require '../../config/verification.php';

// on initialise le tableau qui sera retourné pour la recherche
$return = array(
  "name" => $infos["name"],
  "search" => array()
);

// on rempli le tableau ...
$return["search"][] = $infos["name"];
$return["search"][] = "Horaires";
$return["search"][] = "Affecter";
$return["search"][] = "Soutenances";
$return["search"][] = "Oral";
$return["search"][] = "Disponibilités";

print json_encode($return);

?>
