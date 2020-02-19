<?php

  require "../../../config/DB.php";

  $return = array(
    'error' => 0,
    'result' => "");

  // On récupère les données pour créer le datetime
  $annee = $_POST['year'];
  $mois = ( $_POST['month'] > 9 ) ? $_POST['month'] : "0" . $_POST['month'];
  $jour = $_POST['day'];
  $heure = $_POST['heure'];

  // On récupère l'identifiant du groupe concerné
  $idGroupe = $_POST['id'];

  // On vérifie si l'année est définie
  if ( $_POST['year'] !== 'undefined') {
    // On génère le datetime
    $buffer = "$annee-$mois-$jour $heure:00:00";
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $buffer);
    $datetime = $date->format('Y-m-d H:i:s');
    $sql = "UPDATE GroupeProjet SET dateSoutenance = :d WHERE idGroupe = :id";
    $val = array('d' => $datetime, 'id' => $idGroupe);
  } else {
    // Si ce n'est pas le cas, alors c'est que l'on annule la soutenance
    $sql = "UPDATE GroupeProjet SET dateSoutenance = NULL WHERE idGroupe = :id";
    $val = array('id' => $idGroupe);
  }

  $return['result'] = $datetime;

  try {
    $req = bdd::$pdo->prepare($sql);
    $req->execute($val);
  } catch (PDOException $e) {
    $return['error'] = $e->getMessage();
  }

  printf(json_encode($return));

 ?>
