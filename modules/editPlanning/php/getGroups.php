<?php

session_start();

require '../../../config/DB.php';

$return = array(
  "error" => 0,
  "groups" => ""
);

$req = bdd::$pdo->query("SELECT idPromo AS id, promotion AS name FROM Utilisateurs");
while($tmp = $req->fetch(PDO::FETCH_ASSOC)) {
  $return["groups"][] = $tmp;
};

print json_encode($return);

?>
