<?php

session_start();

require '../../../config/DB.php';

$return = array(
    "error" => 0,
    "emails" => ""
);
$tab=array();
if(!empty($_POST["niveau"])){
    $req = "SELECT mail,objet FROM Email WHERE promotion = :promo"; // si on selectionne une promo alors on prends les mails qui correspondent
    $reqProj = bdd::$pdo->prepare($req);
    $values = array(
        "promo" => $_POST["niveau"],
    );
    $reqProj->execute($values);
}
$tab = $reqProj->fetchAll(PDO::FETCH_ASSOC);
$return['emails']=$tab;
print json_encode($return);
/*foreach ($return['groups'] as $value) {
	echo $value['promotion'];
}*/
?>