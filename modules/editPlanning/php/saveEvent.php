<?php

  session_start();

  require '../../../config/DB.php';

  $return = array(
    "error" => 0
  );

  // on récupère les données de Ajax pour les ajouter à la base de données et créer l'évènement
  $day = $_POST["date"]["day"];
  $month = $_POST["date"]["month"];
  $year = $_POST["date"]["year"];

  if($_POST['promo'] != null){
    // on prépare les variables à insérer dans la bdd
    $params = array(
      "date" => $year.'-'.$month.'-'.$day.' 00:00:00',
      "promo" => intval($_POST['promo']),
      "title" => $_POST['title'],
      "desc" => $_POST['desc']
    );
    $sql = "INSERT INTO Planning (Titre, Date, Description, idPromo) VALUES (:title, :date, :desc, :promo)";
  }
  else {
    // on prépare les variables à insérer dans la bdd
    $params = array(
      "date" => $year.'-'.$month.'-'.$day.' 00:00:00',
      "title" => $_POST['title'],
      "desc" => $_POST['desc']
    );
    $sql = "INSERT INTO Planning (Titre, Date, Description) VALUES (:title, :date, :desc)";

  }

  try {

    // on insère l'évènement dans la base de données avec les paramètres récupérés
    $req = bdd::$pdo->prepare($sql);
    $req->execute($params);

  } catch (Exception $e) {

    $return["error"] = $e->getMessage();

  }

  // on renvoie le tableau return
  print json_encode($return);

?>
