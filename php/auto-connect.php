<?php

  $return = array(
    'error' => 0,
    'logs' => ""
  );

  if(!isset($_COOKIE["auto"]) || empty($_COOKIE["auto"])) $return["error"] = 1;
  else $return["logs"] = $_COOKIE["auto"];

  print json_encode($return);

 ?>
