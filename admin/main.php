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
<title>Admin<?php echo "$webTitle";?></title>
</head>
<body>
<?php
protection();

if(isset($_GET['appr']) && !empty($_GET['userid'])){
mysql_query("UPDATE users SET approval='$_GET[appr]' WHERE id='$_GET[userid]'") or die(mysql_error());
$msg[] = $_GET[appr] == 0 ? "Kontoen er deaktiveret." : "Kontoen er aktiveret.";
}

if(isset($_GET['act']) && !empty($_GET['taskid'])){
mysql_query("UPDATE tasks SET active='$_GET[act]' WHERE id='$_GET[taskid]'") or die(mysql_error());
$msg[] = $_GET[act] == 0 ? "Opgaven er deaktiveret." : "Opgaven er aktiveret.";
}
require_once "includes/header.php";
?>
<div id="globalContentContainer">

<div id="globalRsList">
<div class="globalListContent">
<span class="pTitle top">Seneste Aktiviteter</span>
<span class="tTitle">Seneste 5 brugere</span>
<?php
$fRs = mysql_query("SELECT * FROM users ORDER BY id DESC LIMIT 0,5");
$fRsNum = mysql_num_rows(mysql_query("SELECT * FROM users"));
echo "<table width='100%' align='center' class='formStyle'>";
if($fRsNum>0){
echo "<tr>
<td>#</td><td>Name</td><td>Username</td><td>Registration date</td><td>Level</td><td>Approval</td><td>Actions</td>
</tr>";
while($row=mysql_fetch_assoc($fRs)){
$apprStatus = $row['approval']==0 ? 1 : 0;
$apprTxtStatus = $apprStatus==0 ? "Deaktiver" : "Aktiver";
echo "
<tr style='color:#666;'>
<td>$row[id]</td><td><a href='fdetails.php?id=$row[id]'>$row[name]</a></td><td>$row[username]</td><td>$row[register_date]</td><td>$row[level]</td><td>$row[approval]</td><td>
<a href='main.php?appr=$apprStatus&userid=$row[id]' title='$apprTxtStatus $row[name]`s konto'>$apprTxtStatus</a>
</td>
</tr>";
}
}
else if($fRsNum==0){
echo "<tr><td>Der er ingen freelancere<td></tr>";
}
echo "</table>";
?>

<span class="tTitle">Seneste 5 opgaver</span>
<?php
$tRs = mysql_query("SELECT * FROM tasks ORDER BY time DESC LIMIT 0,5");
$tRsNum = mysql_num_rows(mysql_query("SELECT * FROM tasks ORDER BY time DESC"));
echo "<table float='right' width='100%' align='center' class='formStyle'>";
if($tRsNum>0){
echo "<tr>
<td>#</td><td>Name</td><td>Description</td><td>Budget</td><td>Added</td><td>Active</td><td>Actions</td>
</tr>";
while($row=mysql_fetch_assoc($tRs)){
$actStatus = $row['active']==0 ? 1 : 0;
$actTxtStatus = $actStatus==0 ? "Deaktiver" : "Aktiver";
echo "
<tr style='color:#666;'>
<td>$row[id]</td><td><a href='tdetails.php?id=$row[id]'>$row[name]</a></td><td>";addDots($row['desc'],0,25);echo "</td><td>$row[budget]</td><td>$row[date]</td><td>$row[active]</td><td>
<a href='http://$host$path/main.php?act=$actStatus&taskid=$row[id]' title='$actTxtStatus $row[name]'>$actTxtStatus</a>
</td>
</tr>";
}
}
else if($tRsNum==0){
echo "<tr align='center'><td colspan='2' style='padding:5px;font-size: 12px;color:#000000;text-shadow: 0 -1px 3px #000;font-weight:bold;'>Der er ingen opgaver<td></tr>";
}
echo "</table>";
?>
</div>
</div>

</div>
<?php require_once "includes/footer.php";?>
</div>
</body>
</html>
