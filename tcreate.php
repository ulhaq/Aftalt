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
<title>Opret opgave<?php echo "$webTitle";?></title>
</head>
<body>
<?php
protection();

list($uId)=mysql_fetch_row(mysql_query("SELECT id FROM users WHERE a_userid='$_SESSION[a_userid]'"));
$tName = mysql_real_escape_string($_POST['tName']);
$tBudget = mysql_real_escape_string($_POST['tBudget']);
$tDeadline = mysql_real_escape_string($_POST['tDeadline']);
$tLocation = mysql_real_escape_string($_POST['tLocation']);
$tComp = mysql_real_escape_string($_POST['tComp']);
$tDesc = mysql_real_escape_string($_POST['tDesc']);
$tTName = preg_replace("/\s/","-",preg_replace("/[^A-Za-z0-9æøåÆØÅ\s]/","",$tName));
$ip = $_SERVER['REMOTE_ADDR'];

if(isset($_POST['tcreation'])){
if(empty($tName) || empty($tBudget) || empty($tLocation) || empty($tComp) || empty($tDesc)){
$err[] = "Du skal udfylde alle felter med *.";
}
else{
if(!isLen($tName,5,75)){
$err[] = "Du skal indtaste en opgavetitel på min. 5 tegn og max. 75.";
}
if(!isLen($tBudget,1,50)){
$err[] = "Du skal indtaste et budget på min. 2 tegn max. 50.";
}
if(!empty($tDeadline) && !isLen($tDeadline,3,25)){
$err[] = "Du skal indtaste en deadline på min. 3 tegn og max. 25.";
}
if(!isLen($tLocation,2,50)){
$err[] = "Du skal indtaste din geografi på min. 2 tegn og max. 50.";
}
if(!isLen($tComp,1,225)){
$err[] = "Du skal indtaste kompetencer på min. 1 tegn og max. 225.";
}
if(!isLen($tDesc,10,2500)){
$err[] = "Du skal indtaste en beskrivelse på min. 10 tegn og max. 2500 tegn.";
}
$cDup = mysql_query("SELECT COUNT(*) AS cD FROM tasks WHERE name='$tName' AND budget='$tBudget' AND deadline='$tDeadline' AND location='$tLocation' AND comp='$tComp' AND `desc`='$tDesc' AND uid='$uId'") or $err[]="Opgaven kunne ikke opretes, da der opstod en fejl i systemet.";
list($cD)=mysql_fetch_row($cDup);
if($cD>0){
$err[] = "Opgaven eksisterer allerede.";
}

for($i=0;mysql_num_rows(mysql_query("SELECT tname FROM tasks WHERE tname='$tTName'"))!=0;$i++){
$tTName = $tTName."-$i";
}

}

if(empty($err)) {
mysql_query("INSERT INTO tasks (`name`,`tname`,`budget`,`deadline`,`location`,`comp`,`desc`,`ip`,`time`,`date`,`uid`)VALUES('$tName','$tTName','$tBudget','$tDeadline','$tLocation','$tComp','$tDesc','$ip','$cTime','$cDate','$uId')") or $err[]="Opgaven kunne ikke opretes, da der opstod en fejl i systemet.";
header("location:http://$host$path/mytasks.php");
}
}

require_once "includes/header.php";
?>
<div id="globalContentContainer">

<div id="globalRsList">
<div class="globalListContent">
<span class="pTitle top">Opret opgaver helt gratis</span>
<form action="" method="post">
<table align="center" cellspacing="7" class="formStyle">
<tr>
<td class="tool">Opgavetitle <span style="color:#C00;">*</span>:<span class="tip t l">Indtast en kort og præcis title.<span class="tarrow at l"></span></span></td><td><input type="text" id="tName" name="tName" size="50" maxlength="75" /></td>
</tr>
<tr>
<td class="tool">Budget <span style="color:#C00;">*</span>:<span class="tip t l">Hvad tilbage lægges af ressourcer?<span class="tarrow at l"></span></span></td><td><input type="text" id="tBudget" name="tBudget" size="50" /></td>
</tr>
<tr>
<td class="tool">Deadline:<span class="tip t l">Hvornår skal opgaven være færdig.<br /><span style="font-weight:normal;font-size:8px;">Fx: 21-05-2012</span><span class="tarrow at l"></span></span></td><td><input type="text" id="tDeadline" name="tDeadline" size="50" /></td>
</tr>
<tr>
<td class="tool">Geografi <span style="color:#C00;">*</span>:<span class="tip t l">Indtast din geografi.<span class="tarrow at l"></span></span></td><td><input type="text" id="tLocation" name="tLocation" size="50" /></td>
</tr>
<tr>
<td class="tool">Kompetencer <span style="color:#C00;">*</span>:<span class="tip t l">Indtast de kompetencer freelanceren skal besidde, for at kunne udarbejde opgaven.<span class="tarrow at l"></span></span></td><td><input type="text" id="tComp" name="tComp" size="50" /></td>
</tr>
<tr>
<td>Beskrivelse <span style="color:#C00;">*</span>:</td><td><textarea id="tDesc" name="tDesc" cols="50" rows="15" maxlength="2500" onkeydown="textCounter(this,'counter',2500);" onkeyup="textCounter(this,'counter',2500);"></textarea><span style="display:block;font-size:9px;" id="counter">2500 tegn tilbage.</span></td>
</tr>
<tr>
<td>&nbsp;</td><td><input type="submit" name="tcreation" id="tcreation" value="Opret Opgave" /></td>
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
