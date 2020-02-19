<?php

  require '../../../config/DB.php';

  $return = array(
    "error" => 0
  );

  // on récupère les données de Ajax
  if(!isset($_POST["id"])) {
    $return["error"] = 1;
    exit();
  } else $id = $_POST["id"];

  try {

    // on supprimer l'évènement dans la base de données
    $req = bdd::$pdo->prepare("DELETE FROM Planning WHERE id = :id");
    $req->execute(array("id" => $id));

  } catch (Exception $e) {

    $return["error"] = $e->getMessage();

  }

  // on renvoie le tableau return
  print json_encode($return);

?>
