<?php

  session_start();

  require '../../../config/DB.php';

  //on recupere les users sans groupe et qui sont dans la meme classe que l'user sans celui-ci
  try {
    $sql = "SELECT u2.login, u2.nom, u2.prenom FROM Utilisateurs u2
                      WHERE u2.login IN
                        (SELECT u1.login
                        FROM Utilisateurs u1
                        WHERE NOT EXISTS
                          (SELECT * FROM Groupe g
                            JOIN Utilisateurs u ON u.login=g.loginChef OR u.login=g.login2 OR u.login=g.login3 OR u.login=g.login4 OR u.login=g.login5 OR u.login=g.login6
                            WHERE u1.login=u.login)) AND u2.classe = (SELECT classe FROM Utilisateurs WHERE login=:login) AND u2.login!=:login";
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
