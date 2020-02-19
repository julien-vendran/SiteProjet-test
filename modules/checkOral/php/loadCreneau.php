<?php

  session_start();

  require '../../../config/DB.php';

  $return = array(
    'error' => 0,
    'horaire' => "");

  // On exécute une requête pour récupéré l'horaire de la soutenance du groupe de l'utilisateur connecté
  try {
    $sql = "SELECT dateSoutenance FROM GroupeProjet GP JOIN Utilisateurs U ON U.idGroupe = GP.idGroupe WHERE login = :uid";
    $req = bdd::$pdo->prepare($sql);
    $val = array('uid' => $_SESSION['uid']);
    $req->execute($val);
    $temp = $req->fetch(PDO::FETCH_ASSOC);
    $return['horaire'] = $temp['dateSoutenance'];
  } catch (PDOException $e) {
    $return['error'] = $e->getMessage();
  }

  printf(json_encode($return));

 ?>
