<?php

  session_start();

  require '../config/DB.php';

  $return = array(
    'error' => 0,
    'planning' => ""
  );

  $planning = array();

  try {
    if(date("m") >= 9) $year = intval(date("Y"));
    else $year = intval(date("Y") - 1);

    $query = "SELECT Pl.id, Pl.Titre, Pl.Description, date_format(Pl.Date, '%i') as mn, date_format(Pl.Date, '%H') as h, date_format(Pl.Date, '%d') as day, date_format(Pl.Date, '%w') as w, date_format(Pl.Date, '%m') as month, date_format(Pl.Date, '%Y') as year
              FROM Planning Pl, Promotions Pr, Classes Cl, Utilisateurs Ut
              WHERE ((date_format(Pl.Date, '%m') > 8 AND date_format(Pl.Date, '%Y') = :year) OR (date_format(Pl.Date, '%m') < 9) AND date_format(Pl.Date, '%Y') = :year + 1) AND ((Pl.idPromo = Pr.idPromo AND Pr.idPromo = Cl.idPromo AND Cl.idClasse = Ut.idClasse AND Ut.login = :login) OR (Pl.idPromo IS NULL)) AND (Pl.Date >= CURRENT_TIMESTAMP)
              GROUP BY id
              ORDER BY Pl.Date
              LIMIT 0,1";

    $req = bdd::$pdo->prepare($query);
    $req->execute(array("year" => $year, "login" => $_SESSION["uid"]));

    $i = 0;
    while( $res = $req->fetch(PDO::FETCH_ASSOC) ) {
      $planning[$i] = array();

      $planning[$i]["id"] = $res["id"];
      $planning[$i]["title"] = $res["Titre"];
      $planning[$i]["desc"] = $res["Description"];
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

  if(!empty($planning)) $return["planning"] = $planning;

  print json_encode($return);

 ?>
