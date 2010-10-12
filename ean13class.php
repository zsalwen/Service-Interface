<?php

/***************************************************************************
*
* This code is more or less based on th excellent information published at
* http://grandzebu.net/index.php?page=/informatique/codbar-en/ean13.htm.
* The autor of this PHP code is not related to the website in any way.
*
* The EAN-13 barcode is the base for all consumer products, consisting of a
* 12-digit article code and a checksum digit. Only the article code is used for
* input, the rest is calculated. The code can output the checksum, the full EAN 13
* string and even a PNG image with the complete barcode. For this to work, you
* need a Truetype font with the ean13 code in it. This can be downloaded from the
* above website. Also, the PHP-GD library is required on your webserver in order
* to work.
*
* This program is free software; you can redistribute it and/or modify it under
* the terms of the GNU General Public License as published by the Free Software
* Foundation; either version 2 of the License, or (at your option) any later
* version.
*
***************************************************************************/

class ean13 {

	var $article;
	var $fontfile;
	var $fontsize;
	
	function ean13() {
		$this->fontfile = '/var/www/fonts/ean13.ttf';  // full, absolute server path to the truetype font file
		$this->fontsize = 50;   // height of the image to be generated
	}
	
	function generate_checksum() {   // calculated the 13th digit based
		$odd = true;
		$checksum = 0;
		$key = range(0, 9);
		for ($i=strlen($this->article); $i>0; $i--) {
			if ($odd) {
				$odd = false;
				$multiplier = 3;
			}	else {
				$odd = true;
				$multiplier = 1;
			}
			$checksum += $key[$this->article[$i-1]] * $multiplier;
		}
		$checksum = 10 - $checksum % 10;
		$checksum = ($checksum == 10) ? 0 : $checksum;
		return $checksum;
	}

	function reverse() {   // the article code and checksum are printed from right to left
		$this->article = strrev($this->article);
	}

	function codestring() {   // generate a string from the 13 digits to be used by the ttf
		$string = substr($this->article,0,1).chr(65 + substr($this->article,1,1));
		$first = substr($this->article,0,1);
		for ($i=3; $i<=7; $i++) {
			$in_a = false;
			switch ($i) {
				case 3:
					$in_a = in_array($first, array(0, 1, 2, 3)) ? true : false;
					break;
				case 4:
					$in_a = in_array($first, array(0, 4, 7, 8)) ? true : false;
					break;
				case 5:
					$in_a = in_array($first, array(0, 1, 4, 5, 9)) ? true : false;
					break;
				case 6:
					$in_a = in_array($first, array(0, 2, 5, 6, 7)) ? true : false;
					break;
				case 7:
					$in_a = in_array($first, array(0, 3, 6, 8, 9)) ? true : false;
					break;
			}
			if ($in_a) {
				$string = $string.chr(65 + substr($this->article, ($i-1), 1));
			} else {
				$string = $string.chr(75 + substr($this->article, ($i-1), 1));
			}
		}
		$string = $string.'*';
		for ($i=8; $i<=13; $i++) {
			$string = $string.chr(97 + substr($this->article, ($i-1), 1));
		}
		$string = $string.'+';
		return $string;
	}

	function create_image() {   // build a PNG image from the generated codestring
		header('Content-type: image/png');
		$box = ImageTTFbbox($this->fontsize, 0, $this->fontfile, $this->article);
		$src_img = ImageCreate(($box[2]+11), (abs($box[7]-$box[1])+6));
		$black = ImageColorAllocate($src_img, 0x00, 0x00, 0x00);
		$white = ImageColorAllocate($src_img, 0xff, 0xff, 0xff);
		ImageFill($src_img, 0, 0, $white);
		ImageColorTransparent($src_img, $white);
		ImageTTFText($src_img, $this->fontsize, 0, 3, abs($box[7]), $black, $this->fontfile, $this->article);
		ImagePNG($src_img);
		ImageDestroy($src_img);
	}
}

?>
