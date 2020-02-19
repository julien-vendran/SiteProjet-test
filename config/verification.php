<?php
  session_start();

  // on récupère les infos relatives au module
  $infos = json_decode(file_get_contents("infos.json"), true);

  // on vérifie que l'utilisateur est autorisé à utiliser ce module, sinon on le redirige
  $compteur = 0;
    
  //if ($_SESSION['uid'] == "coletta")
  //  $compteur++;
  if ($_SESSION['uid'] == "projets")
    $compteur++;

  foreach($_SESSION['level'] as $niveau) {
	  if(in_array($niveau, $infos['level'])) {
		  $compteur++;
	  }
  }

  if ($compteur == 0) header("Location: ../..");
?>
