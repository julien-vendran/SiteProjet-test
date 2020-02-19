<?php

  require '../../../config/DB.php';

  $return = array('error' => 0);
  $save = array();

  try {
    //On récupère le nombre de groupe de projet
    $sql = "SELECT idGroupe FROM GroupeProjet";
    $req = bdd::$pdo->prepare($sql);
    $req->execute();
    $nbGroupe = $req->rowCount();
    //On récupère tous les ID des groupes de projet
    $idGp = $req->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    $return['error'] = $e->getMessage();
  }

  //Pour chaque groupe, on récupère les informations nécessaires
  for ($g=0; $g < $nbGroupe; $g++) {
    try {
      //On récupère les membres du groupe
      $sql = "SELECT nom, prenom
              FROM Utilisateurs U
              JOIN GroupeProjet GP ON GP.idGroupe = U.idGroupe
              WHERE GP.idGroupe = :id";
      $req = bdd::$pdo->prepare($sql);
      $val = array('id' => $idGp[$g]['idGroupe']);
      $req->execute($val);
      $temp = $req->fetchAll(PDO::FETCH_ASSOC);
      $membres = array();
      for ($m=0; $m < $req->rowCount(); $m++) {
        array_push($membres, $temp[$m]['nom'] . " " . $temp[$m]['prenom']);
      }

      //On récupère ensuite les informations du projet associé au groupe
      $sql = "SELECT titre, description, remarques, nom, prenom, promotion
              FROM Projets P
              JOIN Utilisateurs U ON U.login = P.tuteur
              JOIN GroupeProjet GP ON GP.idProjet = P.idProjet
              WHERE GP.idGroupe = :id";
      $req = bdd::$pdo->prepare($sql);
      $req->execute($val);
      $infos = $req->fetchAll(PDO::FETCH_ASSOC);

      //On créer maintenant un tableau contenant les informations du projet
      $groupe = array(
        'membres' => $membres,
        'titre' => $infos[0]['titre'],
        'description' => $infos[0]['description'],
        'remarques' => $infos[0]['remarques'],
        'tuteur' => $infos[0]['nom'] . " " . $infos[0]['prenom'],
        'niveau' => $infos[0]['niveau']);
      //On ajoute le groupe aux autres groupes déjà créés
      $save[] = $groupe;
    } catch (PDOException $e) {
      $return['error'] = $e->getMessage();
    }
  }

  $return['groupes'] = $save;
  printf(json_encode($return));

 ?>
