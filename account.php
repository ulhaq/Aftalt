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
<title>Min konto<?php echo "$webTitle";?></title>
</head>
<body>
<?php
protection();

$rsSet=mysql_query("SELECT name,username,password,email,phone,website,postal,city,address FROM users WHERE a_userid='$_SESSION[a_userid]'") or die(mysql_error());
list($sName,$sUsername,$sPassword,$sEmail,$sPhone,$sWebsite,$sPostal,$sCity,$sAddress)=mysql_fetch_row($rsSet);
$sPName = mysql_real_escape_string($_POST['sName']);
$sPEmail = mysql_real_escape_string($_POST['sEmail']);
$sPPhone = mysql_real_escape_string($_POST['sPhone']);
$sPWebsite = mysql_real_escape_string($_POST['sWebsite']);
$sPPostal = mysql_real_escape_string($_POST['sPostal']);
$sPCity = mysql_real_escape_string($_POST['sCity']);
$sPAddress = mysql_real_escape_string($_POST['sAddress']);
$sOPassword = mysql_real_escape_string($_POST['sOPassword']);
$sNPassword = mysql_real_escape_string($_POST['sNPassword']);
$sNPasswordRe = mysql_real_escape_string($_POST['sNPasswordRe']);
$sHashedPwd = hashPwd($sNPassword);
$ip = $_SERVER['REMOTE_ADDR'];

if(isset($_POST['sUpdateP'])){
if(empty($sPName) || empty($sPEmail) || empty($sPPostal) || empty($sPCity)){
$err[] = "Du skal udfylde alle felter med *.";
}
else{
$EDup = mysql_query("SELECT COUNT(*) AS cE FROM users WHERE email='$sPEmail'") or die(mysql_error());
list($cE)=mysql_fetch_row($EDup);
if($cE>0 && $sEmail!=$sPEmail){
$err[] = "Email eksisterer allerede.";
}
if(!isEmail($sPEmail) && $cE==0){
$err[] = "Du skal indtaste en gyldig email.";
}
if(!empty($sPPhone) && !isNumber($sPPhone,8,8)){
$err[] = "Du skal indtaste et gyldig telefonnummer på 8 cifre.";
}
if(!empty($sPPostal) && !isNumber($sPPostal,4,4)){
$err[] = "Du skal indtaste et gyldig postnummer på 4 cifre.";
}
if(!empty($sPWebsite) && !isURL($sPWebsite)){
$err[] = "Du skal indtaste en gyldig URL.";
}
}

if(empty($err)){
mysql_query("UPDATE users SET name='$sPName', email='$sPEmail', phone='$sPPhone', website='$sPWebsite', postal='$sPPostal', city='$sPCity', address='$sPAddress', ip='$ip' WHERE a_userid='$_SESSION[a_userid]'");
$msg[] = "Din profil er blevet opdateret!";
}
}

if(isset($_POST['sPasswordU'])){
if(empty($sOPassword) || empty($sNPassword) || empty($sNPasswordRe)){
$err[] = "Du skal udfylde alle felterne.";
}
else{
if($sPassword !== hashPwd($sOPassword,$sPassword)){
$err[] = "Din indtastning matcher ikke din nuværende password.";
}
else{
if(!isEqual($sNPassword,$sNPasswordRe,7)){
$err[] = "Du skal indtaste to ens passwords, på minimum 7 tegn.";
}
}
}

if(empty($err)){
mysql_query("UPDATE users SET password='$sHashedPwd', ip='$ip' WHERE a_userid='$_SESSION[a_userid]'");
$msg[] = "Din password er blevet opdateret!";
}
}
require_once "includes/header.php";
?>
<div id="globalContentContainer">

<div id="globalRsList">
<div class="globalListContent">
<?php include "includes/lset.php"; ?>
<span class="tTitle">Generelle oplysninger</span>
<form action="" method="post">
<table border="0" align="center" cellpadding="2" cellspacing="0" class="formStyle">
<tr> 
<td><label>Brugernavn:</label></td><td><label><?php echo $sUsername; ?></label></td>
</tr>
<tr> 
<td><label>Navn <span style="color:#C00;">*</span>:</label></td><td><input type="text" id="sName" name="sName" size="35" value="<?php echo $sName; ?>" /></td>
</tr>
<tr> 
<td><label>Email <span style="color:#C00;">*</span>:</label></td><td><input type="text" id="sEmail" name="sEmail" size="35" value="<?php echo $sEmail; ?>" /></td>
</tr>
<tr> 
<td><label>Telefon:</label></td><td><input type="text" id="sPhone" name="sPhone" size="35" placeholder="+45" value="<?php echo $sPhone; ?>" /></td>
</tr>
<tr> 
<td><label>Postnr. <span style="color:#C00;">*</span>:</label></td><td><input type="text" id="sPostal" name="sPostal" size="35" maxlength="4" value="<?php echo $sPostal; ?>" /></td>
</tr>
<tr> 
<td><label>By <span style="color:#C00;">*</span>:</label></td><td><input type="text" id="sCity" name="sCity" size="35" value="<?php echo $sCity; ?>" /></td>
</tr>
<tr> 
<td><label>Adresse:</label></td><td><input type="text" id="sAddress" name="sAddress" size="35" value="<?php echo $sAddress; ?>" /></td>
</tr>
<tr> 
<td><label>Websted:</label></td><td><input type="text" id="sWebsite" name="sWebsite" placeholder="http://" size="35" value="<?php echo $sWebsite; ?>" /></td>
</tr>
<tr> 
<td colspan="2">&nbsp;</td>
</tr>
<tr> 
<td>&nbsp;</td><td><input type="submit" id="sUpdateP" name="sUpdateP" value="Opdatere profil" /></td>
</tr>
</table>
</form>


<span class="tTitle">Password</span>
<form action="" method="post">
<table border="0" align="center" cellpadding="2" cellspacing="0" class="formStyle">
<tr> 
<td><label>Nuværende password:</label></td><td><input type="password" id="sOPassword" name="sOPassword" size="35" /></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td><label>Ny password:</label></td><td><input type="password" id="sNPassword" name="sNPassword" size="35" /></td>
</tr>
<tr> 
<td><label>Gentag ny password:</label></td><td><input type="password" id="sNPasswordRe" name="sNPasswordRe" size="35" /></td>
</tr>
<tr> 
<td colspan="2">&nbsp;</td>
</tr>
<tr> 
<td>&nbsp;</td><td><input type="submit" id="sPasswordU" name="sPasswordU" value="Opdatere password" /></td>
</tr>
</table>
</form>
</div>
</div>

</div>
<?php require_once "includes/footer.php";?>
</div>
</body>
</html>