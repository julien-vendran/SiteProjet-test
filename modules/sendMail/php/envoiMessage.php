<?php

	require '../../../config/DB.php';

	$return = array('error' => 0);

	// On récupère le niveau a qui est adressé le mail
	$niveau = $_POST['niveau'];
	//On récupère les infos du message
	$contenu = $_POST['corps'];
	$objet = $_POST['objet'];


	// On prépare la requête en fonction du niveau visé
switch ($niveau) {
	case "A2":
		$promo = "ufr-iut-ms-info-a2@etu.umontpellier.fr";
		break;

	case "Enseignant":
		// Cas des responsables de TD/délégués
		$promo = "iutms-info-personnel@umontpellier.fr";
		break;
	case "Licence":
		// Cas des responsables de TD/délégués
		$promo = "ufr-iut-ms-info-lp@etu.umontpellier.fr";
		break;
	case "As":
		// Cas des responsables de TD/délégués
		$promo = "ufr-iut-ms-info-as@etu.umontpellier.fr";
		break;
	case "A1":
		// Cas des responsables de TD/délégués
		$promo = "ufr-iut-ms-info-a1@etu.umontpellier.fr";
		break;

	}

	// On génére les mails des étudiants et on envoi le mail
	$return['mails'] = array();

	$mail = $promo;
	// NOTE: Changer la ligne ci-dessous pour mettre en activité
	$return['mails'][] = mail($mail, $objet, $contenu);

	printf(json_encode($return));

 ?>
