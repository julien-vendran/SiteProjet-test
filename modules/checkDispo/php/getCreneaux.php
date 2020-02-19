<?php

  require "../../../config/DB.php";

  try {
    //On récupère tout les enseignants ayant renseignés leurs disponibilités
    $sql = "SELECT U.nom AS nom, D.Disponibilites AS dispo
    FROM Disponibilites D
    JOIN Utilisateurs U ON U.login = D.Enseignant";
    $reqT = bdd::$pdo->prepare($sql);
    $reqT->execute();
    $data = $reqT->fetchAll(PDO::FETCH_ASSOC);
    print json_encode($data);
  } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }

 ?>
