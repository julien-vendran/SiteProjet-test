<?php

  $return = array('error' => 0);

  $buffer = scandir("../saves");
  //On supprime les 2 premières valeurs ('.' et '..') à cause du répertoire distant
  array_shift($buffer);
  array_shift($buffer);
  
  $return['saves'] = $buffer;
  $return['error'] = is_array($return['save']) ? 0 : 1;

  printf(json_encode($return));

 ?>
