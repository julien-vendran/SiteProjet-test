<?php

/*

FICHIER user-auth.php
utilisation: variable $_POST['infos'] contenant un tableau des infos à récupérer:
$_POST['infos'] peut contenir:
- uid (récupère l'identifiant de l'utilisateur)

affiche le tableau des informations demandées dans $_POST['infos']

renvoie en json l'erreur associée à la connexion
si aucune erreur se produit (error 0), le tableau des informations demandées est affiché

*/

session_start();

// on défini le tableau qui sera retourné en json
// par défaut, pas d'erreur
// on renvoie l'identifiant de la session demandée
$return = array(
  "error" => 0
);

// on vide les variables de session
$_SESSION = array();

// on supprime les cookies liés à la session courrante
if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
  );
}

// on supprime les cookies d'auto connexion
setcookie("auto", "", time() - 1);

// Finalement, on détruit la session courrante
session_destroy();

print json_encode($return);

?>
