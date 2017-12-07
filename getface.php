<?php
	
ini_set("display_errors", true);
error_reporting(E_ALL);
     

$trimmedfiles = array(); 


$files = scan_dir('in');

foreach($files as $file)
{
	switch(ltrim(strstr($file, '.'), '.'))
	   {
		     case "jpg": case"jpeg": 
		     $pathtofile = "in/".$file; 
		       
		     $facebox = json_decode(checkFacebox($pathtofile),true);
		     $facescount = $facebox['facesCount'];

		     if ($facescount !== 1) {
		     	echo("There is less than or greater than 1 face in this photo ");
		     	echo($pathtofile);
		     	echo nl2br ("...\r\n") ;
		     	 
		     }

		     else {

		     	$im = imagecreatefromjpeg($pathtofile);

			    if ($im !== FALSE) {
			    	$facetop = $facebox['faces'][0]['rect']['top'];
			    	$faceleft = $facebox['faces'][0]['rect']['left'];
			    	$facewidth = $facebox['faces'][0]['rect']['width'];
			    	$faceheight = $facebox['faces'][0]['rect']['height'];

			    	$im2 = imagecrop($im, ['x' => $faceleft, 'y' => $facetop, 'width' => $facewidth+20, 'height' => $faceheight+20]);
					if ($im2 !== FALSE) {
					    imagejpeg($im2, 'out/cropped_'.$file);
					    echo(" Completed ");
					    echo($pathtofile);
					    echo nl2br ("\r\n") ;
					}
					else {
						echo nl2br ("Error with the imagecrop function\r\n");
					}
			    }
			    else {
			    	echo nl2br ("Error creating image from original JPEG\r\n");
			    }

	     	} 
	   }
}

die;

		        
function checkFacebox($a) {

	if (function_exists('curl_file_create')) { // php 5.5+
							  $cFile = curl_file_create($a);
							} else { // 
							  $cFile = '@' . realpath($a);
							}

	$body = ['file'=>$cFile];
	$ch = curl_init();
                             
          curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/facebox/check");
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          
          $result = curl_exec($ch);
         
          curl_close($ch);
          return $result;

}		

function scan_dir($dir) {
	    $ignored = array('.', '..', '.svn', '.htaccess');

	    $files = array();    
	    foreach (scandir($dir) as $file) {
	        if (in_array($file, $ignored)) continue;
	        $files[$file] = filemtime($dir . '/' . $file);
	    }

	    arsort($files);
	    $files = array_keys($files);

	    return ($files) ? $files : false;
}

?>