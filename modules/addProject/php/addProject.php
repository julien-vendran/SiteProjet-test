
<?php

  session_start();

  require '../../../config/DB.php';

  $return = array(
    "error" => 0
  );

  /* On récupère les données de Ajax pour les ajouter à la base de données et créer le projet */
  $title = $_POST['project_title'];
  $desc = $_POST['project_description'];
  $prom = $_POST['project_annee'];
  $actif = $_POST['project_actif'];
  $creator = $_SESSION['uid'];
  $more = ($_POST['project_more'] == 'NULL') ? NULL : $_POST['project_more'];
  $tutbis = ($_POST['project_cotuteur'] == 'NULL') ? NULL : $_POST['project_cotuteur'];

  $site = $_POST['project_site'];
  $bd = $_POST['project_bd'];
  $interface = $_POST['project_interface'];
  $algo = $_POST['project_algo'];
  $reseaux = $_POST['project_reseaux'];
  

  /* On exécute la requête pour ajouter le projet à la base de données */
  try {
    $sqlProjet = "INSERT INTO Projets (titre, description, remarques, tuteur, tuteur_bis, actif, promotion,SiteDynamique,BaseDeDonnees,InterfaceGraphique,AlgoAvance,Reseaux)
                    VALUES (:title, :description, :more, :createur, :cotuteur, :actif, :prom, :site, :bd, :interface, :algo, :reseaux)";
    $reqInsert = bdd::$pdo->prepare($sqlProjet);
    $valProj = array(
      'title' => $title,
      'description' => $desc,
      'more' => $more,
      'createur' => $creator,
      'cotuteur' => $tutbis,
      'actif' => $actif,
      'prom' => $prom,

        'site' => $site,
      'bd' => $bd,
      'interface' => $interface,
      'algo' => $algo,
      'reseaux' => $reseaux);

    $reqInsert->execute($valProj);
  } catch (Exception $e) {
    $return["error"] = $e->getMessage();
  }
    
  print json_encode($return);
?>

