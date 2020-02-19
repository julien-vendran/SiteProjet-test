<?php
    
    require '../../../../config/DB.php';
    
    session_start();
    
    $return = array('error' => 0);
    
    // On récupère les paramètres
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $remarques = $_POST['remarques'];
    $promotion = $_POST['promotion'];
    $cotuteur = $_POST['cotuteur'] == "" ? null : $_POST['cotuteur'];
    $actif = $_POST['actif'];

$site = $_POST['project_site'];
$bd = $_POST['project_bd'];
$interface = $_POST['project_interface'];
$algo = $_POST['project_algo'];
$reseaux = $_POST['project_reseaux'];
    
    try {
        $sql = "INSERT INTO Projets (titre, description, remarques, tuteur, tuteur_bis, actif, promotion,SiteDynamique,BaseDeDonnees,InterfaceGraphique,AlgoAvance,Reseaux)
                             VALUES (:title, :description, :remarque, :tuteur, :cotuteur, :actif, :promotion, :site, :bd, :interface, :algo, :reseaux)";
        $req = bdd::$pdo->prepare($sql);
        $val = array(
                     'title' => $titre,
                     'description' => $description,
                     'remarque' => $remarques,
                     'tuteur' => $_SESSION['uid'],
                     'cotuteur' => $cotuteur,
                     'actif' => 1,
                     'promotion' => $promotion,
                     'site' => $site,
                     'bd' => $bd,
                     'interface' => $interface,
                     'algo' => $algo,
                     'reseaux' => $reseaux
        );
        $req->execute($val);
    } catch (PDOException $e) {
        $return['error'] = $e->getMessage();
    }

    
    printf(json_encode($return));
    
    ?>
