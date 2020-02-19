<?php

  require '../config/DB.php';

  try {
    $sql = "SELECT * FROM Classes WHERE nomClasse = 'Enseignants' AND delegue1 IS NOT NULL";
    $req = bdd::$pdo->prepare($sql);
    $req->execute();
    $verif = $req->rowCount();
  } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }

 ?>
