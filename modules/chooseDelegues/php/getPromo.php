<?php

  require '../../../config/DB.php';

  $return = array('error' => 0);

  try {
    $sql = "SELECT idPromo, promotion FROM Utilisateurs";
    $req = bdd::$pdo->query($sql);
    $return['promo'] = $req->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    $return['error'] = $e->getMessage();
  }

  echo json_encode($return);

 ?>
