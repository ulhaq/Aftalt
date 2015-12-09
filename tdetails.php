<?php
require_once "includes/config.php";
$id = $_GET['id'];
if(!empty($id)){
$rs = mysql_query("SELECT tasks.name,tasks.budget,tasks.deadline,tasks.location,tasks.comp,tasks.`desc`,tasks.time,tasks.date,tasks.uid, users.id,users.name,users.username,users.email,users.phone,users.website,users.a_userid FROM tasks INNER JOIN users ON (tasks.tname='$id' AND tasks.active='1' AND users.id=tasks.uid)") or $err[]="Opgaven findes ikke";
list($name,$budget,$deadline,$location,$comp,$desc,$time,$date,$tUId,$uId,$uName,$uUsername,$uEmail,$uPhone,$uWebsite,$uUserId)=mysql_fetch_row($rs);
$loggedId=getUserInfo(0);
$loggedName=getUserInfo(1);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="aftalt, opgave, profil, <?php echo $name; ?>">
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
if(empty($id) || mysql_num_rows($rs)<=0){header("location:http://$host$path/tasks.php");}

if(isset($_POST['send'])){
$tMsg=mysql_real_escape_string($_POST['tMsg']);
if(empty($tMsg) || !isLen($tMsg,10,5000)){
$err[] = "Du skal skrive en besked på min. 10 tegn og max. 5000";
}

if(empty($err)){
mysql_query("INSERT INTO messages (`sender`,`recipient`,`sendername`,`recipientname`,`subject`,`msg`,`sdate`,`stime`)VALUES('$loggedId','$uId','$loggedName','$uName','$name','$tMsg','$cDate','$cTime')") or die(mysql_error());
$msg[]="Beskeden er sendt til ".current(explode(" ",$uName));
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
<span class="tTitle top">Opgave beskrivelse</span>
<table border="0" align="center" cellpadding="5" cellspacing="3" width="100%" class="formStyle">
<tr> 
<td style="border-bottom:2px dotted #CCC;">Oprettet:</td><td style="border-bottom:2px dotted #CCC;"><?php cpTime($time,$date,"%d. %b. %Y, kl. %H:%M:%S");
 ?></td>
</tr>
<?php if($deadline!="") {?>
<tr>
<td style="border-bottom:2px dotted #CCC;">Deadline:</td><td style="border-bottom:2px dotted #CCC;"><?php echo $deadline; ?></td>
</tr>
<? } ?>
<tr> 
<td style="border-bottom:2px dotted #CCC;">Budget:</td><td style="border-bottom:2px dotted #CCC;"><?php echo $budget; ?></td>
</tr>
<tr> 
<td style="border-bottom:2px dotted #CCC;">Geografi:</td><td style="border-bottom:2px dotted #CCC;"><?php echo $location; ?></td>
</tr>
<tr> 
<td style="border-bottom:2px dotted #CCC;">Kompetencer:</td><td style="border-bottom:2px dotted #CCC;"><?php echo $comp; ?></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Beskrivelse:</td><td style="border-bottom:2px dotted #CCC;"><?php echo nl2br($desc); ?></td>
</tr>
</table>

<br />
<span class="tTitle">Kontakt oplysninger</span>
<?php if(logged()==true){
if(mysql_num_rows($rs)>0){?>
<table border="0" align="center" cellpadding="5" cellspacing="3" width="100%" class="formStyle">
<tr>
<td style="border-bottom:2px dotted #CCC;">Navn:</td><td style="border-bottom:2px dotted #CCC;"><?php echo $uName; ?></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Brugernavn:</td><td style="border-bottom:2px dotted #CCC;"><a href="<?php echo "http://$host$path/freelancers/$uUsername";?>"><?php echo $uUsername; ?></a></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Email:</td><td style="border-bottom:2px dotted #CCC;"><a href="mailto:<?php echo $uEmail; ?>"><?php echo $uEmail; ?></a></td>
</tr>
<?php if($uPhone!="") {?>
<tr>
<td style="border-bottom:2px dotted #CCC;">Telefon:</td><td style="border-bottom:2px dotted #CCC;"><?php echo $uPhone; ?></td>
</tr>
<? }
if($uWebsite!="") {?>
<tr>
<td style="border-bottom:2px dotted #CCC;">Websted:</td><td style="border-bottom:2px dotted #CCC;"><a target="_blank" href="<?php echo "http://$uWebsite"; ?>"><?php echo "http://$uWebsite"; ?></a></td>
</tr>
<? } ?>
</table>

<?php if($tUId!=$loggedId){?>
<span class="tTitle">Send <?php echo current(explode(" ",$uName)); ?> en besked</span>
<form action="" method="post">
<table border="0" align="center" cellpadding="5" cellspacing="3" width="100%" class="formStyle">
<tr>
<td>Afsender:</td><td><?php echo $loggedName; ?></td>
</tr>
<tr>
<td>Modtager:</td><td><?php echo $uName; ?></td>
</tr>
<tr>
<td>Emne:</td><td><?php echo $name; ?></td>
</tr>
<tr>
<td>Besked:</td><td><textarea cols="75" rows="11" name="tMsg" id="tMsg" maxlength="5000" onkeydown="textCounter(this,'counter',5000);" onkeyup="textCounter(this,'counter',5000);"></textarea><span style="display:block;font-size:9px;" id="counter">5000 tegn tilbage.</span></td>
</tr>
<tr>
<td>&nbsp;</td><td><input type="submit" name="send" id="send" value="Send besked" /></td>
</tr>
</table>
</form>
<? } }
else{
echo "<div style='padding:25px;text-align:center;color:#000;text-shadow: 0 -1px 3px #000;font-weight: bold;'>Kontakt oplysningerne er ikke tilgængelig i øjeblikket.</div>";
}
}
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
