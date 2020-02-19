<?php

  $return = array(
    'error' => 0,
    'sent' => ""
  );

  if(!isset($_POST["list"]) || empty($_POST["list"])) {
    $return["error"] = 1;
    exit();
  } else $chain = $_POST["list"];

  try {

    // on créé un cookie avec la liste des modules, valable 1 an
    setcookie("modulesPosition", $chain, time() + 365*24*3600);

  } catch (Exception $e) {

    $return["error"] = $e->getMessage();

  }

  print json_encode($return);

 ?>
