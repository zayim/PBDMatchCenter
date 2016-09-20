<?php

require_once("konekcija.php");

$upit="SELECT * FROM utakmice WHERE status !=0";
$rez=mysql_query($upit);

if ($rez==false || mysql_num_rows($rez)!=1) { header("Location: greska.php"); die(); }
 
 /// OBRADA UTAKMICE
$utakmica=mysql_fetch_assoc($rez);
$id=$utakmica['id'];
$domacin=$utakmica['domacin']; $gost=$utakmica['gost'];
$rezultat_domacin=$utakmica['domacin_rezultat']; $rezultat_gost=$utakmica['gost_rezultat'];
$opis=$utakmica['opis'];

/// KREIRANJE NASLOVA
$naslov="";
$domacin_niz=str_split($domacin);
$i=0; $br=0;
while ($br<3)
{
	if ($domacin_niz[$i]!=' ') { $naslov=$naslov.$domacin_niz[$i]; $br++; }
	$i++;
}
$naslov=$naslov." $rezultat_domacin:$rezultat_gost ";
$gost_niz=str_split($gost);
$i=0; $br=0;
while ($br<3)
{
	if ($gost_niz[$i]!=' ') { $naslov=$naslov.$gost_niz[$i]; $br++; }
	$i++;
}

$naslov=strtoupper($naslov)." | Barca BiH";

/// OBRADA DOMAĆINA
$domacin_strijelci=Array();
$domacin_asistenti=Array();
$domacin_minute=Array();
$upit="SELECT * FROM domacin_$id ORDER BY min";
$rez=mysql_query($upit);
$broj_golova_domacin=mysql_num_rows($rez);
for ($i=0; $i<$broj_golova_domacin; $i++)
{
	$red=mysql_fetch_assoc($rez); $domacin_minute[]=$red['min'];
	$domacin_strijelci[]=$red['strijelac']; $domacin_asistenti[]=$red['asistent'];
}

/// OBRADA GOSTA
$gost_strijelci=Array();
$gost_asistenti=Array();
$gost_minute=Array();
$upit="SELECT * FROM gost_$id ORDER BY min";
$rez=mysql_query($upit);
$broj_golova_gost=mysql_num_rows($rez);
for ($i=0; $i<$broj_golova_gost; $i++)
{
	$red=mysql_fetch_assoc($rez); $gost_minute[]=$red['min'];
	$gost_strijelci[]=$red['strijelac']; $gost_asistenti[]=$red['asistent'];
}

/// OBRADA SASTAVA

$upit="SELECT * FROM sastav_$id WHERE da_li_igra IN (1,2) ORDER BY id";
$rez=mysql_query($upit);
if ($rez==false) { header("Location: greska.php"); die(); }

$imena=Array(); $brojevi=Array(); $statusi=Array();
for ($i=0; $i<11; $i++)
{
	$red=mysql_fetch_assoc($rez);
	$imena[]=$red['ime']; $brojevi[]=$red['broj_na_dresu']; $statusi[]=$red['da_li_igra'];
}


$upit="SELECT * FROM sastav_$id WHERE da_li_igra IN (0,3) ORDER BY id";
$rez=mysql_query($upit);
if ($rez==false) { header("Location: greska.php"); die(); }

$klupa_imena=Array(); $klupa_brojevi=Array(); $klupa_statusi=Array();
for ($i=0; $i<7; $i++)
{
	$red=mysql_fetch_assoc($rez);
	$klupa_imena[]=$red['ime']; $klupa_brojevi[]=$red['broj_na_dresu']; $klupa_statusi[]=$red['da_li_igra'];
}

/// OBRADA LIVE STREAMA
$stream_on=false;
$stream_id=-1;

if (isset($_GET['stream_on']) && $_GET['stream_on']='yes')
{
	$stream_on=true;
	if (!isset($_GET['stream_id'])) { $stream_on=false; }
	else
	{
		$stream_id=popraviString($_GET['stream_id']);
		
		$upit="SELECT * FROM linkovi_$id WHERE id=$stream_id";
		//die($upit);
		$rez=mysql_query($upit);
		if ($rez==false || mysql_num_rows($rez)==0) $stream_on=false;
		else
		{
			$red=mysql_fetch_assoc($rez);
			$link_streama=$red['link'];
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "$naslov"; ?></title>
<link rel="stylesheet" type="text/css" href="stilovi/live.css" />
<script type="text/javascript" src="skripte/ajax_zahtjev.js"> </script>
<script type="text/javascript" src="skripte/skripta.js"> </script>
</head>
<body onload="setInterval(osvjezi_rezultat(),1000);">

<div style="height:15px"> &nbsp; </div>

<center>
<span class="powered_by">
Powered by: <a href="http://www.barcabih.com" style="cursor:url(../slike/cursor.png), pointer;"> Bar&#231;a BiH</a> |
<?php

if (!$stream_on)
echo<<<_END
<span class="klikni_live_stream"><a href="javascript:prikazi_live_stream()">Klikni za LIVE Stream prijenos</a></span>
_END;

else
echo<<<_END
<span class="klikni_live_stream"><a href='javascript:sakrij_live_stream()'>Sakrij LIVE Stream prijenos</a></span>
_END;
?>
</span>
</center>

<div style="height:15px"> &nbsp; </div>

<center>
<div>

<table id="tabela">
<tr>

<td><div id="domacin_ime"> <?php echo strtoupper($domacin); ?></div></td>

<td><div id="rezultat"> <?php echo $rezultat_domacin."&nbsp;-&nbsp;".$rezultat_gost; ?></div></td>

<td><div id="gost_ime"> <?php echo strtoupper($gost); ?></div></td>

</tr>
</table>

</div>
</center>

<center>


<div id="strijelci">
<table width="650px">
<tr>

<td width="50%"><table>
<?php
for ($i=0; $i<$broj_golova_domacin; $i++)
{
	echo "<tr><td class='rezultat_td' style='padding-left:30px'> ".$domacin_minute[$i]."' </td><td class='rezultat_td'> ".$domacin_strijelci[$i];
	if (isset($domacin_asistenti[$i])) echo "&nbsp;(".$domacin_asistenti[$i].")";
	echo "</td></tr>";
}
?>
</table></td>

<td width="50%"><table>
<?php
for ($i=0; $i<$broj_golova_gost; $i++)
{
	echo "<tr><td class='rezultat_td' style='padding-left:50px'>".$gost_minute[$i]."' </td><td class='rezultat_td'> ".$gost_strijelci[$i];
	if (isset($gost_asistenti[$i])) echo "&nbsp;(".$gost_asistenti[$i].")";
	echo "</td></tr>";
}
?>
</table></td>

</tr>
</table>
</div>
</center>

<div id="live_stream">
</div>

<center>
<div id="sastav">

<table width="95%"><tr>
<td width="50%"><table>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<?php
for ($i=0; $i<11; $i++)
{
	echo "<tr>";
	echo "<td class='sastav_td_broj'>".$brojevi[$i]."</td><td class='sastav_td_ime'>".$imena[$i];
	if (isset($statusi[$i]) && $statusi[$i]==2) echo " (Ušao s klupe)";
	echo "</td>";
	echo "</tr>";
}
?>
</table></td>

<td width="50%">
<span class="sastav_td_broj">
KLUPA
</span>
<table>

<?php
for ($i=0; $i<7; $i++)
{
	echo "<tr>";
	echo "<td class='sastav_td_broj' style='color:#CCC'>".$klupa_brojevi[$i]."</td><td class='sastav_td_ime' style='color:#CCC'>".$klupa_imena[$i];
	if (isset($klupa_statusi[$i]) && $klupa_statusi[$i]==3) echo " (Izašao iz igre)";
	echo "</td>";
	echo "</tr>";
}
?>
</table></td>
</tr></table>

</div>
</center>

<center>
<input type="button" class="dugme" value="Osvježi" onclick="window.location.href='index.php';" />
</center>
</body>
</html>