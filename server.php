<?
if ($_SERVER[HTTP_HOST] != 'service.mdwestserve.com'){ header('Location: http://service.mdwestserve.com/server.php'); }
include 'common.php';
include 'menu.php';
?>
<table><tr><td valign="top"><style>form { padding:0px; margin:0px;}</style>
<table><tr><td valign="top"><iframe width="300" height="300" src="alertList.php" overflow="auto" frameborder="0"></iframe></td><td valign="top">
<div align="center"><a href="zeitachse.php">Timeline,</a></div>
<table bgcolor="#FFFFFF" width="98%" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td align="center" onClick="window.location.href='wizard.php'" valign="top" class="desc">Wizard,</td>
	</tr><tr>
    	<td align="center" onClick="window.location.href='ps_worksheet.php'" valign="top" class="desc">Active,</td>
	</tr><tr>
    	<td align="center" onClick="window.location.href='ps_worksheet.php?all=1'" valign="top" class="desc">Files,</td>
	</tr><tr>
        <td align="center" onClick="window.location.href='photoCheck.php'" valign="top" class="desc"><b>Photos,</b></td>
	</tr><tr>
    	<td align="center" onClick="window.location.href='ps_profile.php'" valign="top" class="desc">Settings,</td>
	</tr><tr>
    	<td align="center" onClick="window.location.href='logout.php'" valign="top" class="desc">Exit</td>
    </tr>
</table>
</td></tr></table>
<style>
img { height:100px; width:100px}
.desc{
	font-size:14px;
	font-variant:small-caps;
	cursor:pointer;
}
</style>
<style>
.icon { cursor:pointer }
a, li {text-decoration:none; color:#336699;}
input { padding:0px; background-color:#FFcccc;}
/*li {background-color:#000000; color:#FFFFFF; text-decoration:none;}*/
</style>



<table width="100%" border="1">
	<tr><td colspan="7" style="font-size:18px; color:#FF0000" align="center"><?=$_COOKIE[psdata][name]?>'s File Activity</td></tr>
    <tr>
<td valign="top" nowrap="nowrap">        
<div align="center" style="background-color:#99ff22"><strong>!! Eviction Cases !!</strong></div>
<?
$r=@mysql_query("select * from evictionPackets where server_id='".$_COOKIE[psdata][user_id]."' order by eviction_id DESC limit 0,5");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
?>
		<li>#<?=$d[eviction_id]?> <?=substr($d[date_received],0,10)?></li>
<? }?>
</td>
<td valign="top" nowrap="nowrap">        
<div align="center" style="background-color:#00CCcc"><strong>1</strong></div>
<?
$r=@mysql_query("select * from ps_packets where server_id='".$_COOKIE[psdata][user_id]."' order by packet_id DESC limit 0,5");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
?>
		<li>#<?=$d[packet_id]?>  <?=substr($d[date_received],0,10)?></li>
<? }?>
</td>
<td valign="top" nowrap="nowrap">        
<div align="center" style="background-color:#00CCcc"><strong>2</strong></div>
<?
$r=@mysql_query("select * from ps_packets where server_ida='".$_COOKIE[psdata][user_id]."' order by packet_id DESC limit 0,5");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
?>
		<li>#<?=$d[packet_id]?>  <?=substr($d[date_received],0,10)?></li>
<? }?>
</td>
<td valign="top" nowrap="nowrap">        
<div align="center" style="background-color:#00CCcc"><strong>3</strong></div>
<?
$r=@mysql_query("select * from ps_packets where server_idb='".$_COOKIE[psdata][user_id]."' order by packet_id DESC limit 0,5");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
?>
		<li>#<?=$d[packet_id]?>  <?=substr($d[date_received],0,10)?></li>
<? }?>
</td>
<td valign="top" nowrap="nowrap">        
<div align="center" style="background-color:#00CCcc"><strong>4</strong></div>
<?
$r=@mysql_query("select * from ps_packets where server_idc='".$_COOKIE[psdata][user_id]."' order by packet_id DESC limit 0,5");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
?>
		<li>#<?=$d[packet_id]?>  <?=substr($d[date_received],0,10)?></li>
<? }?>
</td>
<td valign="top" nowrap="nowrap">        
<div align="center" style="background-color:#00CCcc"><strong>5</strong></div>
<?
$r=@mysql_query("select * from ps_packets where server_idd='".$_COOKIE[psdata][user_id]."' order by packet_id DESC limit 0,5");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
?>
		<li>#<?=$d[packet_id]?>  <?=substr($d[date_received],0,10)?></li>
<? }?>
</td>
<td valign="top" nowrap="nowrap">        
<div align="center" style="background-color:#00CCcc"><strong>6</strong></div>
<?
$r=@mysql_query("select * from ps_packets where server_ide='".$_COOKIE[psdata][user_id]."' order by packet_id DESC limit 0,5");
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
?>
		<li>#<?=$d[packet_id]?>  <?=substr($d[date_received],0,10)?></li>
<? }?>

</td></tr></table>



</td><td  valign="top"><iframe width="900" height="500" src="tos.php"></iframe> </td></tr></table>


<?
include 'footer.php';
?>