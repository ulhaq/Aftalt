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
<title>CV oplysninger<?php echo "$webTitle";?></title>
</head>
<body>
<?php
protection();

$rsUI=mysql_query("SELECT id, a_userid FROM users WHERE a_userid='$_SESSION[a_userid]'") or die(mysql_error());
list($uUId,$ua_userid)=mysql_fetch_row($rsUI);

$rseCv=mysql_query("SELECT id, edu, location, syear, eyear FROM ecv WHERE uid='$uUId'") or die(mysql_error());
$rspCv=mysql_query("SELECT id, position, business, syear, eyear FROM pcv WHERE uid='$uUId'") or die(mysql_error());

$ceEdu = $_POST['ceEdu'];
$ceLocation = $_POST['ceLocation'];
$cesYear = $_POST['cesYear'];
$ceeYear = $_POST['ceeYear'];
$cPos = $_POST['cPos'];
$cBus = $_POST['cBus'];
$csYear = $_POST['csYear'];
$ceYear = $_POST['ceYear'];
$ip = $_SERVER['REMOTE_ADDR'];

if(isset($_POST['ceUpdate'])){
if(empty($ceEdu) || empty($ceLocation) || empty($cesYear) || empty($ceeYear)){
$err[] = "Du skal udfylde alle felterne.";
}
else{
$EDup = mysql_query("SELECT COUNT(*) AS cE FROM ecv WHERE edu='$ceEdu' AND location='$ceLocation' AND syear='$cesYear' AND eyear='$ceeYear' AND uid='$uUId'") or die(mysql_error());
list($cE)=mysql_fetch_row($EDup);
if($cE>0){
$err[] = "Uddannelses oplysningerne eksisterer allerede.";
}
if(!isNumber($cesYear,4,4)){
$err[] = "Du skal indtaste et startårstal på 4 cifre.";
}if(!isNumber($ceeYear,4,4)){
$err[] = "Du skal indtaste et afslutningsårstal på 4 cifre.";
}
}
if(empty($err)){
mysql_query("INSERT INTO ecv VALUES('','$ceEdu','$ceLocation','$cesYear','$ceeYear','$uUId')") or die(mysql_error());
$msg[] = "Uddannelses oplysningerne er tilføjet.";
}
}
if(isset($_GET['dele']) && !empty($_GET['delid'])){
if(empty($err)){
mysql_query("DELETE FROM ecv WHERE uid='$uUId' AND id='$_GET[delid]'") or die(mysql_error());
$msg[] = "Uddannelses oplysningerne er slettet.";
}
}



if(isset($_POST['cpUpdate'])){
if(empty($cPos) || empty($cBus) || empty($csYear) || empty($ceYear)){
$err[] = "Du skal udfylde alle felterne.";
}
else{
$EDup = mysql_query("SELECT COUNT(*) AS cE FROM pcv WHERE position='$cPos' AND business='$cBus' AND syear='$csYear' AND eyear='$ceYear' AND uid='$uUId'") or die(mysql_error());
list($cE)=mysql_fetch_row($EDup);
if($cE>0){
$err[] = "Erhvervs oplysningerne eksisterer allerede.";
}
if(!isNumber($csYear,4,4) || !isNumber($ceYear,4,4)){
$err[] = "Du skal indtaste et årstal på 4 cifre.";
}
}
if(empty($err)){
mysql_query("INSERT INTO pcv VALUES('','$cPos','$cBus','$csYear','$ceYear','$uUId')") or die(mysql_error());
$msg[] = "Erhvervs oplysningerne er tilføjet.";
}
}
if(isset($_GET['delp']) && !empty($_GET['delid'])){
if(empty($err)){
mysql_query("DELETE FROM pcv WHERE uid='$uUId' AND id='$_GET[delid]'") or die(mysql_error());
$msg[] = "Erhvervs oplysningerne er slettet.";
}
}
require_once "includes/header.php";
?>
<div id="globalContentContainer">

<div id="globalRsList">
<div class="globalListContent">
<?php include "includes/lset.php"; ?>
<span class="tTitle">Uddannelser &amp; kurser</span>
<form action="" method="post">
<table border="0" width="100%" align="center" cellpadding="5" cellspacing="0" class="formStyle">
<?php
if(mysql_num_rows($rseCv)==0){
echo "<tr align='center'><td colspan='4'>Der er endnu ingen uddannelses oplysninger tilføjet.</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
}
?>
<tr align="center"> 
<td>Uddannelse</td>
<td>Sted</td>
<td>Startår</td>
<td>Aufslutningsår</td>
<td>Handling</td>
</tr>
<?php while($erows=mysql_fetch_assoc($rseCv))
{?>
<tr align="center"> 
<td><input type="text" disabled="disabled" size="35" value="<?php echo $erows['edu']; ?>" /></td>
<td><input type="text" disabled="disabled" size="35" value="<?php echo $erows['location']; ?>" /></td>
<td><input type="text" disabled="disabled" size="10" value="<?php echo $erows['syear']; ?>" /></td>
<td><input type="text" disabled="disabled" size="10" value="<?php echo $erows['eyear']; ?>" /></td>
<td><a href="?dele&delid=<?php echo $erows['id']; ?>">Slet</a></td>
</tr>
<? } ?>
<tr align="center"> 
<td><input type="text" name="ceEdu" size="35" value="<?php echo $ceEdu; ?>" /></td>
<td><input type="text" name="ceLocation" size="35" value="<?php echo $ceLocation; ?>" /></td>
<td><input type="text" name="cesYear" maxlength="4" size="10" value="<?php echo $cesYear; ?>" /></td>
<td><input type="text" name="ceeYear" maxlength="4" size="10" value="<?php echo $ceeYear; ?>" /></td>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="4">&nbsp;</td>
</tr>
<tr align="center">
<td colspan="4"><input type="submit" id="ceUpdate" name="ceUpdate" value="Tilføj" /></td> 
</tr>
</table>
</form>



<span class="tTitle">Erhvervserfaring</span>
<form action="" method="post">
<table border="0" width="100%" align="center" cellpadding="5" cellspacing="0" class="formStyle">
<?php
if(mysql_num_rows($rspCv)==0){
echo "<tr align='center'><td colspan='5'>Der er endnu ingen erhvervs oplysninger tilføjet.</td></tr><tr><td colspan='5'>&nbsp;</td></tr>";
}
?>
<tr align="center"> 
<td>Stilling</td>
<td>Firma</td>
<td>Startår</td>
<td>Aufslutningsår</td>
<td>Handling</td>
</tr>
<?php while($prows=mysql_fetch_assoc($rspCv))
{?>
<tr align="center"> 
<td><input type="text" disabled="disabled" size="35" value="<?php echo $prows['position']; ?>" /></td>
<td><input type="text" disabled="disabled" size="35" value="<?php echo $prows['business']; ?>" /></td>
<td><input type="text" disabled="disabled" size="10" value="<?php echo $prows['syear']; ?>" /></td>
<td><input type="text" disabled="disabled" size="10" value="<?php echo $prows['eyear']; ?>" /></td>
<td><a href="?delp&delid=<?php echo $prows['id']; ?>">Slet</a></td>
</tr>
<? } ?>
<tr align="center"> 
<td><input type="text" name="cPos" size="35" value="<?php echo $cPos; ?>" /></td>
<td><input type="text" name="cBus" size="35" value="<?php echo $cBus; ?>" /></td>
<td><input type="text" name="csYear" maxlength="4" size="10" value="<?php echo $csYear; ?>" /></td>
<td><input type="text" name="ceYear" maxlength="4" size="10" value="<?php echo $ceYear; ?>" /></td>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="5">&nbsp;</td>
</tr>
<tr align="center">
<td colspan="5"><input type="submit" id="cpUpdate" name="cpUpdate" value="Tilføj" /></td> 
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
