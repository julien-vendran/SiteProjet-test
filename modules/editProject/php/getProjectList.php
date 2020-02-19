<?php

session_start();

require '../../../config/DB.php';

$return = array(
  "error" => 0,
  "projects" => ""
);

$current_user = $_SESSION['uid'];
 
    try {
        $sql = "SELECT idProjet,P.promotion AS niveau, titre, description, remarques, U.nom AS tuteur, U1.nom AS tuteur_bis, CASE WHEN SiteDynamique =0  THEN 'non' ELSE  'oui' END AS site, CASE WHEN BaseDeDonnees =0  THEN 'non' ELSE  'oui' END AS bd, CASE WHEN InterfaceGraphique =0  THEN 'non' ELSE  'oui' END AS interface, CASE WHEN AlgoAvance =0  THEN 'non' ELSE  'oui' END AS algo, CASE WHEN Reseaux =0  THEN 'non' ELSE  'oui' END AS reseaux,CASE WHEN actif=0  THEN 'Inactif' ELSE 'actif' END AS actif, U.promotion
        FROM Projets P
        JOIN Utilisateurs U ON P.tuteur = U.login
        LEFT JOIN Utilisateurs U1 ON P.tuteur_bis = U1.login
        WHERE tuteur = :log OR tuteur_bis = :log
        ORDER BY promotion DESC,IdProjet  ";
        $req = bdd::$pdo->prepare($sql);
        $val = array('log' => $current_user);
        $req->execute($val);
        $projectList = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $return['error'] = $e->getMessage();
    }

if(!empty($projectList)) $return["projects"] = $projectList;
else $return["error"] = 1;

print json_encode($return);

?>
