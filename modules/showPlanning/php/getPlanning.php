<?php

  session_start();

  require '../../../config/DB.php';

  $return = array(
    'error' => 0,
    'planning' => ""
  );

  $planning = array();

  try {
    if(date("m") >= 9) $year = intval(date("Y"));
    else $year = intval(date("Y") - 1);

    $query = "SELECT Pl.id, Pl.Titre, Pl.Description, date_format(Pl.Date, '%U') as timestmp, date_format(Pl.Date, '%i') as mn, date_format(Pl.Date, '%H') as h, date_format(Pl.Date, '%d') as day, date_format(Pl.Date, '%w') as w, date_format(Pl.Date, '%m') as month, date_format(Pl.Date, '%Y') as year
              FROM Planning Pl,Utilisateurs Ut
              WHERE ((date_format(Pl.Date, '%m') > 8 AND date_format(Pl.Date, '%Y') = :year) OR (date_format(Pl.Date, '%m') < 9) AND date_format(Pl.Date, '%Y') = :year + 1) AND ((Pl.idPromo = Ut.idPromo AND Ut.idPromo = Ut.idPromo AND Ut.login = :login) OR (Pl.idPromo IS NULL))
              GROUP BY id
              ORDER BY day";

    $req = bdd::$pdo->prepare($query);
    $data = array("year" => $year, "login" => $_SESSION["uid"]);

    if(isset($_GET) && $_GET['user'] != null){
     $data['login'] = $_GET['user'];
    }
    $req->execute($data);


    $i = 0;
    while( $res = $req->fetch(PDO::FETCH_ASSOC) ) {
      $planning[$i] = array();

      $planning[$i]["id"] = $res["id"];
      $planning[$i]["title"] = $res["Titre"];
      $planning[$i]["desc"] = $res["Description"];
      $planning[$i]["timestamp"] = utf8_encode($res['timestmp']);
      $planning[$i]["date"] = array();
      $planning[$i]["date"]["y"] = utf8_encode($res["year"]);
      $planning[$i]["date"]["m"] = utf8_encode($res["month"]);
      $planning[$i]["date"]["d"] = utf8_encode($res["day"]);
      $planning[$i]["date"]["h"] = utf8_encode($res["h"]);
      $planning[$i]["date"]["mn"] = utf8_encode($res["mn"]);
      $planning[$i]["date"]["w"] = utf8_encode($res["w"]);

      $i++;
    }
  } catch (PDOException $e) {
    $return['error'] = 1;
  }

  // on récupère la date et l'horraire de la soutenance, pour l'ajouter au planning
  try {

    $req = bdd::$pdo->prepare("SELECT dateSoutenance FROM GroupeProjet GP JOIN Utilisateurs U ON U.idGroupe = GP.idGroupe WHERE login = :uid");
    $data2 = array('uid' => $_SESSION['uid']);

    if(isset($_GET) && $_GET['user'] != null){
     $data2['uid'] = $_GET['user'];
    }

    $req->execute($data2);
    $tmp = $req->fetch(PDO::FETCH_ASSOC); // date de la soutenance

  } catch (PDOException $e) {

    $return['error'] = 2;

  }

  if(!empty($planning)) $return["planning"] = $planning;

  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    print json_encode($return);
  }


 ?>
