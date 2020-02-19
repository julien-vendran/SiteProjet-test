<?php

  require '../../../config/DB.php';

  $return = array(
    'error' => 0,
    'event' => ""
  );

  $event = array();

  if(!isset($_POST["id"]) || intval($_POST["id"]) == undefined) {
    $return["error"] = 1;
    exit();
  } else $id = intval($_POST["id"]);

  try {

    $query = "SELECT id, idPromo, Titre as title, Description as description, date_format(Date, '%i') as mn, date_format(Date, '%H') as h, date_format(Date, '%d') as day, date_format(Date, '%w') as w, date_format(Date, '%m') as month, date_format(Date, '%Y') as year
              FROM Planning
              WHERE id = :id";

    $req = bdd::$pdo->prepare($query);
    $req->execute(array("id" => $id));

    $return["event"] = $req->fetch();

  } catch (PDOException $e) {

    $return["error"] = 2;

  }

  print json_encode($return);

 ?>
