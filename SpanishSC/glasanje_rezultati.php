<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Match Center | Barca BiH</title>
<link rel="shortcut icon" href="../ChampionsLeague/slike/pbd.ico" />
<link rel="stylesheet" type="text/css" href="stilovi/glasanje.css" />
<script type="text/javascript" src="skripte/skripta.js"> </script>
</head>

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
$status=$utakmica['status'];
if ($status==1) { header("Location: index.php"); die(); }

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

/// OBRADA OPISA
$opis="";
if ($broj_golova_domacin>0)
{
	$opis=$domacin_minute[0]."' ".$domacin_strijelci[0];
	if (isset($domacin_asistenti[0]))
	$opis=$opis." (".$domacin_asistenti[0].")";
}
for ($i=1; $i<$broj_golova_domacin; $i++)
{
	
	$opis=$opis.", ".$domacin_minute[$i]."' ".$domacin_strijelci[$i];
	if (isset($domacin_asistenti[$i]))
	$opis=$opis." (".$domacin_asistenti[$i].")";
}
if ($broj_golova_gost>0)
{
	if ($broj_golova_domacin>0) $opis=$opis." / ";
	$opis=$opis.$gost_minute[0]."' ".$gost_strijelci[0];
	if (isset($gost_asistenti[0]))
	$opis=$opis." (".$gost_asistenti[0].")";
}
for ($i=1; $i<$broj_golova_gost; $i++)
{
	
	$opis=$opis.", ".$gost_minute[$i]."' ".$gost_strijelci[$i];
	if (isset($gost_asistenti[$i]))
	$opis=$opis." (".$gost_asistenti[$i].")";
}


/// OBRADA SASTAVA

$upit="SELECT * FROM sastav_$id WHERE da_li_igra IN (1,3) ORDER BY id";
$rez=mysql_query($upit);
if ($rez==false) { header("Location: greska.php"); die(); }

$imena=Array(); $brojevi=Array(); $glasovi_igrac_utakmice=Array(); $brojevi_ocjena=Array(); $prosjecne_ocjene=Array();
for ($i=0; $i<11; $i++)
{
	$red=mysql_fetch_assoc($rez);
	$imena[]=$red['ime']; $brojevi[]=$red['broj_na_dresu']; $glasovi_igrac_utakmice[]=$red['glasovi_igrac_utakmice'];
	$brojevi_ocjena[]=$red['broj_ocjena']; $prosjecne_ocjene[]=$red['prosjecna_ocjena'];
}

$upit="SELECT * FROM sastav_$id WHERE da_li_igra=2 ORDER BY id";
$rez=mysql_query($upit);
if ($rez==false) { header("Location: greska.php"); die(); }
$broj_sa_klupe=mysql_num_rows($rez);
$klupa_imena=Array(); $klupa_brojevi=Array(); $klupa_glasovi_igrac_utakmice=Array(); $klupa_brojevi_ocjena=Array(); $klupa_prosjecne_ocjene=Array();
for ($i=0; $i<$broj_sa_klupe; $i++)
{
	$red=mysql_fetch_assoc($rez);
	$klupa_imena[]=$red['ime']; $klupa_brojevi[]=$red['broj_na_dresu']; $klupa_glasovi_igrac_utakmice[]=$red['glasovi_igrac_utakmice'];
	$klupa_brojevi_ocjena[]=$red['broj_ocjena']; $klupa_prosjecne_ocjene[]=$red['prosjecna_ocjena'];
}
$rez_=mysql_query("SELECT SUM(glasovi_igrac_utakmice) AS zbir FROM sastav_$id");
$red_=mysql_fetch_assoc($rez_);
$ukupno_glasova=$red_['zbir'];

?>

<body>

<center>
<div style="font-family:Trebuchet; font-size:36px; color:#FFF; margin-top:10px">
<?php echo "$domacin $rezultat_domacin-$rezultat_gost $gost"; ?>
<br />
<span style="font-family:Trebuchet; font-size:22px; color:#FFF;"> <?php echo $opis; ?></span>
 
</div>
</center>
<center>
<span class="powered_by">
Powered by: <a href="http://www.barcabih.com" style="cursor:url(../slike/cursor.png), pointer;"> Bar&#231;a BiH</a> | Igrač utakmice i ocjene
</span>
</center>

<?php

	echo "<div id='omotac'>";
	echo "<table style='margin:auto;'>";
	echo "<tr><td> <div style='height:85px'></div></td></tr>";
	echo "<tr style='width:100%'><td class='broj' style='color:#FFF; background:none; width:50px; font-family:Trebuchet'>Dres</td>";
	echo "<td class='broj' style='color:#FFF; background:none; font-family:Trebuchet'>Igrač</td>";
	echo "<td class='broj' style='color:#FFF; background:none; width:150px; font-family:Trebuchet'>Ocjena</td>";
	echo "<td class='broj' style='color:#FFF; background:none;  width:150px; font-family:Trebuchet'>Igrač utakmice</td></tr>";
	echo "<tr><td> <div style='height:10px'></div></td></tr>";
	for ($i=0; $i<11; $i++)
	{
		echo "<tr>";
		echo "<td class='broj'>".$brojevi[$i]."</td><td class='ime'>".$imena[$i]."</td>";
		echo "<td class='stats'>";
		echo round($prosjecne_ocjene[$i],2)." (".$brojevi_ocjena[$i].")";
		echo "</td>";
		
		echo "<td class='stats'>";
		echo $glasovi_igrac_utakmice[$i];
		if ($glasovi_igrac_utakmice[$i]>0) echo " (".round(($glasovi_igrac_utakmice[$i]*100)/$ukupno_glasova,2)."%)";
		echo "</td>";
		
		echo "</tr>";
	}
	
	echo "<tr><td> <div style='height:10px'></div></td></tr>";
	
	for ($i=0; $i<$broj_sa_klupe; $i++)
	{
		echo "<tr>";
		echo "<td class='broj'>".$klupa_brojevi[$i]."</td><td class='ime'>".$klupa_imena[$i]."</td>";
		echo "<td class='stats'>";
		echo round($klupa_prosjecne_ocjene[$i],2)." (".$klupa_brojevi_ocjena[$i].")";
		echo "</td>";
		
		echo "<td class='stats'>";
		echo $klupa_glasovi_igrac_utakmice[$i];
		if ($klupa_glasovi_igrac_utakmice[$i]>0) echo " (".round(($klupa_glasovi_igrac_utakmice[$i]*100)/$ukupno_glasova,2)."%)";
		echo "</td>";
		
		echo "</tr>";
	}
	echo "</table>";
	
	echo<<<_END
	<div style="height:10px"> &nbsp; </div>
	<center>
	<label class="broj" style="font-size:24px; font-family:Trebuchet; color:#FFF; background:none"> Igrač utakmice: </label>
	<label class="ime" style="padding-left:5px; font-size:24px; background:none">
_END;
	
	$max_glasova=$glasovi_igrac_utakmice[0]; $igrac_utakmice=$imena[0];
	for ($i=1; $i<11; $i++)
	{
		if ($glasovi_igrac_utakmice[$i]>$max_glasova)
		{
			$max_glasova=$glasovi_igrac_utakmice[$i];
			$igrac_utakmice=$imena[$i];
		}
	}
	for ($i=0; $i<$broj_sa_klupe; $i++)
	{
		if ($klupa_glasovi_igrac_utakmice[$i]>$max_glasova)
		{
			$max_glasova=$klupa_glasovi_igrac_utakmice[$i];
			$igrac_utakmice=$klupa_imena[$i];
		}
	}
	
	echo $igrac_utakmice." (glasova: ".$max_glasova;
        if ($ukupno_glasova!=0) echo " - ".round(($max_glasova*100)/$ukupno_glasova,2)."%)";
        else echo ")";
	
	echo "</label></center>";
	
	echo <<<_END
	</div>
	<input type="hidden" id="broj_sa_klupe" name="broj_sa_klupe" value=$broj_sa_klupe>
	<input type="hidden" id="igrac_utakmice" name="igrac_utakmice" value=-1>
	<center>
	 <input type="button" value="Početna" class="dugme" onclick="window.location.href='index.php'"/>
	 </center>
_END;

?>


</body>
</html>
