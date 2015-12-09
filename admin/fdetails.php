<?php
require_once "includes/config.php";
$id = $_GET['id'];
if(!empty($id)){
$rs = mysql_query("SELECT id,name,username,email,phone,website,postal,city,address,competencies,time,last_login,register_date,level,approval FROM users WHERE id=$id") or $err[]="Freelanceren findes ikke";
list($fId,$name,$username,$email,$phone,$website,$postal,$city,$address,$competencies,$time,$login,$register_date,$level,$approval)=mysql_fetch_row($rs);
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
<title><?php echo $name.$webTitle; ?></title>
</head>
<body>
<?php
protection();

if(empty($id) || mysql_num_rows($rs)<=0){header("location:http://$host$path/freelancers.php");}

$eRs = mysql_query("SELECT id,edu,location,syear,eyear FROM ecv WHERE uid=$id ORDER BY syear DESC, eyear DESC");
$pRs = mysql_query("SELECT id,position,business,syear,eyear FROM pcv WHERE uid=$id ORDER BY syear DESC, eyear DESC");

$uName=mysql_real_escape_string($_POST['uName']);
$uUsername=mysql_real_escape_string($_POST['uUsername']);
$uEmail=mysql_real_escape_string($_POST['uEmail']);
$uPhone=mysql_real_escape_string($_POST['uPhone']);
$uWebsite=mysql_real_escape_string($_POST['uWebsite']);
$uPostal=mysql_real_escape_string($_POST['uPostal']);
$uCity=mysql_real_escape_string($_POST['uCity']);
$uAddress=mysql_real_escape_string($_POST['uAddress']);
$uLevel=mysql_real_escape_string($_POST['uLevel']);
$uAppr=mysql_real_escape_string($_POST['uAppr']);

if(isset($_POST['uUpdate'])){
mysql_query("UPDATE users SET name='$uName', username='$uUsername', email='$uEmail', phone='$uPhone', website='$uWebsite', postal='$uPostal', city='$uCity', address='$uAddress', level='$uLevel', approval='$uAppr' WHERE id='$id'") or die(mysql_error());
$msg[] = "Oplysningerne er nu opdateret";
}
require_once "includes/header.php";
?>
<div id="globalContentContainer">

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
<span class='tTitle'>Oplysninger</span>";
if(logged()==true){?>
<table border="0" align="center" cellpadding="5" cellspacing="3" width="100%" class="formStyle">
<form action="" method="post">
<tr>
<td style="border-bottom:2px dotted #CCC;">User level:</td><td style="border-bottom:2px dotted #CCC;"><input type="text" maxlength="1" name="uLevel" id="uLevel" value="<?php echo $level; ?>" size="1" /></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Aktivations status:</td><td style="border-bottom:2px dotted #CCC;"><input type="text" maxlength="1" name="uAppr" id="uAppr" value="<?php echo $approval; ?>" size="1" /></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Navn:</td><td style="border-bottom:2px dotted #CCC;"><input type="text" name="uName" id="uName" value="<?php echo $name; ?>" /></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Brugernavn:</td><td style="border-bottom:2px dotted #CCC;"><input type="text" name="uUsername" id="uUsername" value="<?php echo $username; ?>" /></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Email:</td><td style="border-bottom:2px dotted #CCC;"><input type="text" name="uEmail" id="uEmail" value="<?php echo $email?>" /></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Telefon:</td><td style="border-bottom:2px dotted #CCC;"><input type="text" name="uPhone" id="uPhone" value="<?php echo $phone; ?>" /></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Adresse:</td><td style="border-bottom:2px dotted #CCC;"><input type="text" name="uAddress" id="uAddress" value="<?php echo $address; ?>" />
</td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Postnr.:</td><td style="border-bottom:2px dotted #CCC;"><input type="text" name="uPostal" id="uPostal" value="<?php echo $postal; ?>" />
</td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">By:</td><td style="border-bottom:2px dotted #CCC;"><input type="text" name="uCity" id="uCity" value="<?php echo $city; ?>" />
</td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Websted:</td><td style="border-bottom:2px dotted #CCC;"><input type="text" name="uWebsite" id="uWebsite" value="<?php echo $website; ?>" /></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Registrerings dato:</td><td style="border-bottom:2px dotted #CCC;"><?php echo $register_date; ?></td>
</tr>
<tr>
<td style="border-bottom:2px dotted #CCC;">Sidst log ind:</td><td style="border-bottom:2px dotted #CCC;"><?php if($login=="" || $time==""){echo "Aldrig";}else{echo $login;} ?></td>
</tr>
<tr>
<td>&nbsp;</td><td><input type="submit" id="uUpdate" name="uUpdate" value="Opdater" /></td>
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
