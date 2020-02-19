<?php

    error_reporting(E_ERROR  | E_PARSE);
    ini_set('error_reporting', E_ERROR | E_PARSE);
    
  // on définit les paramètres de la connexion LDAP
  $ldap_host = "10.10.1.30";
  $ldap_basedn = "dc=info,dc=iutmontp,dc=univ-montp2,dc=fr";
  $ldap_baseorganization = "ou=People";
  $ldap_port = 389;
  $ldap_conn = false;

  // on se connecte au serveur LDAP
  $ldap_conn = ldap_connect($ldap_host, $ldap_port)
    or die("Impossible de se connecter au serveur LDAP $ldap_host");

  // on définit la version du module LDAP
  ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

 ?>
