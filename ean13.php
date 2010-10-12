<?php

	include_once('ean13class.php');
	
	$ean13 = new ean13;
	$ean13->article = '1234-1a';   // initial article code
	$ean13->article .= $ean13->generate_checksum();   // add the proper checksum value
	$ean13->reverse();   // the string is printed backwards
	$ean13->article = $ean13->codestring();   // returns a string as input for the truetype font
	$ean13->create_image();   // render the image as PNG image

?>
