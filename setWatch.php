<?
include 'common.php';
if (($_POST[affidavit_status2] && $_POST[as2Desc]) || ($_POST[qualityControl] && $_POST[qcDesc])){
	$as2 = $_POST[affidavit_status2].' for '.$_POST[as2Desc];
	$qc = $_POST[qualityControl].' for '.$_POST[qcDesc];
	if ($as2){
		@mysql_query("update ps_packets set affidavit_status2 = '$as2' where packet_id='$_GET[packet]'");
		hardLog('wizard setWatch '.$as2.' packet '.$_GET[packet],'user');
	}
	if ($qc){
		@mysql_query("update ps_packets set qualityControl = '$qc' where packet_id='$_GET[packet]'");
		hardLog('wizard setWatch '.$qc.' packet '.$_GET[packet],'user');
	}
	echo "setWatch saved for packet $_GET[packet]<br>$as2<br>$qc<br><script>automation()</script>";
}else{
	hardLog('access wizard setWatch for packet '.$_GET[packet],'user');
	$r=@mysql_query("select affidavit_status2, qualityControl, packet_id from ps_packets where packet_id = '$_GET[packet]'");
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
?>
<form method='POST'>
<h1>setWatch for packet <?=$d[packet_id]?></h1>
<table>
	<tr>
		<td>Affidavit Status</td>
		<td><select name="affidavit_status2">
				<option></option>

		<option>Awaiting out of state service completion</option>
		<option>Awaiting out of state service affidavits</option>
		<option></option>
		<option></option>
		<option></option>
		<option></option>
		</select> for <input name="as2Desc"></td>
	</tr>
	<tr>
		<td>Quality Status</td>
		<td><select name="qualityControl">
				<option></option>

		<option>Awaiting server corrections</option>
		<option></option>
		<option></option>
		<option></option>
		<option></option>
		<option></option>
		</select> for <input name="qcDesc"></td>
	</tr>
	<input type="submit">
</form>
<? } ?>