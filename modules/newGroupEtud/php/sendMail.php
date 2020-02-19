<?php
  require '../../../config/DB.php';

  $return = array("error" => 0);

  $envoi=true;
  //On crée un tableau contenant les membres du groupe selon l'effectif du groupe
  switch (count($_GET)){
    case 3:
      $membres = array (0 => $_GET['chefGroupe'], $_GET['membre0'], $_GET['membre1']);
      break;
    case 4:
      $membres = array (0 => $_GET['chefGroupe'], $_GET['membre0'], $_GET['membre1'], $_GET['membre2']);
      break;
    case 5:
      $membres = array (0 => $_GET['chefGroupe'], $_GET['membre0'], $_GET['membre1'], $_GET['membre2'], $_GET['membre3']);
      break;
    case 6:
      $membres = array (0 => $_GET['chefGroupe'], $_GET['membre0'], $_GET['membre1'], $_GET['membre2'], $_GET['membre3'], $_GET['membre4']);
      break;
  }

  //recupere les nom et prenom du groupe
  foreach ($membres as $value) {
    $sql="SELECT prenom, nom FROM Utilisateurs WHERE login='".$value."'";
    $rep = bdd::$pdo->query($sql);
    $result = $rep->fetchAll();
    $tab[$value]= $result;
  }

  //on creer la liste des users dans le groupe
  $personne="";
  foreach ($membres as $value) {
    $personne=$personne." ".$tab[$value][0]["prenom"]." ".$tab[$value][0]["nom"].",";
  }
  $personne=rtrim($personne,",");

  foreach ($membres as $value) {
      // Generate a 32 digits hexadecimal number
      $numbytes = 16; // Because 32 digits hexadecimal = 16 bytes
      $bytes = openssl_random_pseudo_bytes($numbytes); 
      $hex   = bin2hex($bytes);

      //on insere le validGroupe dans l'user
      $sql = "UPDATE Utilisateurs SET validGroup='".$hex."' WHERE login='".$value."'";
      bdd::$pdo->query($sql);

      $subject="creation groupe projet";
      $message="Bonjour ".$tab[$value][0]["prenom"]."<br>"."Vous avez été attribué dans un groupe de projet avec les membres suivant: ".$personne.".<br> Veuillez accepter ou refuser la demande en cliquant sur un des lien suivants: <a href='http://webinfo.iutmontp.univ-montp2.fr/~projets/modules/newGroupEtud/php/reponse.php?accept=oui&login=".$value."&validGroup=".$hex."'>Accepter</a>  <a href='http://webinfo.iutmontp.univ-montp2.fr/~projets/modules/newGroupEtud/php/reponse.php?accept=non&login=".$value."&validGroup=".$hex."'>Refuser</a>";
      $email=$tab[$value][0]["prenom"].".".$tab[$value][0]["nom"]."@yopmail.com";
      //$email="bob@yopmail.com";
      mail($email,$subject,$message);
    }


  echo json_encode($return);

