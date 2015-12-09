<?php
require_once "includes/config.php";
$id = $_GET['id'];
$loggedId=getUserInfo(0);
$loggedName=getUserInfo(1);
if(!empty($id)){
$rs = mysql_query("SELECT id,sender,recipient,sendername,recipientname,subject,msg,sdate,stime,IF(sender='$loggedId', recipientname,sendername) AS srname FROM messages WHERE IF(sender='$loggedId',  sactive='1'&&recipient='$id', ractive='1'&&recipient='$loggedId') ORDER BY stime ASC") or die(mysql_error());
list($mId,$sender,$recipient,$senderName,$recipientName,$subject,$rMsg,$sDate,$sTime,$srName)=mysql_fetch_row(mysql_query("SELECT id,sender,recipient,sendername,recipientname,subject,msg,sdate,stime,IF(sender='$loggedId', recipientname,sendername) AS srname FROM messages WHERE IF(sender='$loggedId',  recipient='$id', sender='$id') ORDER BY stime DESC"));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo "http://$host$path/";?>styles/styles.css" />
<link rel="icon" type="image/png" href="http://<?php echo "$host$path/";?>styles/favicon.png" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="<?php echo "http://$host$path/";?>includes/js/js.js" type="text/javascript"></script>
<title><?php echo $subject.$webTitle; ?></title>
</head>
<body>
<?php
protection();
if(empty($id) || mysql_num_rows($rs)<=0){header("location:http://$host$path/messages.php");}

if(isset($_POST['send'])){
$mMsg=mysql_real_escape_string($_POST['mMsg']);
if(empty($mMsg) || !isLen($mMsg,10,5000)){
$err[] = "Du skal skrive en besked på min. 10 tegn og max. 5000";
}

if(empty($err)){
mysql_query("INSERT INTO messages (`sender`,`recipient`,`sendername`,`recipientname`,`subject`,`msg`,`sdate`,`stime`)VALUES('$loggedId','$id','$loggedName','$srName','$subject','$mMsg','$cDate','$cTime')") or die(mysql_error());
$msg[]="Beskeden er sendt til ".current(explode(" ",$srName));
}
}

list($read)=mysql_fetch_row(mysql_query("SELECT nmsg FROM messages WHERE (sender='$id' AND recipient='$loggedId') AND nmsg='1'"));
if($read=="1"){
	mysql_query("UPDATE messages SET nmsg='0' WHERE sender='$id' AND recipient='$loggedId'") or die(mysql_error());
}

require_once "includes/header.php";
?>
<div id="globalContentContainer">

<div id="globalRsList">
<div class="globalListContent">
<span class="pTitle top"><?php echo $subject; ?></span>


<?php
if(logged()==true){
echo "<table border='0' align='center' cellpadding='5' cellspacing='3' width='100%' class='formStyle'>";
while($row=mysql_fetch_assoc($rs)){?>
<tr>
<td style="border-bottom:2px dotted #CCC;" class="tool">
<span class='tip t l'><?php cpTime($row['stime'],$row['sdate'],"%d. %b. %Y, kl. %H:%M:%S"); ?><span class='tarrow at l'></span></span><?php echo $row['sendername']; ?></td><td style="border-bottom:2px dotted #CCC;"><?php echo nl2br($row['msg']); ?></td>
</tr>
<? } ?>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<form action="" method="post">
<tr>
<td><input type="submit" name="send" id="send" Value="Send svar" tabindex="2" /></td><td><textarea cols="75" rows="11" name="mMsg" id="mMsg" maxlength="5000" onkeydown="textCounter(this,'counter',5000);" onkeyup="textCounter(this,'counter',5000);" tabindex="1"></textarea><span style="display:block;font-size:9px;" id="counter">5000 tegn tilbage.</span></td>
</tr>
</form>
</table>
<? }
else{
echo "<div style='padding:25px;text-align:center;color:#000;text-shadow: 0 -1px 3px #000;font-weight: bold;'>Du skal være logget ind, for at se kontakt oplysningerne. <a href='http://$host$path/login.php'>Log ind her!</a></div>";
}
?>
<a class="pTitle bottom" href="javascript:history.go(-1);">Tilbage</a>
</div>
</div>

</div>
<?php require_once "includes/footer.php";?>
</div>
</body>
</html>
