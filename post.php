<? include 'common.php'; 

include 'menu.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Posting News');

if ($_POST[submit] && $_POST[description] && $_POST[topic]){
$q=" INSERT INTO ps_news 
(icon_url, topic, news_url, description, user_id, news_date, ip_add) 
values
('$_POST[icon_url]', '$_POST[topic]', '$_POST[news_url]', '$_POST[description]', '$_POST[user_id]', NOW(), '$_SERVER[REMOTE_ADDR]') ";
	$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
	
	$text="<center><h2><strong>Item Posted: </strong><strong style=\"color:#FF0000\">Awaiting Manager Approval</center></h2></strong>" ;

}else{
$text="<center><h2><strong>Please include a topic and description in your posting.</center></h2></strong>" ;
}
?>
<style>
textarea{background-color:#99CCFF;}
input{background-color:#99CCFF; font-variant:small-caps; font-weight:bold;}
select{background-color:#99CCFF; font-variant:small-caps; font-weight:bold;}
.tbl{background-color:#0099FF;}
</style>


<form method="post">
<input type="hidden" name="user_id" value="<?=$_COOKIE[psdata][user_id]?>" />
			<table class="tbl" align="center" width="100%" border="1">
            	<tr>
                	<td style="border-left:hidden" align="right"><B>Icon/URL: </B></td>
                    <td  style="border-left:hidden" align="left"><select name="icon_url"><option>Web Site</option><option>PDF File</option><option>Image File</option></select> <input name="news_url" size="72" /></td>
                                    </tr>
            	<tr>
                	<td align="right" style="border-left:hidden"><b>Topic: </b></td>
                	<td style="border-left:hidden" align="left"><input name="topic" size="87"/></td>
                </tr>
            	<tr>
					<td bgcolor="#3366FF" align="center"><b>Description: </b></td>
                	<td style="border-left:hidden" align="center"><textarea rows="10" cols="85" name="description" wrap="hard"></textarea></td>
                </tr>                                                
                <tr>
                	<td colspan="2" bgcolor="#3366FF" align="right"><input type="submit" name="submit" value="Add News Item" /></td>
                </tr>                 
            </table>
</form>
<? echo $text;
include 'footer.php';?>