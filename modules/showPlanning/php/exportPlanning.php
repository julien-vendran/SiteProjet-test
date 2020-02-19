<?php
  session_start();

  // Récupération du planning de l'étudiant
  require('getPlanning.php');
  $filename = "ProjectIntranetPlanning.ics";

  header('Content-type: text/calendar; charset=utf-8');
  header('Content-Disposition: attachment; filename=' . $filename);

  function dateToCal($timestamp) {
    return date('Ymd\THis\Z', $timestamp);
  }
  // Escapes a string of characters
  function escapeString($string) {
    return preg_replace('/([\,;])/','\\\$1', $string);
  }


  /*
  --------------------------------------------
  ---------- REMPLISSAGE DU FICHIER ----------
  --------------------------------------------
  */


// Ecriture de l'entete du fichier ics
?>
BEGIN:VCALENDAR
METHOD:REQUEST
PRODID:-//Planning-iCal Version 0.1
VERSION:1.0
CALSCALE:GREGORIAN
<?php

  // Récupération de la date courante
  $dat_cur = dateToCal(time());

  // Ecriture de chaque évènement
  foreach($return['planning'] as $event){
    $date = "{$event['date']['y']}{$event['date']['m']}{$event['date']['d']}";
    if($event['h'] != 0){
      $date .= "T{$event['h']}{$event['mn']}{$event['w']}Z";
      $dateFin ="DTEND:{$event['y']}{$event['m']}{$event['d']}T{$event['h']}{$event['mn']}{$event['w']}Z";
    }
    ?>
BEGIN:VEVENT
DTSTAMP:<?= dateToCal(time())."\n" ?>
DTSTART:<?= $date."\n" ?>
<?php
    if($dateFin != ""){
      echo $dateFin."\n";
    }
?>
SUMMARY:<?= escapeString($event['title'])."\n" ?>
DESCRIPTION:<?= escapeString($event['desc'])."\n" ?>
UID:<?= uniqid()."\n" ?>
SEQUENCE:<?= $event["id"]."\n" ?>
END:VEVENT
<?php
  }

  // Ecriture Fin ics
?>
END:VCALENDAR
