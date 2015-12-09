<?php
require_once "includes/config.php";
$id = $_GET['id'];
if(!empty($id)){
$rs = mysql_query("SELECT tasks.id,tasks.name,tasks.budget,tasks.deadline,tasks.location,tasks.comp,tasks.`desc`,tasks.time,tasks.date,tasks.uid,tasks.active, users.id,users.name,users.username,users.email,users.phone,users.website,users.a_userid FROM tasks INNER JOIN users ON (tasks.id='1' AND users.id=tasks.uid)") or $err[]="Opgaven findes ikke";
list($tId,$name,$budget,$deadline,$location,$comp,$desc,$time,$date,$tUId,$active,$uId,$uName,$uUsername,$uEmail,$uPhone,$uWebsite,$uUserId,$active)=mysql_fetch_row($rs);
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

$actStatus = $active==0 ? 1 : 0;
$actTxtStatus = $actStatus==1 ? "Deaktiver" : "Aktiver";

if(isset($_GET['act']) && !empty($_GET['taskid'])){
mysql_query("UPDATE tasks SET active='$_GET[act]' WHERE id='$_GET[taskid]'") or die(mysql_error());
$msg[] = $_GET[act] == 0 ? "Opgaven er deaktiveret." : "Opgaven er aktiveret.";
}

require_once "includes/header.php";
?>
<div id="globalContentContainer">

<div id="globalRsList">
<div class="globalListContent">
<span class="pTitle top"><?php echo $name; ?></span>
<span class="tTitle top">Opgave beskrivelse</span>
<table border="0" align="center" cellpadding="5" cellspacing="3" width="100%" class="formStyle">
<tr> 
<td style="border-bottom:2px dotted #CCC;">Aktivations status</td><td style="border-bottom:2px dotted #CCC;"><a href='tdetails.php?id=<?php echo $id; ?>&act=<?php echo $actStatus; ?>&taskid=<?php echo $tId; ?>' title='<?php echo "$actTxtStatus $name";?>'><?php echo $actTxtStatus; ?></a></td>
</tr>
<tr> 
<td style="border-bottom:2px dotted #CCC;">Oprettet:</td><td style="border-bottom:2px dotted #CCC;"><?php echo $date; ?></td>
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
<td style="border-bottom:2px dotted #CCC;">Brugernavn:</td><td style="border-bottom:2px dotted #CCC;"><a href="<?php echo "http://$host$path/fdetails.php?id=$uId";?>"><?php echo $uUsername; ?></a></td>
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
<? }
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
