<?php

  require '../../config/DB.php';

  $return = array('error' => 0);

  // On récupère les données du script SQL pour générer les tables de la base de données
  $sql = file_get_contents("script_generation.sql");

  try {
    // On exécute le script qui génère les pages
    bdd::$pdo->query($sql);

    // On créer la table Enseignant (environnement des tuteurs/admin)
    $sql = "INSERT INTO Classes (nomClasse) VALUES ('Enseignants')";
    bdd::$pdo->query($sql);
    $idClasse = bdd::$pdo->lastInsertId();

    //On créer l'utilisateur pour l'admin
    $sql = "INSERT INTO Utilisateurs (login, nom, prenom, idClasse) VALUES (:login, :nom, :prenom, :classe)";
    // On prépare les données pour la requête
    $val = array(
      'login' => $_POST['login'],
      'nom' => $_POST['nom'],
      'prenom' => $_POST['prenom'],
      'classe' => $idClasse);
    // On exécute la requête
    $req = bdd::$pdo->prepare($sql);
    $req->execute($val);

    // On met l'utilisateur nouvellement créer comme administrateur
    $sql = "UPDATE Classes SET delegue1 = :login WHERE idClasse = :id";
    $req = bdd::$pdo->prepare($sql);
    $val = array(
      'login' => $_POST['login'],
      'id' => $idClasse);
    $req->execute($val);
  } catch (PDOException $e) {
    $return['error'] = $e->getMessage();
  }

  printf(json_encode($return));

 ?>
