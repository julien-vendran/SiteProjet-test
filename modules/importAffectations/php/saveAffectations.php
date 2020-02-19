<?php

  // on récupère la connexion à la base de données
  require '../../../config/DB.php';

  require 'convertAffectations.php';

  // on génère le tableau qui sera renvoyé en json
  $return = array(
    "error" => 0
  );

  // on prépare le tableau des id des groupes dont on doit importer l'affectation
  if(!isset($_POST["save"]) || empty($_POST["save"])) exit(1);
  else $save = $_POST["save"];
  $save = explode(",", $save);
  
  // on récupère le fichier qui contiens les affectations et on le converti en tableau php
  if(isset($_POST["file"]) && !empty($_POST["file"])) {
    if($handle = fopen("../../../tmp/" . $_POST["file"], "r")) {
      $affectations = convertAffectations($handle);

      fclose($handle);
    }
  }

  $result = array();

  foreach ($affectations as $key => $value) {
    if(in_array($value["group"], $save)) $result[] = $value;
  }

  // on parcours le tableau des affectations demandées
  foreach ($result as $id => $value) {
    try {
      $req = bdd::$pdo->prepare("UPDATE Groupe SET idProjet = :idProjet, anneeAffectation=NOW() WHERE loginChef = :idGroupe");
      $req->execute(array(
        "idProjet" => $value["project"],
        "idGroupe" => $value["group"]
      ));

    } catch (Exception $e) {
        echo $e;
    }
  }
  
  echo json_encode($return);

?>
