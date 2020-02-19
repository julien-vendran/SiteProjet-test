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

try {
  $req = bdd::$pdo->query("SELECT Titre, Description, date_format(Date, '%d') as day, date_format(Date, '%w') as w, date_format(Date, '%m') as month, date_format(Date, '%Y') as year FROM Planning");

  while( $res = $req->fetch(PDO::FETCH_ASSOC) ) {
    $return["search"][] = $res["Titre"] . " - " . $res["Description"];
  }
} catch (PDOException $e) {
}


print json_encode($return);

?>
