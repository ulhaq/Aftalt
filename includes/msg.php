<?php
require_once "config.php";
$q = trim($_GET['q']);
$limit = @$_GET['s'];
$loggedId=getUserInfo(0);
if(empty($limit) || $limit<10){
$limit = 10;
}
else{
$limit = ceil($limit/10)*10;
}

if(!empty($q)){
$rs = mysql_query("SELECT *, COUNT(*), (SELECT nmsg FROM messages WHERE (recipient='$loggedId') AND IF(sender='$loggedId', sactive='1',ractive='1') AND (nmsg='1') GROUP BY if(sender='$loggedId', recipient,sender)) AS msgRead,IF(sender='$loggedId', recipient,sender) AS msgUserId FROM (SELECT * FROM messages WHERE (sendername LIKE '%$q%' OR recipientname LIKE '%$q%' OR subject LIKE '%$q%' OR msg LIKE '%$q%' OR sdate LIKE '%$q%') ORDER BY stime DESC) AS messages WHERE (sender='$loggedId' OR recipient='$loggedId') AND IF(sender='$loggedId', sactive='1',ractive='1') GROUP BY if(sender='$loggedId', recipient,sender) ORDER BY stime DESC LIMIT 0,$limit");
$numrowslimit = mysql_num_rows($rs);
$numrows = mysql_num_rows(mysql_query("SELECT *, COUNT(*) FROM (SELECT * FROM messages WHERE (sendername LIKE '%$q%' OR recipientname LIKE '%$q%' OR subject LIKE '%$q%' OR msg LIKE '%$q%' OR sdate LIKE '%$q%') ORDER BY stime DESC) AS messages WHERE (sender='$loggedId' OR recipient='$loggedId') AND IF(sender='$loggedId', sactive='1',ractive='1') GROUP BY if(sender='$loggedId', recipient,sender) ORDER BY stime DESC"));
if($numrows>0){
$a = $limit;
if ($a > $numrows){
$a = $numrows;
}
$b = 1 ;
$numbers = number_format($numrows);
if($numrows==1){
echo "<li class='searchMsg' style=-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;'>Der vises 1 besked for søgningen <i>'$q'</i></li>";
}
elseif($numrows>1){
echo "<li class='searchMsg' style=-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;'>Der vises $b - $a ud af ca. $numbers beskeder for søgningen <i>'$q'</i></li>";
}
while($row=mysql_fetch_assoc($rs)){
if(isset($row['msgRead']) && $row['msgRead']=="1"){$isNew=" style='background:#FFFE96;'";}else{$isNew="";}
echo "
<li class='rsListed'$isNew onclick='javascript:location.href=\"messages/$row[msgUserId]\"' onmouseover='javascript:this.style.cursor=\"pointer\"'>
<div class='rsTop'>
<a href='messages/$row[msgUserId]' class='rsTitle tool'>";
echo highlight($q,$row['subject']);
echo " (".$row['COUNT(*)'].")";
echo "<span class='tip t l'>Emne<span class='tarrow at l'></span></span></a>
<span class='rsDate tool'>";
echo highlight($q,$row['sendername']);
echo "<span class='tip t l'>Afsender<span class='tarrow at l'></span></span></span>
</div>
<div class='rsDesc tool'>";
addDots(highlight($q,$row['msg']),0,125);
echo "<span class='tip t l'>Senste besked<span class='tarrow at l'></span></span>
</div>
<div class='rsBottom'>
<span class='rsBudget tool'>";
echo highlight($q,$row['recipientname']);
echo "<span class='tip t l'>Modtager<span class='tarrow at l'></span></span></span>
<span class='rsComp tool'>";
echo cpTime($row['stime'],$row['sdate'],"%d-%m-%Y");
echo "<span class='tip t l'>Tid<span class='tarrow at l'></span></span></span>
</div>
<form action='' method='post'>
<input type='hidden' name='delid' id='delid' value='$row[msgUserId]' />
<input type='submit' name='delm' id='delm' style='display:block;text-shadow:0 0 0;font-weight:bold;border:0;background:transparent;' value='X' title='Slet $row[subject]' onclick='return confirmB(\"Er du sikker på, at du vil slette tråden?\");' />
</form>
</li>";
}
}
else if($numrows==0){
echo "<li class='searchMsg'>Din søgning for <i>'$q'</i> gav intet resultat</li>";
}
if($numrows>10 && $numrows!=$numrowslimit){
$limit += 10;
echo "<li class='showMore'><a href='?q=$q&s=$limit' id='showMore' onclick='loadRs(\"mq\",$limit); return false;'>Vis flere</a></li>";
}
elseif($numrows>0 && $numrows==$numrowslimit){
echo "<li class='searchMsg'>Der er ikke flere beskeder</li>";
}
}
else{
$aRs = mysql_query("SELECT *, COUNT(*), (SELECT nmsg FROM messages WHERE (recipient='$loggedId') AND IF(sender='$loggedId', sactive='1',ractive='1') AND (nmsg='1') GROUP BY if(sender='$loggedId', recipient,sender)) AS msgRead,IF(sender='$loggedId', recipient,sender) AS msgUserId FROM (SELECT * FROM messages ORDER BY stime DESC) AS messages WHERE (sender='$loggedId' OR recipient='$loggedId') AND IF(sender='$loggedId', sactive='1',ractive='1') GROUP BY if(sender='$loggedId', recipient,sender) ORDER BY stime DESC LIMIT 0,$limit") or die(mysql_error());
$rsNumL= mysql_num_rows($aRs);
$rsNum = mysql_num_rows(mysql_query("SELECT *, COUNT(*) FROM (SELECT * FROM messages ORDER BY stime DESC) AS messages WHERE (sender='$loggedId' OR recipient='$loggedId') AND IF(sender='$loggedId', sactive='1',ractive='1') GROUP BY if(sender='$loggedId', recipient,sender) ORDER BY stime DESC"));
if($rsNum>0){
$a = $limit;
if ($a > $rsNum){
$a = $rsNum;
}
$b = 1;
$aNumbers = number_format($rsNum);
if($rsNum==1){
echo "<li class='searchMsg' style=-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;'>Der vises $b besked</li>";
}
elseif($rsNum>1){
echo "<li class='searchMsg' style=-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;'>Der vises $b - $a ud af ca. $aNumbers beskeder</li>";
}
while($row=mysql_fetch_assoc($aRs)){
if(isset($row['msgRead']) && $row['msgRead']=="1"){$isNew=" style='background:#FFFE96;'";}else{$isNew="";}
echo "
<li class='rsListed'$isNew onclick='javascript:location.href=\"messages/$row[msgUserId]\"' onmouseover='javascript:this.style.cursor=\"pointer\"'>
<div class='rsTop'>
<a href='messages/$row[msgUserId]' class='rsTitle tool'>$row[subject]";
echo " (".$row['COUNT(*)'].")";
echo "<span class='tip t l'>Emne<span class='tarrow at l'></span></span></a>
<span class='rsDate tool'>$row[sendername]<span class='tip t l'>Afsender<span class='tarrow at l'></span></span></span>
</div>
<div class='rsDesc tool'>";
addDots($row['msg'],0,125);
echo "<span class='tip t l'>Senste besked<span class='tarrow at l'></span></span>
</div>
<div class='rsBottom'>
<span class='rsBudget tool'>$row[recipientname]<span class='tip t l'>Modtager<span class='tarrow at l'></span></span></span>
<span class='rsComp tool'>";
echo cpTime($row['stime'],$row['sdate'],"%d-%m-%Y");
echo "<span class='tip t l'>Tid<span class='tarrow at l'></span></span></span>
</div>
<form action='' method='post'>
<input type='hidden' name='delid' id='delid' value='$row[msgUserId]' />
<input type='submit' name='delm' id='delm' style='display:block;text-shadow:0 0 0;font-weight:bold;border:0;background:transparent;' value='X' title='Slet $row[subject]' onclick='return confirmB(\"Er du sikker på, at du vil slette tråden?\");' />
</form>
</li>";
}
}
else if($rsNum==0){
echo "<li class='searchMsg'>Der er ingen beskeder<br />For at oprette skal du ind på brugerens profil</li>";
}
if($rsNum>10 && $rsNum!=$rsNumL){
$limit += 10;
echo "<li class='showMore'><a href='?s=$limit' id='showMore' onclick='loadRs(\"mq\",$limit); return false;'>Vis flere</a></li>";
}
elseif($rsNum>0 && $rsNum==$rsNumL){
echo "<li class='searchMsg'>Der er ikke flere beskeder</li>";
}
}?>
