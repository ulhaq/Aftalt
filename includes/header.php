<?php
echo '<noscript><div align="center" class="error" style="z-index:801;">Javascript understøttes ikke eller er deaktiveret på din browser, dette kan påvirke nogle funktioner på websitet.</div></noscript>';

if(!empty($err))  {
echo "<div class=\"error\">";
foreach ($err as $e) {
echo "$e<br />";
}
echo "</div>";	
}
if(!empty($msg))  {
echo "<div class=\"msg\">" . $msg[0] . "</div>";
}

if(isset($_COOKIE['a_userid'])){$_SESSION['a_userid']=$_COOKIE['a_userid'];}
list($dUserId)=mysql_fetch_row(mysql_query("SELECT a_userid FROM users WHERE a_userid='$_SESSION[a_userid]'"));
if(isset($_SESSION['a_userid']) && $_SESSION['a_userid']!=$dUserId || isset($_COOKIE['a_userid']) && $_COOKIE['a_userid']!=$dUserId){logout();}

$loggedId=getUserInfo(0);
$readRs=mysql_query("SELECT COUNT(*) FROM (SELECT * FROM messages ORDER BY stime DESC) AS messages WHERE (recipient='$loggedId') AND IF(sender='$loggedId', sactive='1',ractive='1') AND (nmsg='1') GROUP BY if(sender='$loggedId', recipient,sender) ORDER BY stime DESC");
list($countRead)=mysql_fetch_row($readRs);
$msgNum = mysql_num_rows($readRs);
if($msgNum>1){$nPl="e";$mPl="er";}else{$nPl="";$mPl="";}

if($msgNum>0){$nM="<img src='http://$host$path/styles/nm.png' border='0' />";$cNew="($msgNum)";$newMsgTip="<span class='tip b l'>Du har $msgNum ny$nPl besked$mPl<span class='tarrow ab r'></span></span>";}

echo "<div id='linksTopRight'><ul>";
if(logged()==false){
echo "
<li><a href='http://$host$path/login.php'>Log ind</a></li>
<li><a href='http://$host$path/register.php'>Opret profil</a></li>";
}
else{
echo "<li class='tool'><a href='http://$host$path/account.php'>Min konto $nM</a>$newMsgTip</li>";
if(userRole()==5){
echo "<li><a rel='nofollow' href='http://$host$path/admin/'>Admin site</a></li>";
}
echo "<li><a href='http://$host$path/logout.php?cmd=logout&id=".md5($_SESSION['a_userid'])."'>Log ud</a></li>";
}

echo "<li><a href='http://$host$path/wset.php' class='tool'>?<span class='tip b r'>Tastaturgenveje<span class='tarrow ab r'></span></span></a></li>
</ul>
</div>

<div id='globalContainer'>
<div id='globalLogoContainer'><a href='http://$host$path/index.php' id='globalLogoContent' title='Hjem'></a></div>

<ul id='globalNav'>
<li><a href='http://$host$path/index.php'>Hjem</a></li>
<li><a href='http://$host$path/tasks.php'>Find opgaver</a></li>
<li><a href='http://$host$path/freelancers.php'>Find freelancere</a></li>
<li><a href='http://$host$path/tcreate.php'>Opret gratis opgave</a></li>
</ul>";
?>
