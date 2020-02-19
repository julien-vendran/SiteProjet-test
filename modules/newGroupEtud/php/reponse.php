<?php
	require '../../../config/DB.php';

    //lors de la validation du groupe dun user
	if (isset($_GET['accept']) && isset($_GET['login']) && isset($_GET['validGroup'])) {//regarde si le lien est correct
        //on recupere le loginChef du groupe de l'user
		$sql2="SELECT loginChef FROM Groupe WHERE loginChef='".$_GET['login']."' OR login2='".$_GET['login']."' OR login3='".$_GET['login']."' OR login4='".$_GET['login']."' OR login5='".$_GET['login']."' OR login6='".$_GET['login']."'";
    	$rep2 = bdd::$pdo->query($sql2);
    	$result2 = $rep2->fetchAll();

    	if ($result2[0]['loginChef'] != null) {//si le groupe existe
            //on recupere le validGroup de l'user
    		$sql="SELECT validGroup FROM Utilisateurs WHERE login='".$_GET['login']."'";
	    	$rep = bdd::$pdo->query($sql);
	    	$result = $rep->fetchAll();

			if ($result[0]["validGroup"] == $_GET['validGroup']) {//on regarde si le validGroupe passer est le bon 
				if ($_GET['accept'] == "oui") { //si accepte
                    //met à null l'attribut validGroup de l'user
					$sql = "UPDATE Utilisateurs SET validGroup=NULL WHERE login='".$_GET['login']."'";
	      			bdd::$pdo->query($sql);
	      			echo "Votre accéptation a été pris en compte.";
                    //et regarde si tous les users ont valide pour creer le groupe
	      			majGroup($_GET['login']);
				}else{//si reffuse
                    //on supprime le groupe
					deleteGroup($_GET['login']);
					echo "Votre refus a été pris en compte. Le groupe est bien été supprimé.";
				}
			}else{
				echo "error";
			}
    	}else{
    		echo "Le groupe à été supprimé.";
    	}

		
	}

    //met a jour le groupe, si tous les users ont validé ont creer le groupe
	function majGroup($login){
		$sql="SELECT loginChef FROM Groupe WHERE loginChef='".$_GET['login']."' OR login2='".$_GET['login']."' OR login3='".$_GET['login']."' OR login4='".$_GET['login']."' OR login5='".$_GET['login']."' OR login6='".$_GET['login']."'";
    	$rep = bdd::$pdo->query($sql);
    	$result = $rep->fetchAll();

    	$sql2="SELECT loginChef,login2, login3, login4, login5, login6 FROM Groupe WHERE loginChef='".$result[0]["loginChef"]."'";
    	$rep2 = bdd::$pdo->query($sql2);
    	$result2 = $rep2->fetchAll();

    	$actif="true";
    	$compteur=0;
    	while ( $compteur <= 5 && $actif==true) {//parcour tous les users du groupe
    		if ($result2[0][$compteur] != null) {//si user existe
    			$sql3="SELECT validGroup FROM Utilisateurs WHERE login='".$result2[0][$compteur]."'";
    			$rep3 = bdd::$pdo->query($sql3);
    			$result3 = $rep3->fetchAll();
    			if ($result3[0]["validGroup"] != null) {
    				$actif="false";
    			}

    		}
    		$compteur++;
    	}
    	if ($actif == "true") {
    		$sql3="UPDATE Groupe SET actif='1' WHERE loginChef='".$result[0]["loginChef"]."'";
    		$rep3 = bdd::$pdo->query($sql3);
    		echo " Le groupe est créer.";
    		envoieMail($result2,"create");
    	}
	}

    //supprime le groupe
	function deleteGroup($login){
		$sql="SELECT loginChef FROM Groupe WHERE loginChef='".$_GET['login']."' OR login2='".$_GET['login']."' OR login3='".$_GET['login']."' OR login4='".$_GET['login']."' OR login5='".$_GET['login']."' OR login6='".$_GET['login']."'";
    	$rep = bdd::$pdo->query($sql);
    	$result = $rep->fetchAll();

    	$sql2="SELECT loginChef,login2, login3, login4, login5, login6 FROM Groupe WHERE loginChef='".$result[0]["loginChef"]."'";
    	$rep2 = bdd::$pdo->query($sql2);
    	$result2 = $rep2->fetchAll();

        //on met a null les validGroup de tous les users du groupe
    	$compteur=0;
    	while ( $compteur <= 5 ) {//parcour tous les users du groupe
    		if ($result2[0][$compteur] != null) {//si user existe
    			$sql3="UPDATE Utilisateurs SET validGroup=null WHERE login='".$result2[0][$compteur]."'";
    			$rep3 = bdd::$pdo->query($sql3);
    		}
    		$compteur++;
    	}
        //on supprime le groupe
    	$sql4="DELETE FROM Groupe WHERE loginChef='".$result[0]["loginChef"]."'";
    	$rep4 = bdd::$pdo->query($sql4);
    	envoieMail($result2,"delete");
	}

    //envoie le mail au users du groupe selon si le groupe est creer ou supprimer
	function envoieMail($tab,$option){
		$compteur=0;
    	while ( $compteur <= 5 ) {
    		if ($tab[0][$compteur] != null) {
	    		$sql="SELECT prenom, nom FROM Utilisateurs WHERE login='".$tab[0][$compteur]."'";
			    $rep = bdd::$pdo->query($sql);
			    $result = $rep->fetchAll();
			    $mail=$result[0]["prenom"].".".$result[0]["nom"]."@yopmail.com";
			    //$mail="bob@yopmail.com";
			    $subject="Affectation des projets";
			    if ($option == "create") {
			    	$message="Bonjour ".$result[0]["prenom"]."<br> Tous les membres du groupe ont accepter. Le groupe a été créer.";
			    }else{
			    	$message="Bonjour ".$result[0]["prenom"]."<br> Un des membres du groupe à refuser. Le groupe a été supprimé.";
			    }
			    mail($mail,$subject,$message);
    		}
    		$compteur++;
    	}
	}

    echo '<br><a href="../../.." >Retour au menu</a>';
?>