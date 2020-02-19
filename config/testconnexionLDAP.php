<?php
	$ldap_host='10.10.1.30';
	$identifiant='etuda1';
	$pass= '123';
	$dn = "uid=".$identifiant.",ou=Ann1,ou=Etudiants,ou=People,dc=info,dc=iutmontp,dc=univ-montp2,dc=fr";
	$idldap =(ldap_connect($ldap_host)); /* on établit une connexion au serveur ldap on obtient un identifiant de connexion */
	ldap_set_option($idldap,LDAP_OPT_PROTOCOL_VERSION,3);
	if (ldap_set_option($idldap, LDAP_OPT_PROTOCOL_VERSION, 3)) /* on utilisera le protocole ldap version 3 */
	{
    	echo "Using LDAPv3";
	} else {
    	echo "Failed to set protocol version to 3";
	}
			if ($idldap)
			{				
			echo ("idldap : ".$idldap);
			$rt= ldap_bind($idldap,$dn,$pass);
			echo "ldap_bind= ".$rt;

				if( $rt !== false ) 

				{	$logged_in = true;
					echo ("connexion ldap OK");
				}
				else
				{ echo "Pas de connexion LDAP "; }
}	

    ldap_set_option($idldap, LDAP_OPT_SIZELIMIT, 3000);
    
    
    $ldap_basedn = "dc=info,dc=iutmontp,dc=univ-montp2,dc=fr";
    //On recherche toutes les entrées du LDAP qui sont des personnes
    $search = ldap_search($idldap, $ldap_basedn, "(objectClass=person)");
    
    echo ldap_count_entries($idldap,$search);
    ?>
