<?
include 'common.php';
if ($_POST[note]){
timeline($_GET[packet],$_COOKIE[psdata][name]." ".$_POST[note]);
echo "added ".$_POST[note]." to packet ".$_GET[packet]."<br>";
?>
<script>parent.location.href='order.php?packet=<?=$_GET[packet]?>'</script>
<?
}else{
echo "Manual timeline note by: ".$_COOKIE[psdata][name]." for packet ".$_GET[packet]."<br>";
?>

<form method="post"><input name="note" size="50" /><input type="submit" value="Record Note" /></form>
(this will cause the order page to reload)

<? } ?>