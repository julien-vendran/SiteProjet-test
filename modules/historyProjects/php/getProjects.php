<?php

session_start();

require '../../../config/DB.php';

$return = array(
    "error" => 0,
    "projects" => ""
);

$current_user = $_SESSION['uid'];
if(in_array(3,$_SESSION["level"])){
    try { // nous allons récupérer dans un premier dans la liste de tous les porjets et ensuite n'affiché seulement ceux qui ont une année d'affectation.
        $sqlProj = "SELECT DISTINCT P.idProjet AS idProjet, titre, P.promotion AS niveau
                     FROM Projets P
                     WHERE tuteur = :login OR tuteur_bis = :login";
        $reqProj = bdd::$pdo->prepare($sqlProj);
        $enseignant = array(
            "login" => $current_user
        );
        $reqProj->execute($enseignant);
        $allproject = $reqProj->fetchAll(PDO::FETCH_ASSOC); // nous avons la liste de tous les projets.
        $projectList = array(); // on récupère dans ce tableau la liste des projets qui ont une date d'affectation et on les affiche
            foreach ($allproject as $value) {
                $sql = ' SELECT EXTRACT(YEAR FROM anneeAffectation) AS anneeAffectation, loginChef FROM Groupe G
                    JOIN Projets P ON P.idProjet = G.idProjet
                    WHERE G.idProjet = :id';
                $values = array(
                    "id" => $value["idProjet"],
                );
                $req_Proj = bdd::$pdo->prepare($sql);
                $req_Proj->execute($values);
                $resultat = $req_Proj->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($resultat)) {
                    $date = array(
                        "date" => $resultat,
                    );
                    $value["date"] = $date["date"];
                    array_push($projectList, $value);
                }

            }

    } catch (PDOException $e) {
        echo "Erreur " . $e->getMessage();
    }
}
else {
    try { // nous allons récupérer dans un premier dans la liste de tous les porjets et ensuite n'affiché seulement ceux qui ont une année d'affectation.
        $sqlProj = "SELECT DISTINCT P.idProjet AS idProjet, titre, P.promotion AS niveau
                     FROM Projets P
                     JOIN Groupe G on G.idProjet = P.idProjet";
        $reqProj = bdd::$pdo->prepare($sqlProj);
        $reqProj->execute();
        $allproject = $reqProj->fetchAll(PDO::FETCH_ASSOC); // nous avons la liste de tous les projets.
        $projectList = array(); // on récupère dans ce tableau la liste des projets qui ont une date d'affectation et on les affiche
        foreach ($allproject as $value) {
            $sql = ' SELECT EXTRACT(YEAR FROM anneeAffectation) AS anneeAffectation, loginChef FROM Groupe G
                    JOIN Projets P ON P.idProjet = G.idProjet
                    WHERE G.idProjet = :id';
            $values = array(
                "id" => $value["idProjet"],
            );
            $req_Proj = bdd::$pdo->prepare($sql);
            $req_Proj->execute($values);
            $resultat = $req_Proj->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($resultat)) {
                $date = array(
                    "date" => $resultat,
                );
                $value["date"] = $date["date"];
            }
            array_push($projectList, $value);
        }
    } catch (PDOException $e) {
        echo "Erreur " . $e->getMessage();
    }
}

if(!empty($projectList)) $return["projects"] = $projectList;
else $return["error"] = 1;
//$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
//echo json_encode($arr);
//print_r($return);
//echo (json_encode($return));
printf(utf8_decode(json_encode($return)));

?>
