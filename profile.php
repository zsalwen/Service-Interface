<? include 'common.php';
logAction($_COOKIE[psdata][user_id], $_SERVER['PHP_SELF'], 'Viewing Profile for '.id2name($_GET[id]));


function isChecked($value){
	if ($value > '0'){
	return 'checked';
	}
}

include 'menu.php';
$id = $_GET[id];
$q= "select * from ps_users where id = '$id'";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$d=mysql_fetch_array($r, MYSQL_ASSOC); 

 ?>

<? if ($message){ ?>
    	<b><?=$message?></b>
<? } ?>

        
<div align="center" style="font:Verdana, Arial, Helvetica, sans-serif; font-size:24px; background-color:#FFFFFF">Independent Contractor Profile for <?=$d[profile_name]?></div>
        
        <table width="100%" border="1" style="border-collapse:collapse" bgcolor="#FFFFFF"><tr><td width="10" valign="top"><?=image($d[img],250,'');?></td><td valign="top">
        	
        		<table align="center">
            		<tr>
                		<td colspan="2" style="border-bottom-style:solid">Active Bids</td>
                	</tr>
            		<tr>
                		<td>Garrett</td>
                    	<td><input <?=isChecked($d[garrett])?> type="checkbox" name="garrett" value="checked"  /></td>
                 	</tr>
                   <tr>
                   		<td>Allegany</td>
                   		<td><input <?=isChecked($d[allegany])?> type="checkbox" name="allegany" value="checked" /></td>
                   </tr>
                   <tr>
                   		<td>Washington</td>
                   		<td><input <?=isChecked($d[washington])?> type="checkbox" name="washington" value="checked" /></td>
                   </tr>
                   <tr>
                   		<td>Frederick</td>
                   		<td><input <?=isChecked($d[frederick])?> type="checkbox" name="frederick" value="checked" /></td>
                   </tr>
                   <tr>
                   		<td>Carroll</td>
                   		<td><input <?=isChecked($d[carroll])?> type="checkbox" name="carroll" value="checked" /></td>
                   </tr>
			</table> 
         </td><td valign="top">          
        	<table align="center">
            		<tr>
                		<td colspan="2" style="border-bottom-style:solid">Active Bids</td>
             	   </tr>
				   <tr>
                        <td>Cecil</td>
                        <td><input <?=isChecked($d[cecil])?> type="checkbox" name="cecil" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Harford</td>
                        <td><input <?=isChecked($d[harford])?> type="checkbox" name="harford" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Baltimore County</td>
                        <td><input <?=isChecked($d[baltimore_county])?> type="checkbox" name="baltimore_county" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Baltimore City</td>
                        <td><input <?=isChecked($d[baltimore_city])?> type="checkbox" name="baltimore_city" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Howard</td>
                        <td><input <?=isChecked($d[howard])?> type="checkbox" name="howard" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Montgomery</td>
                        <td><input <?=isChecked($d[montgomery])?> type="checkbox" name="montgomery" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Anne Arundel</td>
                        <td><input <?=isChecked($d[anne_arundel])?> type="checkbox" name="anne_arundel" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Prince George's</td>
                        <td><input <?=isChecked($d[pg])?> type="checkbox" name="pg" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Calvert</td>
                        <td><input <?=isChecked($d[calvert])?> type="checkbox" name="calvert" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Charles</td>
                        <td><input <?=isChecked($d[charles])?> type="checkbox" name="charles" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>St. Mary's</td>
                        <td><input <?=isChecked($d[st_mary])?> type="checkbox" name="st_mary" value="checked"  /></td>
                   </tr>
			</table>        
         </td><td valign="top">          
            <table align="center">
            	<tr>
                	<td colspan="2" style="border-bottom-style:solid">Active Bids</td>
                </tr>
            	<tr>
                	<td>Kent</td><td><input <?=isChecked($d[kent])?> type="checkbox" name="kent" value="checked"  /></td>
                </tr>
                   <tr>
                   		<td>Caroline</td>
                        <td><input <?=isChecked($d[caroline])?> type="checkbox" name="caroline" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Dorchester</td>
                        <td><input <?=isChecked($d[dorchester])?> type="checkbox" name="dorchester" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Queen Anne's</td>
                        <td><input <?=isChecked($d[queen_anne])?> type="checkbox" name="queen_anne" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Somerset</td>
                        <td><input <?=isChecked($d[somerset])?> type="checkbox" name="somerset" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Talbot</td>
                        <td><input <?=isChecked($d[talbot])?> type="checkbox" name="talbot" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Wicomico</td>
                        <td><input <?=isChecked($d[wicomico])?> type="checkbox" name="wicomico" value="checked"  /></td>
                   </tr>
                   <tr>
                   		<td>Worcester</td>
                        <td><input <?=isChecked($d[worcester])?> type="checkbox" name="worcester" value="checked"  /></td>
                   </tr>
			</table>        
        </td></tr></table>
  <!--
  <table width="100%" bgcolor="#CCCCCC">
  	<tr>
    	<td valign="top"><form method="post">
        <select><option value="5">5 Professionally Recommended</option><option>4</option><option>3</option><option>2</option><option>1</option><option value="0">0 Blacklist</option></select><br />
        <textarea name="peer_review">X <?=$_COOKIE[psdata][user_id];?> - <?=$_GET[id];?> X</textarea><br />
        <input type="submit" value="Save Review" /></form>
        </td>
    	<td valign="top">
        Peer Reviews
        <hr />
        <br />
<br />
<br />
<br />

        
        </td>
    </tr>      
  </table>
        
        
        <div align="center" style="background-color:#FFFFCC"><a>SUBMIT PROFILE FOR CONTENT REVIEW</a></div>
-->
<? include 'footer.php';?>
