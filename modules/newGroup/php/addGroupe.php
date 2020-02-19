<?php
  require '../../../config/DB.php';

  $return = array("error" => 0);

  //On crée un tableau contenant les membres du groupe selon l'effectif du groupe
  switch (count($_GET)){
    case 3:
      $membres = array (0 => $_GET['chefGroupe'], $_GET['membre0'], $_GET['membre1']);

    case 4:
      $membres = array (0 => $_GET['chefGroupe'], $_GET['membre0'], $_GET['membre1'], $_GET['membre2']);

    case 5:
      $membres = array (0 => $_GET['chefGroupe'], $_GET['membre0'], $_GET['membre1'], $_GET['membre2'], $_GET['membre3']);
  }


  //On vérifie que le tableau entré en paramètres a entre 3 et 5 éléments
  if(count($membres) >= 3 && count($membres) < 6){
    try {
      //On écrit la requête mysql pour insérer une nouvelle ligne dans la table groupe
      $sql = "INSERT INTO GroupeProjet (`chefGroupe`)
              VALUES (:chefGroupe)";

      //On prépare la requête
      $query = bdd::$pdo->prepare($sql);
      //On définit la valeur du chef du groupe
      $val = array ("chefGroupe" => $membres[0]);
      //On execute la requête avec cette valeur
      $query->execute($val);

      //On écrit une requête pour récupérer l'ID du groupe créé (id auto-incrémenté)
      $sqlid = "SELECT idGroupe
                FROM GroupeProjet
                WHERE chefGroupe = :chefGroupe";
      //On execute et récupère dans un tableau
      $query2 = bdd::$pdo->prepare($sqlid);
      $query2->execute($val);
      $idGroupe = $query2->fetch(PDO::FETCH_ASSOC);

      //On écrit une requête pour attribuer chaque utilisateur à ce groupe en modifiant leur attribut idGroupe
      $update = "UPDATE Utilisateurs
                SET idGroupe = :idGroupe
                WHERE login = :membre";
      $query_update = bdd::$pdo->prepare($update);

      //Pour chaque membre du groupe, on execute la requête préparée avec les bonnes valeurs
      foreach ($membres as $log_membre){
        $login = array ("idGroupe" => $idGroupe['idGroupe'],
                        "membre" => $log_membre);
        $query_update->execute($login);
      }

    }
    //On récupère et affiche le message d'erreur en cas d'exception
    catch(PDOException $e){
      $return['error'] = "Erreur de base de données.";
      die();
    }
  }
  else {
    $return['error'] = "Pour créer un groupe de projet, il faut entre 3 et 5 membres.";
  }

  print json_encode($return);


?>
