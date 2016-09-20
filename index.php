<?php
require_once("konekcija.php");

$upit="SELECT * FROM utakmice WHERE status!=0";
$rez=mysql_query($upit);
if ($rez==false) { header("Location: greska.php?tip=noactive"); die(); }
elseif (mysql_num_rows($rez)==0) { header("Location: greska.php?tip=noactive"); die(); }
elseif (mysql_num_rows($rez)>1) { header("Location: greska.php?tip=multiactive"); die(); }
$utakmica=mysql_fetch_assoc($rez);
$takmicenje=$utakmica['takmicenje'];

if ($takmicenje==1 || $takmicenje==2 || $takmicenje==4 || $takmicenje==5) $putanja="./ChampionsLeague/";
elseif ($takmicenje==0) $putanja="./LigaBBVA/";
/*else if ($takmicenje==1) $putanja="./ChampionsLeague/";
else if ($takmicenje==2) $putanja="./CopaDelRey/";*/
else if ($takmicenje==3) $putanja="./SpanishSC/";
/*else if ($takmicenje==4) $putanja="./UefaSC/";
else if ($takmicenje==5) $putanja="./FifaCWC/";*/
elseif ($takmicenje==6) $putanja="./Friendly/";
else  { header("Location: greska.php"); die(); }
header("Location: $putanja"); die();
?>