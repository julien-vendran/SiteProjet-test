<?php

  session_start();

  require '../../../config/DB.php';

  $return = array(
    'error' => 0,
    'users' => ""
  );

  $users = array();

  try {
    
    $req = bdd::$pdo->query("SELECT login, nom, prenom 
                             FROM Utilisateurs 
                             WHERE idClasse IS NULL AND (login LIKE '%".$_POST["query"]."%' OR nom LIKE '%".$_POST["query"]."%' OR prenom LIKE '%".$_POST["query"]."%')");

    $i = 0;
    while( $res = $req->fetch(PDO::FETCH_ASSOC) ) {
      $users[$i] = array();

      $users[$i]["userid"] = utf8_encode($res["login"]);
      $users[$i]["firstname"] = utf8_encode($res["prenom"]);
      $users[$i]["lastname"] = utf8_encode($res["nom"]);

      $i++;
    }

  } catch (PDOException $e) {

    $return['error'] = $e->getMessage();

  }

  if(!empty($users)) $return["users"] = $users;

  print json_encode($return);

 ?>
