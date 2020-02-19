<?php

require '../../config/verification.php';
require '../../config/DB.php';

// on initialise le tableau qui sera retourné pour la recherche
$return = array(
  "name" => $infos["name"],
  "search" => array()
);

// on rempli le tableau ...
$return["search"][] = $infos["name"];
$return["search"][] = "Modifier le planning";


print json_encode($return);

?>
