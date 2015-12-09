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
<title>Kompetencer<?php echo "$webTitle";?></title>
</head>
<body>
<?php
protection();

$rsUI=mysql_query("SELECT id, a_userid, competencies FROM users WHERE a_userid='$_SESSION[a_userid]'") or die(mysql_error());
list($uUId,$ua_userid,$cComp)=mysql_fetch_row($rsUI);

if(isset($_POST['addComp'])){
if(empty($_POST['comp'])){
$err[] = "Du skal udfylde feltet.";
}
if(empty($err)){
mysql_query("UPDATE users SET competencies='$_POST[comp]' WHERE id='$uUId'") or die(mysql_error());
$msg[] = "Kompetencerne er opdateret.";
}
}

require_once "includes/header.php";
?>
<div id="globalContentContainer">
<div id="globalRsList">
<div class="globalListContent">
<?php include "includes/lset.php"; ?>
<span class="tTitle">Kompetencer</span>
<form action="" method="post">
<table border="0" width="100%" align="center" cellpadding="5" cellspacing="0" class="formStyle">
<?php
if(mysql_num_rows($rsUI)==0 || $cComp==""){
echo "<tr align='center'><td>Der er endnu ingen kompetencer tilføjet.</td></tr><tr><td>&nbsp;</td></tr>";
}
?>
<tr align="center"> 
<td><input type="text" id="comp" name="comp" size="125" autocomplete="off" value="<?php if($cComp!=""){echo "$cComp";}else{echo "$_GET[comp]";}?>" />
<div align="left" style="font-weight:normal;font-size:9px;">Fx: C, C++, C#, Java, PHP, MySQL, ASP, MSSQL</div></td>
</tr>
<tr align="center">
<td><input type="submit" id="addComp" name="addComp" value="<?php if($cComp!=""){echo "Opdatere";}else{echo "Tilføj";}?>" /></td>
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
