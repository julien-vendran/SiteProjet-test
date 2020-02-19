<?php

/*

FICHIER list-modules.php
utilisation: aucune variable nécessaire
réupère la liste des modules accessible par l'utilisateur courrant

renvoie en json la liste des  modules accessibles
si aucune erreur se produit (error 0) ...

*/

session_start();
    
//REMI ERROR OFF
error_reporting(E_ERROR  | E_PARSE);
ini_set('error_reporting', E_ERROR | E_PARSE);
    
    
// on défini le tableau qui sera retourné en json
// par défaut, pas d'erreur
$return = array(
  "error" => 0,
  "modules" => array()
);

// on ouvre le dossier qui contiens les modules
$modules = opendir("../modules");

// on commence par lire les modules qui sont éventuellement déjà enregistrés dans un cookie
$cookie_list = explode(",", $_COOKIE["modulesPosition"]);

foreach ($cookie_list as $key => $value) {
  if(is_dir("../modules/".$value) && $value != "." && $value != "..") {
    // on ouvre le dossier du module
    $tmp_module = opendir("../modules/".$value);

    if(is_file("../modules/".$value."/infos.json")) {
        // on lis le fichier de configuration du module
        $tmp_infos = json_decode(file_get_contents("../modules/".$value."/infos.json"), true);
        $tmp_infos["folder"] = $value;

        // si l'utilisateur a le droit d'accéder au module, on l'ajoute à la liste
        foreach ($_SESSION['level'] as $niveau) {
          if(in_array($niveau, $tmp_infos["level"])){
            $return["modules"][] = $tmp_infos;
          }
        }
    }
  } else {
    // si le module n'existe pas (ou plus), on le supprime du cookie
    unset($cookie_list[$key]);
    $cookie_list = array_values($cookie_list);
  }
}

$chain = implode(",", $cookie_list);


// on lis les modules qui sont dans le dossier et qui n'ont pas encore été ajoutés via le cookie
while($dir = readdir($modules)) {
  if(is_dir("../modules/".$dir) && $dir != "." && $dir != ".." && !in_array($dir, $cookie_list)) {

    // on ouvre le dossier du module
    $tmp_module = opendir("../modules/".$dir);

    if(is_file("../modules/".$dir."/infos.json")) {
        // on lis le fichier de configuration du module
        $tmp_infos = json_decode(file_get_contents("../modules/".$dir."/infos.json"), true);
        $tmp_infos["folder"] = $dir;
        
            //echo $_SESSION['uid'];
         //if ($_SESSION['uid'] == "coletta")
           //  $return["modules"][] = $tmp_infos;
        
         //if ($_SESSION['uid'] == "projets")
           //  $return["modules"][] = $tmp_infos;
        
        // si l'utilisateur a le droit d'accéder au module, on l'ajoute à la liste
        foreach ($_SESSION['level'] as $niveau) {
          if(in_array($niveau, $tmp_infos["level"]))
            $return["modules"][] = $tmp_infos;
        }
    }
  }
}

print json_encode($return);

?>
