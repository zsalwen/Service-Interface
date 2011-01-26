<?
function getPage($url, $referer, $timeout, $header){
 
	if(!isset($timeout))
        $timeout=30;
    $curl = curl_init();
    if(strstr($referer,"://")){
        curl_setopt ($curl, CURLOPT_REFERER, $referer);
    }
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
    curl_setopt ($curl, CURLOPT_HEADER, (int)$header);
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $html = curl_exec ($curl);
    curl_close ($curl);
    return $html;
	
}
$id=$_GET[id];
if ($_GET['autoSave'] == 1){
	$typeA = getPage("http://service.mdwestserve.com/ev_instructions.php?id=$id&noField=1", 'MDWS Instructions Type A', '5', '');
}else{
	$typeA = getPage("http://service.mdwestserve.com/ev_instructions.php?id=$id", 'MDWS Instructions Type A', '5', '');
}
echo $typeA;
?>