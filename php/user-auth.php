<?php

/*

FICHIER user-auth.php
utilisation: variables $_POST['session'] avec l'id d'une session PHP existante
connecte l'utilisateur et rempli les varibales de session nécessaires

renvoie en json l'erreur associée à la connexion
si aucune erreur se produit (error 0) ...

*/

session_start();

require_once "../config/DB.php";

// on défini le tableau qui sera retourné en json
// par défaut, pas d'erreur
$return = array(
    "error" => 0,
    "level" => array()
);

// on effectue les requetes dans la BDD pour connecter l'utilisateur ...

// niveau de l'utilisateur : 0 = etudiant , 1 = chef de groupe, 2 = license, 3 = enseignant, 4 = admin
//$_SESSION["level"] = $_POST["level"];
$niveau = isset($_POST["usertype"]) ? intval($_POST["usertype"]) : -1; //a remettre à la fin du projet
//$niveau=0;//pour le developpement
$requetes = array(
    'etudiant' => array(/*etudiant*/
        'chefProjet' => "SELECT * FROM Groupe G WHERE G.loginChef = :log",/*chef de groupe*/
        'license' => "SELECT * FROM Utilisateurs U WHERE U.promotion='Licence' AND U.login = :log"/*license*/
    ),
    'enseignant' => "SELECT * FROM Utilisateurs U WHERE (U.promotion = 'Enseignant' OR U.promotion='Personnel') AND U.login = :log");

//requete not group
/*SELECT u2.login FROM Utilisateurs u2
                      WHERE u2.login=:log AND u2.login IN
                        (SELECT u1.login
                        FROM Utilisateurs u1
                        WHERE NOT EXISTS
                          (SELECT * FROM Groupe g
                            JOIN Utilisateurs u ON u.login=g.loginChef OR u.login=g.login2 OR u.login=g.login3 OR u.login=g.login4 OR u.login=g.login5 OR u.login=g.login6
                            WHERE u1.login=u.login))*/

switch ($niveau) {
  case 0:
    //On vérifie les niveaux possible pour un étudiant
    $buff = array(0);
    $compteur = 0;
    foreach ($requetes['etudiant'] as $req) {
      try {
        $compteur++;
        $req = bdd::$pdo->prepare($req);
        $val = array('log' => $_SESSION['uid']);
        $req->execute($val);
        if ( $req->rowCount() > 0) {
          $buff[] = $compteur;
        }
      }
      catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
      }
    }
    break;

  case 1:
    try {
      $req = bdd::$pdo->prepare($requetes["enseignant"]);
      $val = array('log' => $_SESSION['uid']);
      $req->execute($val);
      if ($_SESSION['uid'] == "projets") {
        $buff[] = 4;
      }else{
        $buff[] = 3;
      }
      //var_dump($req->rowCount());
    } catch (Exception $e) {
      echo "Erreur : " . $e->getMessage();
    }
    break;

  default:
    $buff = -1;
    break;
}

//update de la date pour la derniere connexion
$sql="UPDATE Utilisateurs SET dateConnexion=NOW() WHERE login=:login";
$req_prep = bdd::$pdo->prepare($sql);
$values= array(
  "login"=>$_SESSION['uid']
);
$req_prep->execute($values);

$_SESSION["level"] = $buff;
$return["level"] = $_SESSION["level"];


print json_encode($return);

?>

