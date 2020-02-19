<?php

session_start();

require '../../../config/DB.php';

$return = array(
    "error" => 0,
    "projects" => ""
);

$current_user = $_SESSION['uid'];

$actif = 1;
if(isset($_POST['actif']))
    $actif = $_POST['actif'];
$promo = 'ALL';
if(isset($_POST['promo']))
    $promo = $_POST['promo'];

if (in_array("0",$_SESSION["level"])||in_array("1",$_SESSION["level"])||in_array("2",$_SESSION["level"]))
    try {
        $sqlCurrIdProm = "SELECT promotion
             FROM Utilisateurs U
             WHERE U.login = :current";
        $reqCurrIdProm = bdd::$pdo->prepare($sqlCurrIdProm);
        $reqCurrIdProm->execute(array('current' => $current_user));
        $currIdProm = $reqCurrIdProm->fetch(PDO::FETCH_ASSOC);
        $promo = $currIdProm["promotion"];
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

//echo $actif;
//echo $promo;

$sqlProj = "SELECT U.promotion , titre, description, remarques, U.nom AS tuteur, U1.nom AS tuteur_bis, CASE WHEN actif=0  THEN 'inactif' ELSE  'actif' END AS actif, P.promotion AS niveau, CASE WHEN SiteDynamique =0  THEN 'non' ELSE  'oui' END AS site, CASE WHEN BaseDeDonnees =0  THEN 'non' ELSE  'oui' END AS bd, CASE WHEN InterfaceGraphique =0  THEN 'non' ELSE  'oui' END AS interface, CASE WHEN AlgoAvance =0  THEN 'non' ELSE  'oui' END AS algo, CASE WHEN Reseaux =0  THEN 'non' ELSE  'oui' END AS reseaux
                       FROM Projets P
                       JOIN Utilisateurs U ON P.tuteur = U.login
                       LEFT JOIN Utilisateurs U1 ON P.tuteur_bis = U1.login
                       WHERE P.actif = :actif
                       AND P.promotion = :promo
                       ORDER BY P.promotion DESC,IdProjet  ";

if ($actif == 'ALL')
    $sqlProj = str_replace("P.actif = :actif", "P.actif = :actif OR true", $sqlProj);
if ($promo == 'ALL' OR $promo == 'Enseignant')
    $sqlProj = str_replace("P.promotion = :promo", "P.promotion = :promo OR true", $sqlProj);

//echo $sqlProj;

try {
    $reqProj = bdd::$pdo->prepare($sqlProj);
    $values = array(
        'promo' => $promo,
        'actif' => $actif);
    $reqProj->execute($values);
    $projectList = $reqProj->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($projectList)) $return["projects"] = $projectList;
    else $return["error"] = 1;

}
catch (PDOException $e){
    echo "Erreur " . $e->getMessage();
}

//print_r($projectList);

if(!empty($projectList)) $return["projects"] = $projectList;
else $return["error"] = 1;
printf(utf8_decode(json_encode($return)));


?>
