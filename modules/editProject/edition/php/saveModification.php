<?php

  require '../../../../config/DB.php';

  session_start();

  $return = array('error' => 0);

  // On récupère les paramètres
  $id = $_POST['id'];
  $titre = $_POST['titre'];
  $description = $_POST['description'];
  $remarques = $_POST['remarques'];
  $annee = $_POST['annee'];
  $cotuteur = $_POST['cotuteur'] == "" ? null : $_POST['cotuteur'];
  $actif = $_POST['actif'];

$site = $_POST['project_site'];
$bd = $_POST['project_bd'];
$interface = $_POST['project_interface'];
$algo = $_POST['project_algo'];
$reseaux = $_POST['project_reseaux'];

  try {
    $sql = "UPDATE Projets SET titre = :titre, description = :desc, remarques = :rem, promotion = :idPromo, tuteur_bis = :cotuteur, actif = :actif, SiteDynamique = :site, BaseDeDonnees = :bd, InterfaceGraphique = :interface, AlgoAvance = :algo,Reseaux = :reseaux
            WHERE tuteur = :uid AND idProjet = :idProjet";
    $req = bdd::$pdo->prepare($sql);
    $val = array(
      'titre' => $titre,
      'desc' => $description,
      'rem' => $remarques,
      'idPromo' => $annee,
      'cotuteur' => $cotuteur,
      'actif' => $actif,
      'uid' => $_SESSION['uid'],
      'idProjet' => $id,

      'site' => $site,
      'bd' => $bd,
      'interface' => $interface,
      'algo' => $algo,
      'reseaux' => $reseaux);

    $req->execute($val);
  } catch (PDOException $e) {
    $return['error'] = $e->getMessage();
  }

  printf(json_encode($return));

 ?>
