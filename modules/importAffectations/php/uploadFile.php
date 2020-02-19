<?php
  
  $storeFolder = '../../../tmp/';
  
  if(!empty($_FILES)) {
      $tempFile = $_FILES['file']['tmp_name'];         
        
      $targetPath = $storeFolder;
  
      $fileName = $_FILES['file']['name'];
  
      $namelist = array();
  
      $dir = opendir($targetPath);
  
      while($file = readdir($dir)) {
        if($file != '.' && $file != '..' && !is_dir($targetPath.$file)) {
          $namelist[] = $file;
        }
      }
  
      closedir($dir);
  
      $characts            = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';  
      $characts           .= '1234567890'; 
  
      do {
        $fileName = ''; 
  
        for($i=0;$i < 5;$i++) { 
          $fileName .= substr($characts,rand()%(strlen($characts)),1); 
        }
      } while(in_array($fileName, $namelist));
       
      $targetFile =  $targetPath . $fileName . '.txt';
   
      if(move_uploaded_file($tempFile, $targetFile))
        echo $fileName . '.txt';
  }

?>
