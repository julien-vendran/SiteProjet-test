<?php

  session_start();

  require '../../../config/DB.php';

  $return = array('error' => 0);

  $id = $_POST['idProjet'];

  try {
    // On vérifie encore que le tuteur qui supprime le projet est celui qui l'a créé
    $sql = "DELETE FROM Projets WHERE tuteur = :uid AND idProjet = :id";
    $req = bdd::$pdo->prepare($sql);
    $val = array('uid' => $_SESSION['uid'], 'id' => $id);
    $req->execute($val);
  } catch (PDOException $e) {
    $return['error'] = $e->getMessage();
  }

  printf(json_encode($return));

 ?>
