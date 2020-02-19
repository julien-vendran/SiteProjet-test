<?php

  session_start();

  require_once "../../../config/DB.php";

  $disponibilites = $_POST['disponibilites'];
  $id = $_SESSION['uid'];

  try {
    // On supprime les anciennes données
    $sql = "DELETE FROM Disponibilites WHERE Enseignant = :uid";
    $req = bdd::$pdo->prepare($sql);
    $val = array('uid' => $id);
    $req->execute($val);

    // On ajoute les nouvelles données
    $sql = "INSERT INTO Disponibilites VALUES (:uid, :disp)";
    $req = bdd::$pdo->prepare($sql);
    $val = array(
      'uid' => $id,
      'disp' => $disponibilites);
    $req->execute($val);
    print json_encode("succès");
  } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }

 ?>
