<?php

/*

FICHIER user-auth.php
utilisation: variable $_POST['infos'] contenant une liste des infos à récupérer:
$_POST['infos'] peut contenir:
- uid (récupère l'identifiant de l'utilisateur)

affiche le tableau des informations demandées dans $_POST['infos']

renvoie en json l'erreur associée à la connexion
si aucune erreur se produit (error 0), le tableau des informations demandées est affiché

*/

session_start();

// on défini le tableau qui sera retourné en json
// par défaut, pas d'erreur
$return = array(
  "error" => 0
);

// on créé le tableau des informations demandées
$infos = explode(",", $_POST['infos']);

// on parcours le tableau des informations demandées
// pour chaque demande, on rempli le tableau retourné avec l'entrée demandée
// si une erreur surviens, l'erreur du tableau retourné deviens l'index de l'erreur dans le tableau des infos demandées
for($i = 0; $i < sizeof($infos); $i++) {
  switch ($infos[$i]) {
    case 'uid':
      if(isset($_SESSION["uid"]) && !empty($_SESSION["uid"])) $return["uid"] =  $_SESSION["uid"];
      else $return["error"] = $i;
      break;
  }
}

print json_encode($return);

?>
