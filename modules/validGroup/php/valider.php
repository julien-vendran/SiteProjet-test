<?php

session_start();

require '../../../config/DB.php';

$return = array(
    "error" => 0,
    "reponse" => ""
);

$current_user = $_SESSION['uid'];

    //requete pour recuerer tous les logins du groupe
    $sql = "SELECT loginChef,login2,login3,login4,login5,login6 
    FROM Groupe
    WHERE loginChef = :login 
    OR login2 = :login 
    OR login3 = :login 
    OR login4 = :login 
    OR login5 = :login 
    OR login6 = :login";
    $req = bdd::$pdo->prepare($sql);
    $val = array('login' => $current_user);
    $req->execute($val);
    $membres = $req->fetchAll(PDO::FETCH_ASSOC);

    //recuperation des nom et prenom des users du groupe a partir des logins
    foreach ($membres[0] as $value) {
      if ($value != NULL) {
        $sql="SELECT prenom, nom FROM Utilisateurs WHERE login='".$value."'";
        $rep = bdd::$pdo->query($sql);
        $result = $rep->fetchAll();
        $tab[$value]= $result;
      }
    }

    //recuperation du validGroupe de l'user
    $sql="SELECT validGroup FROM Utilisateurs WHERE login='".$current_user."'";
    $rep = bdd::$pdo->query($sql);
    $nonce2 = $rep->fetchAll();
    $nonce=$nonce2[0]["validGroup"];
 
    //recuperer tous les prenom et nom du groupe et les mettres en list
    $personne="<ul>";
    foreach ($membres[0] as $value) {
      if ($value != NULL) {
       $personne=$personne."<li>".$tab[$value][0]["prenom"]." ".$tab[$value][0]["nom"]."</li>"; 
      }
    }
    $personne=$personne."</ul>";
  
    //creation de l'affichage avec les membres du groupe et les liens pour valider ou refuser
    $reponse = "Vous avez été attribué dans un groupe de projet avec les membres suivant: ".$personne."<br> <a href='../newGroupEtud/php/reponse.php?accept=oui&login=".$current_user."&validGroup=".$nonce."'>Accepter</a>  <a href='../newGroupEtud/php/reponse.php?accept=non&login=".$current_user."&validGroup=".$nonce."'>Refuser</a>";

    $return['reponse']=$reponse;

    print json_encode($return);

?>
