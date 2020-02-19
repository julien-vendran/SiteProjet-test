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

  // on vérifie que le paramètre de groupe est bien défini, sinon, par défaut, on récupèrera tous les projets
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
        $req = bdd::$pdo->prepare("SELECT DISTINCT promotion as promo FROM Utilisateurs WHERE promotion = :id");
        $req->execute(array("id" => $group));
        $name = $req->fetch(PDO::FETCH_ASSOC)["promo"];

    } catch (Exception $e) {
        exit(1);
    }*/
    $name = 'Projects_'.$group.'_'.$year.$extension;
    
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

  // on récupère la liste des projets
  try {
    // si $group = 0, on récupère tous les projets
    if($group == "Tous"){ 
      $req = bdd::$pdo->query("SELECT P.idProjet, P.titre, P.description, P.remarques, P.tuteur, P.tuteur_bis, P.promotion, P.SiteDynamique, P.BaseDeDonnees, P.InterfaceGraphique, P.AlgoAvance, P.Reseaux FROM Projets P WHERE P.actif = 1");
    }
    // sinon on récupère les projets correspondants au groupe donné
    else {
      $req = bdd::$pdo->prepare("SELECT P.idProjet, P.titre, P.description, P.remarques, P.tuteur, P.tuteur_bis, P.promotion, P.SiteDynamique, P.BaseDeDonnees, P.InterfaceGraphique, P.AlgoAvance, P.Reseaux FROM Projets P WHERE P.actif = 1 AND P.promotion = :id");
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

  // $file = fopen("../../../tmp/".$name, "x+");
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
  // prend en paramètre le retour de la requête PDO de la liste des projets
  // retourne un tableau CSV de la liste des projets
  function generateCsv ($PDOResult) {
    $return = "idProjet, titre, description, remarques, tuteur, tuteur_bis, promotion, SiteDynamique, BaseDeDonnees, InterfaceGraphique, AlgoAvance, Reseaux\n";
    while ($project = $PDOResult->fetch(PDO::FETCH_ASSOC)) {
      $return .= $project["idProjet"].",".$project["titre"].",".$project["description"].",".$project["remarques"].",".$project["tuteur"].",".$project["tuteur_bis"].",".$project["promotion"].",".$project["SiteDynamique"].",".$project["BaseDeDonnees"].",".$project["InterfaceGraphique"].",".$project["AlgoAvance"].",".$project["Reseaux"]."\n";
    }
    return $return;
  }


  // function generateJson
  // prend en paramètre le retour de la requête PDO de la liste des projets
  // retourne un tableau JSON de la liste des projets
  function generateJson ($PDOResult) {
    $return = "{\n";
    while ($project = $PDOResult->fetch(PDO::FETCH_ASSOC)) {
      $return .= "  [\n";
      $return .= "    id : ".$project["idProjet"].",\n";
      $return .= "    \"titre\" : ".$project["titre"].",\n";
      $return .= "    \"description\" : ".$project["description"].",\n";
      $return .= "    \"remarques\" : ".$project["remarques"].",\n";
      $return .= "    \"tuteur\" : ".$project["tuteur"].",\n";
      $return .= "    \"tuteur_bis\" : ".$project["tuteur_bis"].",\n";
      $return .= "    \"promotion\" : ".$project["promotion"].",\n";
      $return .= "    \"SiteDynamique\" : ".$project["SiteDynamique"].",\n";
      $return .= "    \"BaseDeDonnees\" : ".$project["BaseDeDonnees"].",\n";
      $return .= "    \"InterfaceGraphique\" : ".$project["InterfaceGraphique"].",\n";
      $return .= "    \"AlgoAvance\" : ".$project["AlgoAvance"].",\n";
      $return .= "    \"Reseaux\" : ".$project["Reseaux"].",\n";
      $return .= "  ],\n";
    }
    $return .= "\n}";
    return $return;
  }

?>
