<?php

Class nbProject {
    static public function nbprojActif(){
        /* Recherche */
        $del =  bdd::$pdo->query(' SELECT * FROM Projets p JOIN Utilisateurs u ON p.tuteur = u.login
                                  WHERE actif = 1');
        $del->execute();

        /* Retourne le nombre de lignes effacées */
        $count = $del->rowCount();
        return $count;

    }

    static public function nbprojActifDeuxiemeAnnee(){
        /* Recherche */
        $del =  bdd::$pdo->query(" SELECT * FROM Projets p JOIN Utilisateurs u ON p.tuteur = u.login
                                  WHERE actif = 1 AND p.promotion ='A2' ");
        $del->execute();

        /* Retourne le nombre de lignes effacées */
        $count = $del->rowCount();
        return $count;
    }
    static public function nbprojActifLicence(){
        /* Recherche */
        $del =  bdd::$pdo->query(" SELECT * FROM Projets p JOIN Utilisateurs u ON p.tuteur = u.login
                                  WHERE actif = 1 AND p.promotion ='Licence' ");
        $del->execute();

        /* Retourne le nombre de lignes effacées */
        $count = $del->rowCount();
        return $count;
    }
    static public function nbprojActifAnneeSpeciale(){
        /* Recherche */
        $del =  bdd::$pdo->query(" SELECT * FROM Projets p JOIN Utilisateurs u ON p.tuteur = u.login
                                  WHERE actif = 1 AND p.promotion ='As' ");
        $del->execute();

        /* Retourne le nombre de lignes effacées */
        $count = $del->rowCount();
        return $count;
    }

    static public function nbprojInactif(){
        /* Recherche */
        $del =  bdd::$pdo->query(" SELECT * FROM Projets p JOIN Utilisateurs u ON p.tuteur = u.login
                                  WHERE actif = 0 ");
        $del->execute();

        /* Retourne le nombre de lignes effacées */
        $count = $del->rowCount();
        return $count;
    }

    static public function nbprojInactifDeuxiemeAnne(){
        /* Recherche */
        $del =  bdd::$pdo->query(" SELECT * FROM Projets p JOIN Utilisateurs u ON p.tuteur = u.login
                                  WHERE actif = 0 AND p.promotion ='A2' ");
        $del->execute();

        /* Retourne le nombre de lignes effacées */
        $count = $del->rowCount();
        return $count;
    }

    static public function nbprojInactifLicence(){
        /* Recherche */
        $del =  bdd::$pdo->query(" SELECT * FROM Projets p JOIN Utilisateurs u ON p.tuteur = u.login
                                  WHERE actif = 0 AND p.promotion ='Licence' ");
        $del->execute();

        /* Retourne le nombre de lignes effacées */
        $count = $del->rowCount();
        return $count;
    }

    static public function nbprojInactifAnneeSpeciale(){
        /* Recherche */
        $del =  bdd::$pdo->query(" SELECT * FROM Projets p JOIN Utilisateurs u ON p.tuteur = u.login
                                  WHERE actif = 0 AND p.promotion ='As' ");
        $del->execute();

        /* Retourne le nombre de lignes effacées */
        $count = $del->rowCount();
        return $count;
    }

    static public function nbprojTotal(){
        /* Recherche */
        $del =  bdd::$pdo->query(" SELECT * FROM Projets p JOIN Utilisateurs u ON p.tuteur = u.login
                                   ");
        $del->execute();

        /* Retourne le nombre de lignes effacées */
        $count = $del->rowCount();
        return $count;
    }

}



?>