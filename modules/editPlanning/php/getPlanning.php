<?php

  require '../../../config/DB.php';

  $return = array(
    'error' => 0,
    'planning' => ""
  );

  $planning = array();

  try {
    if(date("m") >= 9) $year = intval(date("Y"));
    else $year = intval(date("Y") - 1);

    $query = "SELECT id, idPromo, Titre, Description, date_format(Date, '%i') as mn, date_format(Date, '%H') as h, date_format(Date, '%d') as day, date_format(Date, '%w') as w, date_format(Date, '%m') as month, date_format(Date, '%Y') as year
              FROM Planning
              WHERE (date_format(Date, '%m') > 8 AND date_format(Date, '%Y') = :year) OR (date_format(Date, '%m') < 9 AND date_format(Date, '%Y') = :year + 1)
              ORDER BY day";

    $req = bdd::$pdo->prepare($query);
    $req->execute(array("year" => $year));

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

      if($res["idPromo"] == 0)
        $planning[$i]["name"] = "toute les promotions";
      else {
        $req2 = bdd::$pdo->prepare("SELECT promotion as name FROM Utilisateurs WHERE idPromo = :id");
        $req2->execute(array("id" => $res["idPromo"]));
        $res2 = $req2->fetch();

        $planning[$i]["name"] = "les " . $res2["name"];
      }

      $i++;
    }
  } catch (PDOException $e) {
    $return['error'] = 1;
  }

  if(!empty($planning)) $return["planning"] = $planning;

  print json_encode($return);

 ?>
