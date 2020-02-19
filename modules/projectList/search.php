<?php

session_start();

require '../../config/verification.php';
require '../../config/DB.php';

// on initialise le tableau qui sera retourné pour la recherche
$return = array(
  "name" => $infos["name"],
  "search" => array()
);

$current_user = $_SESSION['uid'];

// on rempli le tableau ...
$return["search"][] = $infos["name"];
$return["search"][] = "Afficher les projets disponibles";


//On récupère la promotion de l'utilisateur connecté si c'est un étudiant
if ($_SESSION["level"] < 3) {
  try {
    $sqlCurrIdProm = "SELECT promotion
                      FROM Utilisateurs U
                      WHERE U.login = :current";
    $reqCurrIdProm = bdd::$pdo->prepare($sqlCurrIdProm);
    $reqCurrIdProm->execute(array('current' => $current_user));
    $currIdProm = $reqCurrIdProm->fetch(PDO::FETCH_ASSOC);
    $idPromo = $currIdProm["idPromo"];

    //On récupère maintenant tous les projets actifs qui sont disponibles pour cette promotion
    $sqlProj = "SELECT titre, description, remarques, U.nom AS tuteur, U1.nom AS tuteur_bis, actif, idPromo
                FROM Projets P
                JOIN Utilisateurs U ON P.tuteur = U.login
                LEFT JOIN Utilisateurs U1 ON P.tuteur_bis = U1.login
                WHERE actif = 1 AND idPromo = :id";
    $reqProj = bdd::$pdo->prepare($sqlProj);
    $reqProj->execute(array('id' => $idPromo));
    $projectList = $reqProj->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }
}
//Sinon c'est un enseignant et on charge tous les projets actifs
else {
  try {
    //On récupère tous les projets actif
    $sqlProj = "SELECT titre, description, remarques, U.nom AS tuteur, U1.nom AS tuteur_bis, actif, idPromo
                FROM Projets P
                JOIN Utilisateurs U ON P.tuteur = U.login
                LEFT JOIN Utilisateurs U1 ON P.tuteur_bis = U1.login
                WHERE actif = 1";
    $reqProj = bdd::$pdo->prepare($sqlProj);
    $reqProj->execute();
    $projectList = $reqProj->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }
}

foreach ($projectList as $key => $value) {
  $return["search"][] = $value["titre"] . ' - ' . $value["description"] . ' - ' . $value["remarques"] . ' - ' . $value["tuteur"] . ' - ' . $value["tuteur_bis"];
}

print json_encode($return);

?>
