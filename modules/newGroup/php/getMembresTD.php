<?php

  session_start();

  require '../../../config/DB.php';

  try {
    $sql = "SELECT U.login, U.nom, U.prenom FROM Utilisateurs U        /*Requete SQL pour récupérer les membres qui n'ont pas de groupe*/
            WHERE U.IdGroupe IS NULL                                   /*et qui sont dans la meme classe que le délégué*/
            AND U.IdClasse IN (SELECT U1.IdClasse
                              FROM Utilisateurs U1
                              WHERE U1.login = :login)";
    $query = bdd::$pdo->prepare($sql);
    $val = array("login" => $_SESSION['uid']);
    $query->execute($val);
    $grpTD = $query->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($grpTD);

  }
  catch(Exception $e){
    echo json_encode($e);
  }

?>
