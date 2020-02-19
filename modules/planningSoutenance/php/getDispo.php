<?php

  session_start();

  require "../../../config/DB.php";

  $tuteur = $_SESSION['uid'];

  try {
    $sql = "SELECT Disponibilites AS disp FROM Disponibilites WHERE Enseignant = :id";
    $req = bdd::$pdo->prepare($sql);
    $val = array('id' => $tuteur);
    $req->execute($val);
    $disp = $req->fetchAll(PDO::FETCH_ASSOC);
    $count = $req->rowCount();
  } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }

  if ( $count != 0 ) {
    print json_encode($disp);
  }
  else {
    print 0;
  }


 ?>
