<?php

  session_start();

  require '../../../config/DB.php';

  //on recupere les donnes de l'user connecté
  try {
    $sql = "SELECT u2.login, u2.nom, u2.prenom 
            FROM Utilisateurs u2
            WHERE u2.login = :login";
    $query = bdd::$pdo->prepare($sql);
    $val = array("login" => $_SESSION['uid']);
    $query->execute($val);
    $grpTD = $query->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($grpTD);

  }
  catch(Exception $e){
    echo json_encode($e);
  }

?>
