<?php

  $return = array('error' => 0);

  $data = $_POST['data'];

  $fileName = "../saves/save_de_" . date('Y') . ".json";
  $file = fopen($fileName, "w");
  $toWrite = json_decode($data);

  if ( $file ) {
    $return['error'] = ( fwrite($file, $data) > 0) ? 0 : 1;
  } else {
    $return['error'] = 2;
  }

  printf(json_encode($return));

 ?>
