<?php

require '../../config/verification.php';
require '../../DB.php';

// on initialise le tableau qui sera retourné pour la recherche
$return = array(
  "name" => $infos["name"],
  "search" => array()
);

// On effectue la recherche par rapport aux tuteurs qui ont renseignés leurs disponibilités
try {
  $sql = "SELECT nom, prenom FROM Disponibilites D JOIN Utilisateurs U ON U.login = D.Enseignant";
  $req = bdd::$pdo->query($sql);
  $tuteurs_renseignes = $req->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $return['error'] = $e->getMessage();
}

// on rempli le tableau ...
$return["search"][] = $infos["name"];
$return["search"][] = "Disponibilités des tuteurs";
$return["search"][] = "Tuteurs disponible pour les soutenances";
// On rempli le tableau avec les tuteurs qui ont renseignés leurs disponibilités
foreach ($tuteurs_renseignes as $tuteur) {
  $nom = $tuteur['nom'];
  $prenom = $tuteur['prenom'];
  $return["search"][] = "Voir les disponibilités de " . ucfirst($prenom) . " " . ucfirst($nom);
}

print json_encode($return);

?>
