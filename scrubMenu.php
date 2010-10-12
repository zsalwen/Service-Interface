<?php

function search($search,$string){
			$pos = strpos($string, $search);
			if ($pos === false) {
				$pass = "";
			} else {
				$pass = $string;
			}
	return $pass;
}
    function Title($filename) {
        //$title = substr($filename, 0, strlen($filename) - 5);
        $title = str_replace('-', ' ', $filename);
        $title = str_replace('_', ' ', $title);
        $title = str_replace('.', ' ', $title);
        $title = str_replace('php', '', $title);
        $title = str_replace('js', '', $title);
        $title = str_replace('html', '', $title);
        $title = ucwords($title);
        return $title;
    }

function scrub($type){

    // read all html file in the current directory
    if ($dh = opendir('./')) {
        $files = array();
        while (($file = readdir($dh)) !== false) {
            if (search($type,$file)) {
                array_push($files, $file);
            }
        }
        closedir($dh);
    }
   
    // Sort the files and display
    sort($files);
    //echo "<ul>\n";
    foreach ($files as $file) {
        $title = Title($file);
        if ($title){ echo "<a href=\"$file\" title=\"$title\">$title</a><br>"; }
    }
    //echo "</ul>\n";
   
    // Function to get a human readable title from the filename
}	
?>
++PHP++<br>
<?=scrub('.php');?>
<br><br>++JAVASCRIPT++<br>
<?=scrub('.js');?>
<br><br>++HTML++<br>
<?=scrub('.html');?>
