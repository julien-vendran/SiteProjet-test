<?php

  session_start();

  require "../../../config/DB.php";

  $return = array(
    'error' => 0,
    'tuteurs' => "");

  try {
    $sql = "SELECT login, nom, prenom FROM Utilisateurs U WHERE U.login != :id AND idClasse = 'Enseignants'";
    $req = bdd::$pdo->prepare($sql);
    $val = array('id' => $_SESSION['uid']);
    $req->execute($val);
    $return['tuteurs'] = $req->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    $return['error'] = $e->getMessage();
  }

  printf(json_encode($return));

 ?>
