<?php

	class bdd {

		static $conf = array(
			'host' => 'webinfo.iutmontp.univ-montp2.fr',
			'dbname' => 'projet_projets',
			'login' => 'projet_projets',
			'password' => 'projet_projets_IUT2020');
//P0709rc
		static $pdo;

		static function start() {
			try {
				// On récupère les variables permettant d'avoir accès à la base de données
				$host = self::$conf['host'];
				$dbname = self::$conf['dbname'];
				$login = self::$conf['login'];
				$password = self::$conf['password'];

				//On se connecte à la base de données et on définie les attributs du PDO
				self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $login, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
			} catch (Exception $e) {
				echo "Erreur : " . $e->getMessage();
			}

		}

	}

	bdd::start();

?>
