<?php

  require '../../../config/ldap.php';
  require '../../../config/DB.php';

  $return = array(
    'error' => 0,
    'nbImport' => 0,
  );

  //On prépare un buffer pour stocker les différentes promotions des utilisateurs
  $buffPromo = array();

    //ldap_set_option($ldap_conn, LDAP_OPT_SIZELIMIT, 3000);
    
    //On recherche toutes les entrées du LDAP qui sont des personnes
    $search = ldap_search($ldap_conn, $ldap_basedn, "(objectClass=person)");
  
    if(  ldap_count_entries($ldap_conn,$search) == 500) {
        echo "attention il y a une limite sur le nombre de réponse du LDAP";
    }
  //On récupère toutes les entrées de la recherche effectuées auparavant
  $resultats = ldap_get_entries($ldap_conn, $search);
  //On prépare le tableau qui va recevoir tous les utilisateurs renseignés sur le LDAP
  $people = array();

  //printf(json_encode($resultats[1]), JSON_PRETTY_PRINT);

  //Pour chaque utilisateur, on récupère les informations utiles
  for ($i=0; $i < count($resultats) - 1 ; $i++) {
    //On stocke le login, nom/prénom, la classe et la promotion de l'utilisateur courant
    $user = array(
      'login' => $resultats[$i]["uid"][0],
      'nom' => $resultats[$i]['displayname'][0],
      'nom' => $resultats[$i]['displayname'][0],  //contient le nom et le prenom
      'classe' => $resultats[$i]['departmentnumber'][0], //contient le groupe si renseigné
      'promotion' => explode("=", explode(",", $resultats[$i]['dn'])[1])[1] //contient la promotion

    );
    print_r(json_encode($user));
    //On ajoute cet utilisateur au tableau qui contient tous les membres du LDAP
    $people[] = $user;


    // //On vérifie que la promotion n'est pas 'employe'
    // //Si ce n'est pas le cas, on la stocke
    // if ( $user['promotion'] != 'Personnel' ) {
    //   $buffPromo[] = $user['promotion'];
    // }
  }

  // try {
  //   //On récupère juste l'ID de la classe enseignante
  //   $sqlCT = "SELECT idClasse FROM Classes WHERE nomClasse = 'Enseignants'";
  //   $reqCT = bdd::$pdo->prepare($sqlCT);
  //   $reqCT->execute();
  //   $tempCT = $reqCT->fetchAll(PDO::FETCH_ASSOC);
  //   $CLASSE_ENSEIGNANTS = $tempCT[0]['idClasse'];
  // } catch (PDOException $e) {
  //   $return['error'] = $e->getMessage();
  // }


  //On traite désormais toutes les promotions pour les ajouter à la bdd
  // for ($p=0; $p < count($buffPromo); $p++) {
  //   //On formatte le niveau pour un affichage homogène (cf : ann2 => A2)
  //   if ( strpos($buffPromo[$p], 'Ann') !== false ) {
  //     $temp = str_split($buffPromo[$p]);
  //     $buffPromo[$p] = 'A' . $temp[3];
  //   }
  // }

  for ($p=0; $p < count($people); $p++) {
    //On formatte le niveau pour un affichage homogène (cf : ann2 => A2)
    if ( strpos($people[$p]['promotion'], 'Ann') !== false ) {
      $temp = str_split($people[$p]['promotion']);
      $people[$p]['promotion'] = 'A' . $temp[3];
    }
    //changer Personnel en enseignant
    if ($people[$p]['promotion'] == 'Personnel') {
      $people[$p]['promotion']='Enseignant';
    }
    //on met pour les as leur promotion en classe pour le module creer son groupe
    if ( strpos($people[$p]['promotion'], 'As') !== false ) {
      $people[$p]['classe'] = $people[$p]['promotion'];
    }
  }

  //   //On ajoute la promotion à la BD
  //   try {
  //     //On vérifie d'abord si la promotion n'y est pas
  //     $sqlCheck = "SELECT * FROM Promotions WHERE niveau = :niveau";
  //     $reqCheck = bdd::$pdo->prepare($sqlCheck);
  //     $valCheck = array('niveau' => $buffPromo[$p]);
  //     $reqCheck->execute($valCheck);
  //     $check = $reqCheck->rowCount();
  //     //Si la promotion n'y est pas, on l'ajoute
  //     if ( $check == 0 ) {
  //       $sqlPromo = "INSERT INTO Promotions(niveau) VALUES (:lvl)";
  //       $reqPromo = bdd::$pdo->prepare($sqlPromo);
  //       $valPromo = array(':lvl' => $buffPromo[$p]);
  //       $reqPromo->execute($valPromo);
  //     }
  //   } catch (PDOException $e) {
  //     $return['error'] = $e->getMessage();
  //   }
  // }

  $return['users'] = array();
  

  //On passe maintenant aux utilisateurs
  for ($u=0; $u < count($people); $u++) {
    try {
      //On vérifie que l'utilisateur n'est pas déjà présent pour éviter tout doublon
      $sqlCheck = "SELECT * FROM Utilisateurs WHERE login = :log";
      $reqCheck = bdd::$pdo->prepare($sqlCheck);
      $valCheck = array('log' => $people[$u]['login']);
      $reqCheck->execute($valCheck);
      $check = $reqCheck->rowCount();
      //Si l'utilisateur n'est pas présent, on l'ajoute
      if ( $check == 0 ) {
        //On prépare d'abord les valeurs
        $temp = explode(" ", $people[$u]['nom']);
        $prenom = $temp[0];
        $nom = $temp[1];
        $login = $people[$u]['login'];
        $promotion = $people[$u]['promotion'];
        $classe =$people[$u]['classe'];

        //On ajoute l'utilisateur
          $sqlUser = "INSERT INTO Utilisateurs(login, nom, prenom, classe, promotion) VALUES (:log, :nom, :prenom, :classe, :promotion)";
          $reqUser = bdd::$pdo->prepare($sqlUser);
          $valUser = array(
            'log' => $login,
            'prenom' => $nom,
            'nom' => $prenom,
            'classe' => $classe,
            'promotion' => $promotion);
          $reqUser->execute($valUser);
          
        $return['nbImport']++;
        $return['users'][] = $valUser;
      }
    } catch (PDOException $e) {
      $return['error'] = $e->getMessage();
    }
  }

  ldap_close($ldap_conn);

  printf(json_encode($return));

 ?>
