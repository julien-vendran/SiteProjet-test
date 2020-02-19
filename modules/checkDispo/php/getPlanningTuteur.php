<?php

  session_start();

  require "../../../config/DB.php";

  $return = array(
    'error' => 0,
    'disp' => 0,
  );

  $tuteur = $_POST['id'];

  try {
    $sql = "SELECT Disponibilites AS disp FROM Disponibilites WHERE Enseignant = :id";
    $req = bdd::$pdo->prepare($sql);
    $val = array('id' => $tuteur);
    $req->execute($val);
    $disp = $req->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    $return['error'] =  $e->getMessage();
  }

  printf(json_encode($return));

 ?>
