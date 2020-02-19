<?php

  require '../../../config/DB.php';

  $return = array('error' => 0);

  try {
    // Vérification que le délégué ne soit pas déja affecté
    $sql0 = "SELECT idClasse FROM Utilisateurs WHERE login = :del1 AND idClasse <> NULL";
    $req0 = bdd::$pdo->prepare($sql0);
    $data = array("del1" => $_POST['d1']);
    $req0->execute($data);
    $lines = $req0->rowCount();

    $delegue2 = (isset($_POST['d2'])) ? $_POST['d2'] : NULL;
      
    if($lines > 0 ){
      $return['error'] = "1 La création de la classe".$_POST['nom']." est annulée car un délégué est déjà affecté à une classe.";
    }
    else {
      $sql = "INSERT INTO Classes(nomClasse, delegue1, delegue2, idPromo) VALUES (:nom, :del1, :del2, :promo)";
      $req = bdd::$pdo->prepare($sql);
      $val = array(
        'nom' => $_POST['nom'],
        'del1' => $_POST['d1'],
        'del2' => $delegue2,
        'promo' => $_POST['promo']);
        $req->execute($val);

        // Récupération de l'id de la classe crée
        $sql1 = "SELECT LAST_INSERT_ID() as idClasse
        FROM Classes";
        $query1 = bdd::$pdo->prepare($sql1);
        $data = array('del1' => $_POST["d1"],
                      'del2' => $delegue2);
        $query1->execute($data);
        $id = $query1->fetch(PDO::FETCH_ASSOC);

        $classe = array("idClasse" => $id["idClasse"],
        "del1" => $_POST['d1'],
        "del2" => $delegue2);

        // Mise a jour de la classe des délégués
        $sql2 = "UPDATE Utilisateurs
        SET idClasse = :idClasse
        WHERE login = :del1
        OR login = :del2";
        $query2 = bdd::$pdo->prepare($sql2);
        $query2->execute($classe);
    }


  } catch (PDOException $e) {
    $return['error'] = $e->getMessage();
  }

  printf(json_encode($return));

 ?>
