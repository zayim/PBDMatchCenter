<?php

require_once("konekcija.php");
$upit="SELECT * FROM utakmice WHERE status !=0";
$rez=mysql_query($upit); 
if ($rez==false || mysql_num_rows($rez)!=1) { header("Location: greska.php"); die(); }
$utakmica=mysql_fetch_assoc($rez);
$status=$utakmica['status'];

if ($status==1) { /*header("Location: anketa.php"); die();*/ echo"<body><script type='text/javascript'>window.location.href='anketa.php';</script></body>"; }
elseif ($status==2) { header("Location: zvanicni_sastav.php"); die(); }
elseif ($status==3) { header("Location: live.php"); die(); }
elseif ($status==4) { header("Location: glasanje.php"); die(); }
else { header("Location: greska.php"); die(); }

?>