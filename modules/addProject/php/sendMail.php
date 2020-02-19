<?php
session_start();
$return = array(
    "error" => 0
);
$date = new DateTime();
try {
            $mail = 'Bonjour,
                                        Monsieur : ' . $_SESSION['uid'] . ' 
                                        A créer un projet : ' . $_POST['titre'] . ' 
                                        Promotion : '. $_POST['promotion'] .'
                                        Date de création : '. $date->format('d/m/Y').'                          
                                    ';
            mail("bobtestmail@yopmail.com", 'Création d\' un projet', $mail);
}
catch (Exception $e) {
    $return["error"] = $e->getMessage();
}

print json_encode($return);
?>