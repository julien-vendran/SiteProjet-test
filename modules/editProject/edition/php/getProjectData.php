<?php

  require '../../../../config/DB.php';

  session_start();

  $idProjet = $_POST['id'];

  $return = array(
    'error' => 0,
    'projet' => '');

  try {
    // On récupère les informations
    $sql = "SELECT * FROM Projets WHERE idProjet = :id AND (tuteur = :uid OR tuteur_bis = :uid)";
    $req = bdd::$pdo->prepare($sql);
    $val = array('id' => $idProjet, 'uid' => $_SESSION['uid']);
    $req->execute($val);
    $temp = $req->fetchAll(PDO::FETCH_ASSOC);
    $return['projet'] = $temp[0];
  } catch (PDOException $e) {
    $return['error'] = $e->getMessage();
  }

  printf(json_encode($return));

?>
