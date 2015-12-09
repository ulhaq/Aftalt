<?php require_once "includes/config.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo "http://$host$path/";?>styles/styles.css" />
<link rel="icon" type="image/png" href="http://<?php echo "$host$path/";?>styles/favicon.png" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="<?php echo "http://$host$path/";?>includes/js/js.js" type="text/javascript"></script>
<script>
if($("#showMore")){$(window).scroll(function(){if($(window).scrollTop()>=$(document).height()-$(window).height()-300){$("#showMore").click();}});}
</script>
<title><?php if(isset($_GET['q']) && $_GET['q']!=""){echo $_GET['q']." - Søgning af ";}else{echo "";} ?>Beskeder<?php echo "$webTitle";?></title>
</head>
<body>
<?php
protection();
$id=$_POST['delid'];
$loggedId=getUserInfo(0);

if(isset($_POST['delm']) && !empty($id)){
	list($sender,$recipient,$sact,$ract)=mysql_fetch_row(mysql_query("SELECT sender,recipient,sactive,ractive FROM messages WHERE (sender='$loggedId' AND recipient='$id') OR (sender='$id' AND recipient='$loggedId')"));
		mysql_query("UPDATE messages SET sactive='0' WHERE (sender='$loggedId' AND recipient='$id')") or die(mysql_error());
		mysql_query("UPDATE messages SET ractive='0' WHERE (sender='$id' AND recipient='$loggedId')") or die(mysql_error());
		$msg[]="Hele tråden er slettet.";
}

require_once "includes/header.php";
?>
<div id="globalContentContainer">
<div id="globalRsList">
<div class="globalListContent">
<?php include "includes/lset.php"; ?>

<div id="globalSearch" style="padding-bottom:5px;">
<form action="" method="get">
<div id="globalSearchContainer" style="border:0;border-bottom:1px solid #1d5b85;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;">
<input type="text" id="q" class="mq" name="q" style="-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;" autocomplete="off" spellcheck="false" onkeyup="getInstant(this);" value="<?php echo $_GET['q'];  ?>" />
<input type="submit" id="search" name="search" value="" title="Søg" />
<div id="qReset"></div>
</div>
<div align="left" style="font-weight:normal;font-size:9px;">Søg på: Afsender, modtager, emne, besked, <span class="tool" style="font-weight:normal;font-size:9px;">dato<span style="font-weight:normal;font-size:9px;top:25px;" class="tip b l">Fx: 21-05-2012 13:24:01<span class="tarrow ab l"></span></span></span></div>
</form>
</div>
<ul id="globalListContentRs">
<?php include "includes/msg.php";?>
</ul>
</div>
</div>

</div>
<?php require_once "includes/footer.php";?>
</div>
</body>
</html>
