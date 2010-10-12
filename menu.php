<link rel="search" type="application/opensearchdescription+xml" title="MDWestServe.com" href="http://mdwestserve.com/hwa.xml">

<?
if ($_COOKIE[psdata][level] != "Operations" && $_SERVER[PHP_SELF] != "/ps/wizard.php"){
hardLog(' Loaded '.$_SERVER[PHP_SELF].'+'.$_SERVER[QUERY_STRING ],'contractor');
}
$desktop = array(
				'/ps/wizard.php' => array( 'desc' => 'File Wizard', 'icon' => 'http://mdwestserve.com/gfx/icon.wizard.gif'),								
				'/ps/desktop.php' => array( 'desc' => 'Desktop', 'icon' => 'http://mdwestserve.com/gfx/icon.desktop.png'),					
				'/ps/ps_worksheet.php' => array( 'desc' => 'File Manager', 'icon' => 'http://mdwestserve.com/gfx/icon.active.jpg'),					
				'/ps/available.php' => array( 'desc' => 'Dispatch Watch', 'icon' => 'http://mdwestserve.com/gfx/icon.new.jpg'),					
				'/ps/mailbox.php' => array( 'desc' => 'Mailbox', 'icon' => 'http://mdwestserve.com/gfx/icon.mail.png'),				
				'/ps/dupcheck.php' => array( 'desc' => 'Duplicate OTDs', 'icon' => 'http://mdwestserve.com/gfx/icon.mail.png')				
				);
 ?>
<style type="text/css">
    @media print {
      .noprint { display: none; }
    }
  </style> 
<link rel="icon" type="image/gif" href="<?=$desktop[$_SERVER['PHP_SELF']]['icon'];?>">
<script>document.title='<?=$desktop[$_SERVER['PHP_SELF']]['desc'];?>';</script>
<img class="noprint" src="/gfx/icon.desktop.png" style="position:absolute; top:-15px; left:0px; cursor:pointer; width:50px; height:50px;" onClick="window.location.href='http://service.mdwestserve.com/server.php'" />
<link rel="stylesheet" type="text/css" href="popup.css" />
<script src="common.js" type="text/javascript"></script>

<table width="100%" align="center" cellpadding="0px" cellspacing="0px"><tr><td valign="top"  bgcolor="#FFFFFF" style="padding-left:5px;padding-right:5px; border:ridge 5px #006699;"><b>http://mobile.mdwestserve.com for the iPhone&nbsp;/&nbsp;Blackberry and other phones</b><hr>