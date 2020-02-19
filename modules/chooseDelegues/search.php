<?php

require '../../config/verification.php';

// on initialise le tableau qui sera retourné pour la recherche
$return = array(
  "name" => $infos["name"],
  "search" => array()
);

// on rempli le tableau ...
$return["search"][] = $infos["name"];
$return["search"][] = "Délégués";
$return["search"][] = "Chefs";
$return["search"][] = "Responsables de TD";

print json_encode($return);

?>
