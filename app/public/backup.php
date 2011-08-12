<?php
	
	$directorio = substr($_SERVER["SCRIPT_FILENAME"],0,strrpos($_SERVER["SCRIPT_FILENAME"],"/"));
	
	$url = $directorio;
	
	$directorio = substr($directorio,0,strrpos($directorio,"/"));
	$directorio = substr($directorio,0,strrpos($directorio,"/"));
	
	$nombre = substr($directorio,strrpos($directorio,"/")+1).".zip";
	
	$url .= "/".$nombre;
	
	if(file_exists($url)){
		unlink($url);
	}
	
	include($directorio."/core/vendors/pclzip/pclzip.php");
	
	$zip = new PclZip($nombre);
	$zip -> create($directorio,PCLZIP_OPT_REMOVE_ALL_PATH);
	
	header ("Content-Disposition: attachment; filename=".$nombre."\n\n"); 
	header ("Content-Type: application/octet-stream");
	header ("Content-Length: ".filesize($url));
	readfile($url);
?>

<?php
	//$directorio=opendir($dir); 
	//echo "<b>Directorio actual:</b><br>$dir<br>"; 
	//echo "<b>Archivos:</b><br>"; 
	//while ($archivo = readdir($directorio))
	  //echo "$archivo<br>"; 
	//closedir($directorio); 
?>