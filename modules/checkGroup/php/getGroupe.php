<?php

  require "../../../config/DB.php";

  try {
      $sql = "SELECT DISTINCT g.loginChef AS idGroupe, P.titre, P.description, U.nom, U.prenom  FROM Groupe g LEFT JOIN Projets P ON g.idProjet = P.idProjet JOIN Utilisateurs U ON U.login = g.loginChef WHERE g.actif=1 ORDER BY U.classe";
    $req = bdd::$pdo->prepare($sql);
    $req->execute();
    $groupes = $req->fetchAll(PDO::FETCH_ASSOC);
    printf(json_encode($groupes));
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

 ?>
