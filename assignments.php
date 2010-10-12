<h1>MSWS Daily Project Assignments</h1>
<meta http-equiv="refresh" content="300" />
<?
mysql_connect();
mysql_select_db('core');
$r=@mysql_query("select * from staff");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
?>

<li><?=$d[name];?> is to be working on <b><?=$d[assignment];?></b><? if ($d[assignment2]){ echo ", and <b>$d[assignment2]</b> as it becomes ready for processing."; }?></li><br>


<? } ?>
<h2>Upon completion of your project see zach or patrick.</h2>
<pre><?=system('tail /logs/user.log');?></pre>
<meta 