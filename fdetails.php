<?php
require_once "includes/config.php";
$id = $_GET['id'];
if(!empty($id)){
$rs = mysql_query("SELECT id,name,username,email,phone,website,postal,city,address,competencies,time,last_login FROM users WHERE username='$id'") or $err[]="Freelanceren findes ikke";
list($uId,$name,$username,$email,$phone,$website,$postal,$city,$address,$competencies,$time,$login)=mysql_fetch_row($rs);
$loggedId=getUserInfo(0);
$loggedName=getUserInfo(1);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="aftalt, freelancer, profil, <?php echo $name; ?>">
<link rel="stylesheet" href="<?php echo "http://$host$path/";?>styles/styles.css" />
<link rel="icon" type="image/png" href="http://<?php echo "$host$path/";?>styles/favicon.png" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="<?php echo "http://$host$path/";?>includes/js/js.js" type="text/javascript"></script>
<title><?php echo $name.$webTitle; ?></title>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/da_DK/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php
if(empty($id) || mysql_num_rows($rs)<=0){header("location:http://$host$path/freelancers.php");}

$eRs = mysql_query("SELECT id,edu,location,syear,eyear FROM ecv WHERE uid=$uId ORDER BY syear DESC, eyear DESC");
$pRs = mysql_query("SELECT id,position,business,syear,eyear FROM pcv WHERE uid=$uId ORDER BY syear DESC, eyear DESC");

if(isset($_POST['send'])){
$fMsg=mysql_real_escape_string($_POST['fMsg']);
$fSubject=mysql_real_escape_string($_POST['fSubject']);
if(empty($fMsg) || empty($fSubject)){
$err[] = "Du skal udfylde begge felter";
}
else{
if(!isLen($fSubject,5,75)){
$err[] = "Du skal skrive et emne på min. 5 tegn og max. 75";
}
elseif(!isLen($fMsg,10,5000)){
$err[] = "Du skal skrive en besked på min. 10 tegn og max. 5000";
}
}
if(empty($err)){
mysql_query("INSERT INTO messages (`sender`,`recipient`,`sendername`,`recipientname`,`subject`,`msg`,`sdate`,`stime`)VALUES('$loggedId','$uId','$loggedName','$name','$fSubject','$fMsg','$cDate','$cTime')") or die(mysql_error());
$msg[]="Beskeden er sendt til ".current(explode(" ",$name));
}
}

require_once "includes/header.php";
?>
<div align="right">
<div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
<a href="https://twitter.com/share" class="twitter-share-button" data-lang="da">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>

<div id="globalContentContainer" style="margin-top:5px;">

<div id="globalRsList">
<div class="globalListContent">
<span class="pTitle top"><?php echo $name; ?></span>
<?php if(mysql_num_rows($eRs)){?>
<span class="tTitle">Uddannelser &amp; kurser</span>
<table border="0" align="center" cellpadding="5" cellspacing="3" width="100%" class="formStyle">
<tr>
<td style="border-bottom:2px dotted #CCC;">Uddannelse:</td>
<td style="border-bottom:2px dotted #CCC;">Geografi:</td>
<td style="border-bottom:2px dotted #CCC;">Startår:</td>
<td style="border-bottom:2px dotted #CCC;">Afslutningsår:</td>
</tr>
<?php while($uRow=mysql_fetch_assoc($eRs)){?>
<tr>
<td style="border-bottom:2px dotted #CCC;"><?php echo $uRow['edu']; ?></td>
<td style="border-bottom:2px dotted #CCC;"><?php echo $uRow['location']; ?></td>
<td style="border-bottom:2px dotted #CCC;"><?php echo $uRow['syear']; ?></td>
<td style="border-bottom:2px dotted #CCC;"><?php echo $uRow['eyear']; ?></td>
</tr>
<? } ?>
</table>
<? } ?>

<?php if(mysql_num_rows($pRs)){?>
<span class="tTitle">Erhvervserfaring</span>
<table border="0" align="center" cellpadding="5" cellspacing="3" width="100%" class="formStyle">
<tr>
<td style="border-bottom:2px dotted #CCC;">Stilling:</td>
<td style="border-bottom:2px dotted #CCC;">Firma:</td>
<td style="border-bottom:2px dotted #CCC;">Startår:</td>
<td style="border-bottom:2px dotted #CCC;">Afslutningsår:</td>
</tr>
<?php while($pRow=mysql_fetch_assoc($pRs)){?>
<tr>
<td style="border-bottom:2px dotted #CCC;"><?php echo $pRow['position']; ?></td>
<td style="border-bottom:2px dotted #CCC;"><?php echo $pRow['business']; ?></td>
<td style="border-bottom:2px dotted #CCC;"><?php echo $pRow['syear']; ?></td>
<td style="border-bottom:2px dotted #CCC;"><?php echo $pRow['eyear']; ?></td>
</tr>
<? } ?>
</table>
<? } ?>

<?php if($competencies!=""){?>
<span class="tTitle">Kompetencer</span>
<table border="0" align="center" cellpadding="5" cellspacing="3" width="100%" class="formStyle">
<tr align="center">
<td style="border-bottom:2px dotted #CCC;"><?php echo $competencies; ?></td>
</tr>
</table>
<? }

echo "<br />
<span class='tTitle'>Kontakt oplysninger</span>";
if(logged()==true){?>
<table border="0" align="center" cellpadding="5" cellspacing="3" width="100%" class="formStyle">
<tr>
<td style="border-bottom:2px dotted #CCC;">Navn:</td><td style="border-bottom:2px dotted #CCC;"><?php echo $name; ?></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Brugernavn:</td><td style="border-bottom:2px dotted #CCC;"><?php echo $username; ?></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Email:</td><td style="border-bottom:2px dotted #CCC;"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
</tr>
<?php if($phone!="") {?>
<tr>
<td style="border-bottom:2px dotted #CCC;">Telefon:</td><td style="border-bottom:2px dotted #CCC;"><?php echo $phone; ?></td>
</tr>
<? }
if($postal!="" || $city!="") {?>
<tr>
<td style="border-bottom:2px dotted #CCC;">Adresse:</td><td style="border-bottom:2px dotted #CCC;"><?php echo "$address $postal $city";?></td>
</tr>
<? }
if($website!="") {?>
<tr>
<td style="border-bottom:2px dotted #CCC;">Websted:</td><td style="border-bottom:2px dotted #CCC;"><a target="_blank" href="<?php echo "http://$website"; ?>"><?php echo "http://$website"; ?></a></td>
</tr>
<? } ?>
<tr>
<td style="border-bottom:2px dotted #CCC;">Sidst log ind:</td><td style="border-bottom:2px dotted #CCC;"><?php if($login=="" || $time==""){echo "Aldrig";}else{echo cpTime($time,$login, "%d. %b. %Y, kl. %H:%M:%S");} ?></td>
</tr>
</table>

<?php if($uId!=$loggedId){?>
<span class="tTitle">Send <?php echo current(explode(" ",$name)); ?> en besked</span>
<form action="" method="post">
<table border="0" align="center" cellpadding="5" cellspacing="3" width="100%" class="formStyle">
<tr>
<td>Afsender:</td><td><?php echo $loggedName; ?></td>
</tr>
<tr>
<td>Modtager:</td><td><?php echo $name; ?></td>
</tr>
<tr>
<td>Emne:</td><td><input type="text" name="fSubject" id="fSubject" size="75" /></td>
</tr>
<tr>
<td>Besked:</td><td><textarea cols="75" rows="11" name="fMsg" id="fMsg" maxlength="5000" onkeydown="textCounter(this,'counter',5000);" onkeyup="textCounter(this,'counter',5000);"></textarea><span style="display:block;font-size:9px;" id="counter">5000 tegn tilbage.</span></td>
</tr>
<tr>
<td>&nbsp;</td><td><input type="submit" name="send" id="send" value="Send besked" /></td>
</tr>
</table>
</form>
<? } }
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
