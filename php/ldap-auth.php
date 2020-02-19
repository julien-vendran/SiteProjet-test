<?php

/*

FICHIER ldap-auth.php
utilisation: variables $_POST['login'] et $_POST['password'] avec une syntaxe valide
vérifie les identifiants et connecte l'utilisateur au module LDAP

renvoie en json l'id de la session PHP courrante et l'erreur associée à la connexion
si aucune erreur se produit (error 0), renvoie le tableau des informations associées à l'utilisateur

*/

// on démarre une nouvelle session PHP
session_start();

//REMI ERROR OFF
error_reporting(E_ERROR  | E_PARSE);
ini_set('error_reporting', E_ERROR | E_PARSE);

// On récupère les informations de connexion au LDAP
require '../config/ldap.php';

// on définit les différentes années et les différents types de connexions existantes dans le ldap
$conf = array();
$conf[] = array("name" => "Etudiants", "levels" => [",ou=Ann1", ",ou=Ann2", ",ou=As", ",ou=Licence"]);
$conf[] = array("name" => "Personnel", "levels" => [""]);


// on définit le tableau qui sera retourné en json
// par défaut, pas d'erreur
$return = array(
  "error" => 0,
  "usertype" => 0
);

// on récupère l'identifiant et le mot de passe de l'utilisateur envoyés en POST et on revérifie que leur syntaxe et correcte
$ldap_login = isset($_POST['login']) && !empty($_POST['login']) ? $_POST['login'] : false;
$ldap_password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : false;

// on se connecte au serveur LDAP
//$ldap_conn = ldap_connect($ldap_host) //, $ldap_port)
//  or die("Impossible de se connecter au serveur LDAP $ldap_host");

// on définit la version du module LDAP
//ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

    
// si la connexion est établie et que la syntaxe des identifiants est correcte
/*if ($ldap_login=="corna" && $ldap_password=="admin") {//ce if est fait pour le mode développeur, a supprimer à  la fin
  $_SESSION['uid'] = "corna";

}else{*/
if($ldap_conn && $ldap_login && $ldap_password) {
  // on recherche l'identifiant de l'utilisateur dans le module LDAP
  $ldap_searchfilter = "(uid=$ldap_login)";
  $search = ldap_search($ldap_conn, $ldap_basedn, $ldap_searchfilter, array());
  $user_result = ldap_get_entries($ldap_conn, $search);

  // on vérifie que l'entrée existe bien
  $user_exist = $user_result["count"] == 1 ? true : false;

  // si l'utilisateur existe bien,
  if($user_exist) {

      /*test force brute rémi
      $dn = "uid=".$ldap_login.",ou=Ann1,ou=Etudiants,ou=People,dc=info,dc=iutmontp,dc=univ-montp2,dc=fr";
      $rt= ldap_bind($ldap_conn,$dn,$ldap_password);
      echo "ldap_bind= ".$rt;
      
      if( $rt !== false ) {
          echo ("connexion ldap OK");
      }
      else {
          echo "Pas de connexion LDAP ";
      }*/


      // on essaye de connecter l'utilisateur en associant son login au mot de passe envoyé en paramètre
      // on essaye avec chaque niveau de l'IUT (tableau levels)

    foreach($conf as $id => $org) {
      foreach ($org["levels"] as $lvl) {
        $user_dn = "uid=".$ldap_login.$lvl.",ou=".$org["name"].",".$ldap_baseorganization.",".$ldap_basedn;
        $user_connect = ldap_bind($ldap_conn, $user_dn, $ldap_password);

        if($user_connect) {
          // si la connexion est établie, on ajoute au tableau de retour les informations qui lui sont associées
          $return["user"] = $user_result;
          // on enregistre l'uid en session
          $_SESSION['uid'] = $ldap_login;
          $return["usertype"] = $id;

          // si l'utilisateur souhaite activer la connexion automatique ...
          if(isset($_POST["save"]) && $_POST["save"] == "true")
            // on place un cookie valable 60 jours (renouvelable)
            setcookie("auto", $ldap_login . "," . $ldap_password, time() + 60*24*3600);

          break;
        }
      }

      if($user_connect) break;
    }

    if(!$user_connect) {
      // sinon, le mot de passe est incorrect, on modifie l'erreur associée dans le tableau de retour (error 2)
      $return["error"] = 2;
    }
  } else {
    // sinon, l'utilisateur n'existe pas, on modifie l'erreur associée dans le tableau de retour (error 1)
    $return["error"] = 1;
  }


  // on déconnecte le serveur LDAP
  ldap_unbind($ldap_conn);
} else {
  // sinon, une erreur inconnue s'est produite, on modifie l'erreur associée dans le tableau de retour (error -1)
  $return["error"] = -1;
}
/*}*/
// on affiche le tableau de retour en json, qui sera récupére par ajax
print json_encode($return);

?>
