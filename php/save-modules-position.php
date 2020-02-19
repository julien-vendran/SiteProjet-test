<?php

  $return = array(
    'error' => 0
  );

  if(!isset($_POST["list"]) || empty($_POST["list"])) {
    $return["error"] = 1;
    exit();
  } else $chain = $_POST["list"];

  try {

    // on créé un cookie avec la liste des modules, valable 60 jours (renouvelé par la suite)
    setcookie("modulesPosition", $chain, time() + 60*24*3600);

  } catch (Exception $e) {

    $return["error"] = $e->getMessage();

  }

  print json_encode($return);

 ?>
