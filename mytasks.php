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
<title>Mine opgaver<?php echo "$webTitle";?></title>
</head>
<body>
<?php
protection();

$uIdC=mysql_query("SELECT id FROM users WHERE a_userid='$_SESSION[a_userid]'") or die(mysql_error());
list($uId)=mysql_fetch_row($uIdC);
$rsTask=mysql_query("SELECT * FROM tasks WHERE uid='$uId' AND active='1' ORDER BY time DESC") or die(mysql_error());
$numRows = mysql_num_rows($rsTask);

if(isset($_POST['delc']) && !empty($_POST['delid'])){
if(empty($err)){
mysql_query("UPDATE tasks SET active='0' WHERE uid='$uId' AND id='$_POST[delid]'") or die(mysql_error());
$msg[] = "Opgaven er slettet.";
}
}
require_once "includes/header.php";
?>
<div id="globalContentContainer">

<div id="globalRsList">
<div class="globalListContent">
<?php include "includes/lset.php"; ?>
<span class="tTitle">Mine opgaver</span>
<?php
if(mysql_num_rows($rsTask)==0){?>
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
<tr align="center">
<td colspan="2" style="padding:25px;font-size: 12px;color:#000000;text-shadow: 0 -1px 3px #000;font-weight:bold;">Du har endnu ikke oprettet nogle opgaver. <a href="<?php echo "http://$host$path/";?>tcreate.php">Opret nu!</a></td>
</tr>
</table>
<? }
else{
echo '<ul id="globalListContentRs">';
while($row=mysql_fetch_assoc($rsTask)){
echo "
<li class='rsListed' onclick='javascript:location.href=\"http://$host$path/tasks/$row[tname]\"' onmouseover='javascript:this.style.cursor=\"pointer\"'>
<div class='rsTop'>
<a href='http://$host$path/tasks/$row[tname]' class='rsTitle tool'>$row[name]<span class='tip t l'>Opgavetitle<span class='tarrow at l'></span></span></a>
<span class='rsDate tool'>";
cpTime($row['time'],$row['date'], "%d-%m-%Y");
echo "<span class='tip t l'>Tid<span class='tarrow at l'></span></span>
</span>
</div>
<div class='rsDesc tool'>";
addDots($row['desc'],0,125);
echo "<span class='tip t l'>Beskrivelse<span class='tarrow at l'></span></span>
</div>
<div class='rsBottom'>
<span class='rsBudget tool'>$row[budget]<span class='tip t l'>Budget<span class='tarrow at l'></span></span></span>
<span class='rsComp tool'>$row[comp]<span class='tip t l'>Kompetencer<span class='tarrow at l'></span></span></span>
</div>
<form action='' method='post'>
<input type='hidden' name='delid' id='delid' value='$row[id]' />
<input type='submit' name='delc' id='delc' style='display:block;text-shadow:0 0 0;font-weight:bold;border:0;background:transparent;' value='X' title='Slet $row[name]' onclick='return confirmB(\"Er du sikker på, at du vil slette opgaven?\");' />
</form>
</li>";
}
echo "<li class='searchMsg'>Der vises $numRows opgaver</li></ul>";
}
?>
</div>
</div>

</div>
<?php require_once "includes/footer.php";?>
</div>
</body>
</html>