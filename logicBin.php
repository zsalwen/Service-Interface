<ol>
<?
mysql_connect();
mysql_select_db('core');
$masterList=array();
$mainListResource = @mysql_query("SELECT DISTINCT method from ps_affidavits");
while ($mainList=mysql_fetch_array($mainListResource,MYSQL_ASSOC)){
	
	$thisList = explode(" ",$mainList[method]);
	$masterList = array_merge($masterList, $thisList);
	echo "<li>$mainList[method]</li>";
}
?>
</ol>



<ol>
<?
$uniqueList= array_unique($masterList);

$countList=array_count_values($masterList);

foreach ($countList as $word => $count) {
   echo "<div style='font-size:".$count."'>".$word."</div>";
}
?>
</ol>