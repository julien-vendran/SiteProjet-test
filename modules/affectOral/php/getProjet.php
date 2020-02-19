<?php

  require "../../../config/DB.php";

  try {
    $sql = "SELECT G.idGroupe AS groupe, P.titre AS titre, P.tuteur AS tuteur, P.tuteur_bis AS tuteurBis, dateSoutenance
            FROM GroupeProjet G
            JOIN Projets P ON P.idProjet = G.idProjet";
    $req = bdd::$pdo->query($sql);
    $data = $req->fetchAll(PDO::FETCH_ASSOC);
    print json_encode($data);
  } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }

 ?>
