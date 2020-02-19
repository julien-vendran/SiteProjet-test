<?php

  session_start();

  require '../../../config/DB.php';

  $return = array("error" => 0);
  $data = array("cur" => $_SESSION['uid']);

  try {
    // Récupération du groupe
    $sql = "SELECT loginChef FROM `Groupe` 
    WHERE loginChef = :cur 
    OR login2 = :cur 
    OR login3 = :cur 
    OR login4 = :cur 
    OR login5 = :cur 
    OR login6 = :cur";
    $query = bdd::$pdo->prepare($sql);
    $query->execute($data);
    $grp = $query->fetch(PDO::FETCH_ASSOC);
    // Récupération des projets
    $data = array("idGroupe" => $grp['loginChef']);
    $sql2 = "SELECT P.*
            FROM Projets P
            JOIN voeux V ON P.idProjet = V.idProjet
            WHERE V.loginChef = :idGroupe";
    $query2 = bdd::$pdo->prepare($sql2);
    $query2->execute($data);
    $wishes = $query2->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($wishes);   //On retourne les voeux
  }
  catch(PDOException $e){
    $return['error'] = "Erreur bdd: ".$e;
    echo json_encode($return);
  }


?>
