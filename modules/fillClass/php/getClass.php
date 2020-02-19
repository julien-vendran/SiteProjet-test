<?php

  session_start();

  require '../../../config/DB.php';

  $return = array(
    'error' => 0,
    'name' => "",
    'id' => "",
    'class' => "",
    'debug' => ""
  );

  try {

    $req = bdd::$pdo->prepare("SELECT U.idClasse as id FROM Utilisateurs U WHERE U.login = :id");
    $req->execute(array("id" => $_SESSION["uid"]));
    $class = $req->fetch();

    $req = bdd::$pdo->prepare("SELECT U.login as userid, U.nom as lastname, U.prenom as firstname FROM Utilisateurs U WHERE U.idClasse = :class AND U.login != :id");
    $req->execute(array("class" => $class["id"], "id" => $_SESSION["uid"]));
    $res = $req->fetchAll(PDO::FETCH_ASSOC);

    $return['name'] = $class['name'];
    $return['id'] = $class['id'];

    foreach ($res as $key => $value) {
      $return["class"][] = $value;
    }

  } catch (PDOException $e) {

    $return['error'] = $e->getMessage();

  }

  printf(json_encode($return));

 ?>
