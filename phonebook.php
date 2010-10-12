<?
include 'common.php';
foreach(range('A','Z') as $letter)
{
   echo "<div style='font-size:24px;'>$letter</div>";
   $q="select * from ps_users where level='Gold Member' and name like '$letter%' order by name";
   $r=@mysql_query($q);
   while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
   echo "<li>".$d[id].": ".strtoupper($d[name])." - $d[phone]   ________-_______-________</li>";
   }
} 
echo "<hr>";
   $q="select * from ps_users order by id ";
   $r=@mysql_query($q);
   while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
   echo $d[id]." :: ".strtoupper($d[name])."<br />";
	}


?>