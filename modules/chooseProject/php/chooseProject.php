<?php
  require '../../../config/DB.php';


  session_start();

  $return = array("error" => 0);

  if(count($_GET) == 5){
    try {
      // Récupération du groupe de l'utilisateur
      $sql = "SELECT loginChef
              FROM `Groupe`
              WHERE loginChef = :cur";
      $query = bdd::$pdo->prepare($sql);

      $data = array("cur" => $_SESSION['uid']);
      $query->execute($data);
      $grp = $query->fetch(PDO::FETCH_ASSOC);

      // Vérification qu'aucun voeux n'existe pour ce groupe
      $select = "SELECT *
                FROM voeux
                WHERE loginChef = :grp";
      $query1 = bdd::$pdo->prepare($select);
      $data = array("grp" => $grp['loginChef']);
      $query1->execute($data);
      $voeux = $query1->fetchAll(PDO::FETCH_ASSOC);
      if($voeux == null){ //Si le groupe n'a aucun voeux
        // Insertion des projets sélectionnés dans les voeux
        $sql2 = "INSERT INTO voeux (loginChef, idProjet, classement)
                VALUES (:grp, :idProjet, :class)";
      }
      else {            //Sinon
        //Mise à jour des voeux du groupe
        $sql2 = "UPDATE voeux SET idProjet = :idProjet
                WHERE loginChef = :grp
                AND classement = :class";
      }
      //Préparation et execution de la requête pour chaque argument
      $query2 = bdd::$pdo->prepare($sql2);
      foreach($_GET as $key => $wish){
        $data = array("grp" => $grp['loginChef'],
                      "idProjet" => $wish,
                      "class" => $key);
        $query2->execute($data);
      }

    }
    catch(PDOException $e){
      $return["error"] = "Erreur bdd: ".$e;
    }
  }
  else {
    $return["error"] = "Vous devez choisir strictement 5 sujets pour enregistrer vos voeux";
  }

  print json_encode($return);
?>
