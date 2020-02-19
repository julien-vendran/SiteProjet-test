<?php

require '../../config/verification.php';

// on initialise le tableau qui sera retourné pour la recherche
$return = array(
  "name" => $infos["name"],
  "search" => array()
);

// on rempli le tableau ...
$return["search"][] = $infos["name"];
$return["search"][] = "Sauvegarder et/ou archiver l'année courante et les affectations";
$return["search"][] = "Voir les anciennes sauvegarde";

print json_encode($return);

?>
