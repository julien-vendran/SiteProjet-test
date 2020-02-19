<?php

  session_start();

  require '../../../config/DB.php';

  $return = array(
    'error' => 0
  );

  try {

    $req = bdd::$pdo->prepare("SELECT idClasse FROM Utilisateurs WHERE login = :id");
    $req->execute(array("id" => $_SESSION["uid"]));
    $class = $req->fetch()["idClasse"];

    $req = bdd::$pdo->prepare("UPDATE Utilisateurs SET idClasse = NULL WHERE login = :id");

    $req->execute(array("id" => $_POST["id"]));

  } catch (PDOException $e) {

    $return['error'] = $e->getMessage();

  }

  printf(json_encode($return));

 ?>
