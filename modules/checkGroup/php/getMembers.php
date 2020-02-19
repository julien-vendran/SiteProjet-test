<?php

  require "../../../config/DB.php";

  $id = $_POST['id'];
$membres = array();
  try {
    $sql = "SELECT login2,login3,login4,login5,login6 from Groupe where loginChef = :id";
    $req = bdd::$pdo->prepare($sql);
    $val = array('id' => $id);
    $req->execute($val);
    $results = $req->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($results);
    foreach ($results[0] as $clef => $valeur){
      if(!empty($valeur)) {
        $sql_membre = "SELECT nom,prenom FROM Utilisateurs WHERE login = :login ";
        $req_membre = bdd::$pdo->prepare($sql_membre);
        $val_membre = array('login' => $valeur);
        $req_membre->execute($val_membre);
        array_push($membres,$req_membre->fetchAll(PDO::FETCH_ASSOC)[0]);
      }
    }

    printf(json_encode($membres));
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

 ?>
