<?
// this file will recieve status updates if elephant is active where debug information can be automatically updated
// it is all called from footer displaying $monitor
session_start();
if ($_GET[str]){
$_SESSION['log'] = $_GET[str].$_SESSION['log'];
header('Location: monitor.php');
}
?>
<style>
a { text-decoration:none;}
</style>
<script>window.moveTo(0,0); self.blur();</script><div style="font-size:24px;" align="center">CORE-DEBUG</div>
<div style="font-size:16px"><?=$_SESSION['log'];?></div><a href="?clear=1">Purge Session</a>
<?
if ($_GET[clear]){ session_destroy(); echo "<script>self.close();</script>"; }
?>