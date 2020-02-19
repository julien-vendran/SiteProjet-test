<?php

  require '../../../../config/DB.php';

  session_start();

  $return = array('error' => 0);
  $idProjet = $_POST['id'];
  try {
    // On récupère avant tout toutes les promotions
    $sql = 'SELECT DISTINCT promotion FROM Utilisateurs WHERE promotion != \'Enseignant\' ';
    $req = bdd::$pdo->prepare($sql);
    $req->execute();
    $return['promotion'] = $req->fetchAll(PDO::FETCH_ASSOC);

    // On récupère ensuite les tuteurs
    $sql = "SELECT login, nom FROM Utilisateurs U WHERE promotion = 'Enseignant' ";
    $req = bdd::$pdo->prepare($sql);
    $val = array('uid' => $_SESSION['uid']);
    $req->execute($val);
    $return['tuteurs'] = $req->fetchAll(PDO::FETCH_ASSOC);

    //nous allons maintenant prendre les spécifications de chaques projets.
    $sql = "SELECT `BaseDeDonnees` AS project_bd,`SiteDynamique` AS project_site,`InterfaceGraphique` AS project_interface,`AlgoAvance` AS project_algo,`Reseaux` AS project_reseaux FROM `Projets` WHERE idProjet =:id";
    $req = bdd::$pdo->prepare($sql);
    $val = array('id' => $idProjet);
    $req->execute($val);
    $tab = $req->fetchAll(PDO::FETCH_ASSOC);
    foreach ($tab as $val) {
      $return['specification'] = $val;
    }

  } catch (PDOException $e) {
    $return['error'] = $e->getMessage();
  }

  printf(json_encode($return));

 ?>
