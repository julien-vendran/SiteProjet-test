<?php
    
    // on récupère la connexion à la base de données
    require '../../../config/DB.php';
    
  require 'convertAffectations.php';
  
  $return = array(
    "error" => 0,
    "size" => 0,
    "file" => "",
    "affectations" => ""
  );
  
  if(isset($_POST["file"]) && !empty($_POST["file"])) {
    if($handle = fopen("../../../tmp/" . $_POST["file"], "r")) {
      $affectations = convertAffectations($handle);

      $return["file"] = $_POST["file"];
      $return["size"] = sizeof($affectations);
      $return["affectations"] = $affectations;

      fclose($handle);
    }
  }

    
	echo json_encode($return);

?>
