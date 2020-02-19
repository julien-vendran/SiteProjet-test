<?php

  // la fonction convertAffectations permet de convertir le fichier texte contenant la liste des affectations en un tableau dynamique php
  //   (pour un traitement en javascript par exemple)
  // convertAffectations prend en compte un seul argument :
  //   un handler, c'est un pointer vers un fichier txt OUVERT (c'est ce que renvoie la fonction fopen)
  
  function convertAffectations($handle) {
    
    // on initialise le tableau qui sera retourné
    $container = array();
    
    $i = 0;

    // on parcours, ligne par ligne, le fichier txt (avec $i comme compteur)
    while (($buffer = fgets($handle, 4096)) !== false) {
      preg_match_all("#^Groupe_([aA-zZ]+?) .+? projet_Projet_([0-9]+?)_#isU", $buffer, $out, PREG_PATTERN_ORDER);
      
      if (ctype_digit($out[2][0])) {//regarde ligne valide
         $container[$i]["group"] = $out[1][0];
         $container[$i]["project"] = $out[2][0];
       } 
        

      $i++;
    }
    //print_r($container);
    // enfin, on renvoie le tableau converti
    return $container;
  }

?>
