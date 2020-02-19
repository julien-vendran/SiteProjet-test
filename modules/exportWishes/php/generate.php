<?php

  // on récupère la connexion à la base de données
  require '../../../config/DB.php';

  // on génère le tableau qui sera renvoyé en json
  $return = array(
    "error" => 0,
    "url" => ""
  );

  // on vérifie que le paramètre de conversion est bien défini, sinon, par défaut, on convertira la liste en csv (1)
  $convert = (isset($_POST["convert"]) && !empty($_POST["convert"]) ? $_POST["convert"] : 1);

  // on vérifie que le paramètre de groupe est bien défini, sinon, par défaut, on récupèrera tous les voeux
  $group = $_POST["group"];
  if ($group == '0') {
    $group="Tous";
  }
  /*
  ----------------------------------
  -- GÉNÉRATION DU NOM DU FICHIER --
  ----------------------------------
  */

  // on génère l'extension du fichier en fonction du paramètre de conversion
  $extension = '.csv';
  switch ($convert) {
    case 1:
      $extension = '.csv';
      break;

    case 2:
      $extension = '.json';
      break;
  }

    date_default_timezone_set('UTC');
    $year = date('Y');
    /*try {
        $req = bdd::$pdo->prepare("SELECT promotion FROM Utilisateurs WHERE idPromo = :id");
        $req->execute(array("id" => $group));
        $name = $req->fetch(PDO::FETCH_ASSOC)["promo"];
    } catch (Exception $e) {
        exit(1);
    }*/
    $name = 'Wishs_'.$group.'_'.$year.$extension;
  /*
  // on peuple un tableau qui contiendra la liste des fichiers générés déjà existants
  $namelist = array();
  $dir = opendir('../../../tmp');
  while($file = readdir($dir)) {
    if($file != '.' && $file != '..' && !is_dir('../../../tmp/'.$file)) $namelist[] = $file;
  }
  closedir($dir);

  // on défini les caractères autorisés dans le nom du fichier
  $characts  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';  
  $characts .= '1234567890'; 

  // on défini la taille du nom du fichier à générer
  $filesize = 5;

    $year=date('Y');
    
  // on génère un nom de fichier qui n'a encore été jamais généré
  do {
    $name = '';
    for($i = 0; $i < $filesize; $i++) { 
      $name .= substr($characts,rand() % (strlen($characts)),1);
    }
    $name .= $extension;
  } while(in_array($name, $namelist));
  */
  /*
  --------------------------------------------
  -- FIN DE LA GÉNÉRATION DU NOM DU FICHIER --
  --------------------------------------------
  -- NOM ENREGISTRÉ DANS $name ---------------
  --------------------------------------------
  */









  /*
  --------------------------------------
  -- GÉNÉRATION DU CONTENU DU FICHIER --
  --------------------------------------
  */

  // on récupère la liste des voeux
  try {
    // si $group = 0, on récupère tous les voeux
    if($group == "Tous") $req = bdd::$pdo->query("SELECT idProjet, loginChef, Classement FROM voeux");
    // sinon on récupère les voeux correspondants au groupe donné
    else {
      $req = bdd::$pdo->prepare("SELECT v.idProjet, v.loginChef, v.Classement FROM voeux v JOIN Projets p ON v.idProjet=p.idProjet WHERE p.promotion = :id ORDER BY v.loginChef, v.Classement");
      $req->execute(array("id" => $group));
    }
  } catch (Exception $e) {
    exit(1);
  }

  // on génère le contenu avec la liste
  switch ($convert) {
    case 1:
      $content = generateCsv($req);
      break;

    case 2:
      $content = generateJson($req);
      break;

    default:
      $content = '';
      break;
  }

  /*
  ------------------------------------------------
  -- FIN DE LA GÉNÉRATION DU CONTENU DU FICHIER --
  ------------------------------------------------
  -- CONTENU ENREGISTRÉ DANS $content ------------
  ------------------------------------------------
  */



  /*
  -------------------------
  -- CRÉATION DU FICHIER --
  -------------------------
  */

  $file = fopen("../../../tmp/".$name, "w+");
  fputs($file, $content);
  fclose($file);

  $return["url"] = "../../tmp/".$name;

  /*
  --------------------------------------------------------
  -- FIN DE LA CRÉATION DU FICHIER -----------------------
  --------------------------------------------------------
  -- ADRESSE DU FICHIER ENREGISTREÉE DANS $return["url"]--
  --------------------------------------------------------
  */

  // on affiche le tableau de retour, structuré en json
  print json_encode($return);

  /*
  --------------------------------------
  -- FONCTION --------------------------
  --------------------------------------
  */

  // function generateCsv
  // prend en paramètre le retour de la requête PDO de la liste des voeux
  // retourne un tableau CSV de la liste des voeux
  function generateCsv ($PDOResult) {
    // on reforme le tableau des voeux, dans un tableau php
    $table = array();
    while ($wish = $PDOResult->fetch(PDO::FETCH_ASSOC)) {
      /*
      if(empty($table[intval($wish["idGroupe"])])) {
        $table[intval($wish["idGroupe"])] = array();

        $req = bdd::$pdo->prepare("SELECT niveau FROM Promotions WHERE idPromo = (
          SELECT idPromo FROM Classes WHERE idClasse = (
            SELECT idClasse FROM Utilisateurs WHERE login = (
              SELECT chefGroupe FROM GroupeProjet WHERE idGroupe = :id
            )
          )
        )");
        $req->execute(array("id" => $wish["idGroupe"]));
        $res = $req->fetch();
        $table[intval($wish["idGroupe"])][5] = $res["niveau"];
      }
    */
      $table[$wish["loginChef"]][intval($wish["Classement"])-1] = intval($wish["idProjet"]);
      //echo "voeux"
    }

    $return = "";

    foreach ($table as $key => $value) {
      $return .= $key;
        //print_r($value);
        
      foreach ($value as $key2 => $value2) {
        if(intval($key2) < 5) $return .=  ",".$value2;
      }

      $return .=   "\n";

    }

    return $return;
  }


  // function generateJson
  // prend en paramètre le retour de la requête PDO de la liste des voeux
  // retourne un tableau JSON de la liste des voeux
  function generateJson ($PDOResult) {
    $return = "{\n";
    $table = array();
    while ($wish = $PDOResult->fetch(PDO::FETCH_ASSOC)) {
      $table[$wish["loginChef"]][intval($wish["Classement"])-1] = intval($wish["idProjet"]);
    }

    foreach ($table as $key => $value) {
      $return .= "  [\n";
      $return .= "    loginChef : ".$key.",\n";
      $return .= "    idProjet : ";
      foreach ($value as $key2 => $value2) {
        if(intval($key2) < 5){
          $return .=  $value2.",";
        } 
      }
      $return=rtrim($return,",");
      $return .=   "\n";
      $return .= "  ],\n";
    }

    $return .= "\n}";

    return $return;
  }

?>
