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

$imena=Array(); $brojevi=Array(); $idovi=Array();
for ($i=0; $i<11; $i++)
{
	$red=mysql_fetch_assoc($rez);
	$imena[]=$red['ime']; $brojevi[]=$red['broj_na_dresu']; $idovi[]=$red['id'];
}

$upit="SELECT * FROM sastav_$id WHERE da_li_igra=2 ORDER BY id";
$rez=mysql_query($upit);
if ($rez==false) { header("Location: greska.php"); die(); }
$broj_sa_klupe=mysql_num_rows($rez);
$klupa_imena=Array(); $klupa_brojevi=Array(); $klupa_idovi=Array();
for ($i=0; $i<$broj_sa_klupe; $i++)
{
	$red=mysql_fetch_assoc($rez);
	$klupa_imena[]=$red['ime']; $klupa_brojevi[]=$red['broj_na_dresu']; $klupa_idovi[]=$red['id'];
}


if (isset($_POST['broj_sa_klupe']))
{
	$broj_klupa=$_POST['broj_sa_klupe'];
	if (!isset($_POST["igrac_utakmice"])) { header("Location: greska.php"); die(); }
	$igrac_utakmice=$_POST["igrac_utakmice"];
	
	$rez=mysql_query("UPDATE sastav_$id SET glasovi_igrac_utakmice=glasovi_igrac_utakmice+1 WHERE id=$igrac_utakmice");
	if ($rez==false) { header("Location: greska.php"); die(); }
	
	for ($i=0; $i<11+$broj_klupa; $i++)
	{
		if (!isset($_POST["id_$i"])) { header("Location: greska.php"); die(); }
		if (!isset($_POST["ocjena_$i"])) { header("Location: greska.php"); die(); }
		$id_igraca=$_POST["id_$i"];
		$ocjena=$_POST["ocjena_$i"];
		
		if ($ocjena!=0 && $ocjena!="0")
		{
			$rez=mysql_query("UPDATE sastav_$id SET prosjecna_ocjena=(prosjecna_ocjena*broj_ocjena+$ocjena)/(broj_ocjena+1), broj_ocjena=broj_ocjena+1
											WHERE id=$id_igraca");
			if ($rez==false) { header("Location: greska.php"); die(); }
		}
	}
	
	header("Location: glasanje_rezultati.php"); die();
}
else
{
	echo<<<_END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Match Center | Barca BiH</title>
<link rel="shortcut icon" href="slike/pbd.ico" />
<link rel="stylesheet" type="text/css" href="stilovi/glasanje.css" />
<script type="text/javascript" src="skripte/skripta.js"> </script>
</head>
<body>

<center>
<div style="font-family:SegoeBold; font-size:36px; color:#FFF; margin-top:10px">
$domacin $rezultat_domacin-$rezultat_gost $gost<br />
<span style="font-family:Segoe; font-size:22px; color:#FFF;"> $opis </span>
 
</div>
</center>
<center>
<span class="powered_by">
Powered by: <a href="http://www.barcabih.com" style="cursor:url(../slike/cursor.png), pointer;"> Bar&#231;a BiH</a> | Igrač utakmice i ocjene
</span>
</center>
_END;
	echo "<div id='omotac'>";
	echo "<form action='glasanje.php' method='post'>";
	echo "<table style='margin:auto;'>";
	echo "<tr><td> <div style='height:5px'></div></td></tr>";
	for ($i=0; $i<11; $i++)
	{
		echo "<tr>";
		echo "<td class='broj'>".$brojevi[$i]."</td><td class='ime'>".$imena[$i]."</td>";
		echo "<td class='ocjena_td'>";
		echo<<<_END
		<select class='ocjena' onchange="document.getElementById('ocjena_$i').value=this.options[this.selectedIndex].value">
_END;
		echo "<option selected value=0> - </option>";
		for ($j=10; $j>=1; $j--)
			echo "<option value=$j> $j </option>";
		echo "</select>";
		echo "</td>";
		echo<<<_END
		<input type="hidden" id="ocjena_$i" name="ocjena_$i" value=0> <input type="hidden" id="id_$i" name="id_$i" value=$idovi[$i]>
_END;
		echo "</tr>";
	}
	
	echo "<tr><td> <div style='height:10px'></div></td></tr>";
	
	for ($i=11; $i<11+$broj_sa_klupe; $i++)
	{
		echo "<tr>";
		echo "<td class='broj'>".$klupa_brojevi[$i-11]."</td><td class='ime'>".$klupa_imena[$i-11]."</td>";
		echo "<td class='ocjena_td'>";
		echo<<<_END
		<select class='ocjena' onchange="document.getElementById('ocjena_$i').value=this.options[this.selectedIndex].value">
_END;
		echo "<option selected value=0> - </option>";
		for ($j=10; $j>=1; $j--)
			echo "<option value=$j> $j </option>";
		echo "</select>";
		echo "</td>";
		$tmp=$i-11;
		echo<<<_END
		<input type="hidden" id="ocjena_$i" name="ocjena_$i" value=0> <input type="hidden" id="id_$i" name="id_$i" value=$klupa_idovi[$tmp]>
_END;
		echo "</tr>";
	}
	echo "</table>";
	
	echo<<<_END
	<div style="height:10px"> &nbsp; </div>
	<center>
	<label class="broj"> Igrač utakmice: </label>
	
	<select class='ocjena' style='margin-left:5px' onchange="document.getElementById('igrac_utakmice').value=this.options[this.selectedIndex].value">
	<option selected value=-1> Izaberi </option>
_END;
	
	for ($i=0; $i<11; $i++)
	{
		echo<<<_END
		<option value=$idovi[$i]>$imena[$i]</option>
_END;
	}
	
	for ($i=0; $i<$broj_sa_klupe; $i++)
	{
		echo<<<_END
		<option value=$klupa_idovi[$i]>$klupa_imena[$i]</option>
_END;
	}
	
	echo "</select> </center>";
	
	echo <<<_END
	</div>
	<input type="hidden" id="broj_sa_klupe" name="broj_sa_klupe" value=$broj_sa_klupe>
	<input type="hidden" id="igrac_utakmice" name="igrac_utakmice" value=-1>
	<center><input type="submit" value="Glasaj" class="dugme"/>
	 <input type="button" value="Rezultati" class="dugme" onclick="window.location.href='glasanje_rezultati.php'"/>
	 </center>
	
	</form>
_END;
}
?>


</body>
</html>