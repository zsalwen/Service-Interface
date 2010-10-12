<?
$desktop = array(
				'/ps/wizard.php' => array( 'desc' => 'File Wizard', 'icon' => 'http://mdwestserve.com/ps/gfx/icon.wizard.gif'),								
				'/ps/desktop.php' => array( 'desc' => 'Desktop', 'icon' => 'http://mdwestserve.com/ps/gfx/icon.desktop.png'),					
				'/ps/ps_worksheet.php' => array( 'desc' => 'File Manager', 'icon' => 'http://mdwestserve.com/ps/gfx/icon.active.jpg'),					
				'/ps/available.php' => array( 'desc' => 'Dispatch Watch', 'icon' => 'http://mdwestserve.com/ps/gfx/icon.new.jpg'),					
				'/ps/mailbox.php' => array( 'desc' => 'Mailbox', 'icon' => 'http://mdwestserve.com/ps/gfx/icon.mail.png'),				
				'/ps/dupcheck.php' => array( 'desc' => 'Duplicate OTDs', 'icon' => 'http://mdwestserve.com/ps/gfx/icon.mail.png')				
				);
 ?>
<style type="text/css">
    @media print {
      .noprint { display: none; }
    }
  </style> 
<link rel="icon" type="image/gif" href="<?=$desktop[$_SERVER['PHP_SELF']]['icon'];?>">
<link rel="stylesheet" type="text/css" href="popup.css" />
<script src="common.js" type="text/javascript"></script>
