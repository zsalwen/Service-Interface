<meta http-equiv="refresh" content="1" />

<?php
function ae_gen_password($syllables = 3, $use_prefix = false)
{

    // Define function unless it is already exists
    if (!function_exists('ae_arr'))
    {
        // This function returns random array element
        function ae_arr(&$arr)
        {
            return $arr[rand(0, sizeof($arr)-1)];
        }
    }

    // 20 prefixes
    $prefix = array('aero', 'anti', 'auto', 'bi', 'bio',
                    'cine', 'deca', 'demo', 'dyna', 'eco',
                    'ergo', 'geo', 'gyno', 'hypo', 'kilo',
                    'mega', 'tera', 'mini', 'nano', 'duo');

    // 10 random suffixes
    $suffix = array('dom', 'ity', 'ment', 'sion', 'ness',
                    'ence', 'er', 'ist', 'tion', 'or'); 

    // 8 vowel sounds 
    $vowels = array('a', 'o', 'e', 'i', 'y', 'u', 'ou', 'oo'); 

    // 20 random consonants 
    $consonants = array('w', 'r', 't', 'p', 's', 'd', 'f', 'g', 'h', 'j', 
                        'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'qu');

    $password = $use_prefix?ae_arr($prefix):'';
    $password_suffix = ae_arr($suffix);

    for($i=0; $i<$syllables; $i++)
    {
        // selecting random consonant
        $doubles = array('n', 'm', 't', 's');
        $c = ae_arr($consonants);
        if (in_array($c, $doubles)&&($i!=0)) { // maybe double it
            if (rand(0, 2) == 1) // 33% probability
                $c .= $c;
        }
        $password .= $c;
        //

        // selecting random vowel
        $password .= ae_arr($vowels);

        if ($i == $syllables - 1) // if suffix begin with vovel
            if (in_array($password_suffix[0], $vowels)) // add one more consonant 
                $password .= ae_arr($consonants);

    }
	$num=rand(2,9);
    // selecting random suffix
    $password .= $num.ucfirst($password_suffix);

    return $password;
}
?>




<!-- don't forget to paste code of ae_gen_password function 
(see above) here -->
<table border="1"><tr><td>
<h2>2 syllables, no prefix</h2>
<ul>
<?php 
for($i=0; $i<10; $i++)
    echo "<li>".strlen(ae_gen_password(2, false))." : ".ae_gen_password(2, false)."</li>";
?>
</ul>
</td><td>
<h2>2 syllables, prefix</h2>
<ul>
<?php 
for($i=0; $i<10; $i++)
    echo "<li>".strlen(ae_gen_password(2, true))." : ".ae_gen_password(2, true)."</li>";
?>
</ul>

</td><td>

<h2>3 syllables, no prefix</h2>
<ul>
<?php 
for($i=0; $i<10; $i++)
    echo "<li>".strlen(ae_gen_password(3, false))." : ".ae_gen_password(3, false)."</li>";
?>
</ul>
</td><td>

<h2>3 syllables, prefix</h2>
<ul>
<?php 
for($i=0; $i<10; $i++)
    echo "<li>".strlen(ae_gen_password(3, true))." : ".ae_gen_password(3, true)."</li>";
?>
</ul>    
</td></tr></table>