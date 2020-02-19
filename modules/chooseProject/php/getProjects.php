<?php

  session_start();

  require '../../../config/DB.php';

  $current_user = $_SESSION['uid'];

  try {
    //On récupère la promotion de l'utilisateur connecté
    $sqlCurrIdProm = "SELECT promotion
                      FROM Utilisateurs U
                      WHERE U.login = :current";
    $reqCurrIdProm = bdd::$pdo->prepare($sqlCurrIdProm);
    $reqCurrIdProm->execute(array('current' => $current_user));
    $currIdProm = $reqCurrIdProm->fetch(PDO::FETCH_ASSOC);
    $idPromo = $currIdProm["promotion"];

    //On récupère maintenant tous les projets actifs qui sont disponibles pour cette promotion
    $sqlProj = "SELECT P.promotion, titre, description, remarques, U.nom AS tuteur, U1.nom AS tuteur_bis, actif, U.promotion, idProjet
                FROM Projets P
                JOIN Utilisateurs U ON P.tuteur = U.login
                LEFT JOIN Utilisateurs U1 ON P.tuteur_bis = U1.login
                WHERE actif = 1 AND P.promotion = :id";
    $reqProj = bdd::$pdo->prepare($sqlProj);
    $reqProj->execute(array('id' => $idPromo));
    $projectList = $reqProj->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($projectList);


  }
  catch(PDOException $e){
    echo json_encode($e);
  }

?>
