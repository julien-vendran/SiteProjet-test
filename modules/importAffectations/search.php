<?php

require '../../config/verification.php';

// on initialise le tableau qui sera retourné pour la recherche
$return = array(
  "name" => $infos["name"],
  "search" => array()
);

// on rempli le tableau ...
$return["search"][] = $infos["name"];
$return["search"][] = "Importer la liste des projets en csv";
$return["search"][] = "Convertir projets csv en json";

print json_encode($return);

?>
