<?php
  require '../../../config/DB.php';

  $return = array("error" => 0);

  //On crée un tableau contenant les membres du groupe selon l'effectif du groupe
  switch (count($_GET)){
    case 3:
      $membres = array (0 => $_GET['chefGroupe'], $_GET['membre0'], $_GET['membre1']);
      break;
    case 4:
      $membres = array (0 => $_GET['chefGroupe'], $_GET['membre0'], $_GET['membre1'], $_GET['membre2']);
      break;
    case 5:
      $membres = array (0 => $_GET['chefGroupe'], $_GET['membre0'], $_GET['membre1'], $_GET['membre2'], $_GET['membre3']);
      break;
    case 6:
      $membres = array (0 => $_GET['chefGroupe'], $_GET['membre0'], $_GET['membre1'], $_GET['membre2'], $_GET['membre3'], $_GET['membre4']);
      break;
    default:
      $membres= array();
  }

  //On vérifie que le tableau entré en paramètres a entre 3 et 6 éléments
  if(count($membres) >= 3 && count($membres) < 7){
    try {
      $entete="loginChef";
      $login="'".$membres[0]."'";
      $compteur=1;
      while ($compteur<count($membres)){
        $compteur++;
        $entete=$entete.",login".$compteur;
        $login=$login.",'".$membres[$compteur-1]."'";
      }
      //On écrit la requête mysql pour insérer une nouvelle ligne dans la table groupe
      $sql = "INSERT INTO Groupe (".$entete.")
              VALUES (".$login.")";
              //var_dump($sql);
      //On execute la requête
      bdd::$pdo->query($sql);

    }
    //On récupère et affiche le message d'erreur en cas d'exception
    catch(PDOException $e){
      $return['error'] = "Erreur de base de données.";
      die();
    }
  }
  else {
    $return['error'] = "Pour creer un groupe de projet, il faut entre 3 et 6 membres.";
  }

  echo json_encode($return);

