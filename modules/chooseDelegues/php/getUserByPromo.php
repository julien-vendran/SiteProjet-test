<?php

  require '../../../config/ldap.php';

  $return = array(
    'error' => 0,
    'users' => array());

  // On récupère les utilisateurs et leur promotion respective
  $search = ldap_search($ldap_conn, $ldap_basedn, "(objectClass=person)");

  //On récupère toutes les entrées de la recherche effectuées auparavant
  $resultats = ldap_get_entries($ldap_conn, $search);

  //Pour chaque utilisateur, on récupère les informations utiles
  for ($i=0; $i < count($resultats) - 1 ; $i++) {
    // On prépare le nom et le prénom
    $buffer = explode(" ", $resultats[$i]['displayname'][0]);
    $nom = $buffer[1];
    $prenom = $buffer[0];

    // On prépare la promotion
    if ( strpos(explode("=", explode(",", $resultats[$i]['dn'])[1])[1], 'Ann') !== false ) {
      $temp = str_split(explode("=", explode(",", $resultats[$i]['dn'])[1])[1]);
      $promo = 'A' . $temp[3];
    } else {
      $promo = $resultats[$i]['sn'][0];
    }

    //On stocke le login, nom/prénom et la promotion de l'utilisateur courant
    $user = array(
      'login' => $resultats[$i]["uid"][0],
      'nom' => $nom,
      'prenom' => $prenom,
      'promotion' => $promo);

    //On vérifie que la promotion n'est pas 'employe'
    //Si ce n'est pas le cas, on le sauvegarde
    if ( $user['promotion'] != 'employe' ) {
      $return['users'][] = $user;
    }
  }

  ldap_close($ldap_conn);

  printf(json_encode($return));

 ?>
