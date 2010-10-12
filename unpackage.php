<? include 'lock.php';
include 'common.php';
include 'menu.php';
if (isset($_POST['packet_id'])){
$q=@mysql_query("UPDATE ps_packets SET process_status='READY', package_id='', server_id='', server_ida='', server_idb='', server_idc='', server_idd='', server_ide='', contractor_rate='', contractor_ratea='',contractor_rateb='', contractor_ratec='', contractor_rated='', contractor_ratee='', client_rate='', client_ratea='', client_rateb='', client_ratec='', client_rated='', client_ratee='', print_cost='', print_costa='', print_costb='', print_costc='', print_costd='', print_coste='' where packet_id='$_POST[packet_id]'");
}

?>
<br />
<br />
<br />
<form method="post">
<table align="center">
	<tr>
    	<td><input name="packet_id" /><input type="submit" /></td>
    </tr>
</table>
</form>
<? include 'footer.php'; ?>