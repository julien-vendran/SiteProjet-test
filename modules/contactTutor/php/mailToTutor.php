<?php

session_start();

require '../../../config/DB.php';

$return = array(
  "error" => 0
);


$current_user = $_SESSION['uid'];


/* on récupère le nom et prénom de son tuteur pour envoyer le mail */
$sqlTut = "SELECT nom, prenom 
      FROM Utilisateurs
      WHERE login=(SELECT p.tuteur 
                  FROM Projets p 
                  WHERE idProjet IN
                    (SELECT idProjet
                    FROM Groupe
                    WHERE loginChef=:current OR login2=:current OR login3=:current OR login4=:current OR login5=:current OR login6=:current))";
$reqTut = bdd::$pdo->prepare($sqlTut);
$valeurs = array('current' => $current_user);
$reqTut->execute($valeurs);
$tuteur = $reqTut->fetch(PDO::FETCH_ASSOC);

if(empty($tuteur['prenom']) || empty($tuteur['prenom']))
  $return["error"] = 1;
else {
  $mail = $tuteur['prenom'] . "." . $tuteur['nom'] . "@umontpellier.fr";
  $objet = $_POST['mail_object'];
  $message = $_POST['mail_content'];
  mail($mail,$objet,$message);
}

print json_encode($return);

?>
