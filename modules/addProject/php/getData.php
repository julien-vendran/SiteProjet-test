<?php

  require '../../../config/DB.php';

  session_start();

  $retour = array();

  try {
    $sqlProm = 'SELECT DISTINCT promotion FROM Utilisateurs WHERE promotion != \'Enseignant\' ';
    $reqProm = bdd::$pdo->prepare($sqlProm);
    $reqProm->execute();
    $retour["promotion"] = $reqProm->fetchAll(PDO::FETCH_ASSOC);

    $sqlTut = "SELECT login, nom FROM Utilisateurs U WHERE promotion = 'Enseignant' AND login != :current ";
    $reqTut = bdd::$pdo->prepare($sqlTut);
    $valTut = array('current' => $_SESSION['uid']);
    $reqTut->execute($valTut);
    $retour['tuteurs'] = $reqTut->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }

  printf(json_encode($retour));

?>
