<?php

session_start();

    $user = $_GET['user'];
    $level = $_GET['level'];
  
    
    echo "before<br/>";
    print_r ($_SESSION);
    
//if ($_SESSION["uid"] == 'projets') {
    $_SESSION["uid"] = $user;
    $_SESSION["level"][0] = $level;
//}

    echo "<br/>after<br/>";
print_r ($_SESSION);

 //  0 = etudiant, 1 = chef de projet, 2 = chef de groupe/délégué, 3 = enseignant, 4 = admin
 
//header('Location: ./index.php');
    
?>
