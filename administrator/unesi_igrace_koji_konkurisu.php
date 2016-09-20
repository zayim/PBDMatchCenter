<?php
session_start(); if (!isset($_SESSION['pbd_mc_un'])) { header("Location: index.php"); die(); }
$head=false;
require_once("konekcija.php");
if (isset($_SESSION['head']) && $_SESSION['head']=='true') $head=true;

$rez=mysql_query("SELECT * FROM utakmice WHERE status!=0");
if ($rez)
{
	if (mysql_num_rows($rez)>1) { header("Location: greska.php?tip=multiple"); die(); }
	elseif (mysql_num_rows($rez)==1)
	{
		$utakmica=mysql_fetch_assoc($rez);
		$id=$utakmica['id'];
		//$treba_zavrsiti=true;
	}
}
else { header("Location: greska.php"); die(); }

$status=$utakmica['status'];
$domacin_ime=$utakmica['domacin'];
$gost_ime=$utakmica['gost'];
$id=$utakmica['id'];
$takm=$utakmica['takmicenje'];
if ($takm==0) $takmicenje="Liga BBVA"; else if ($takm==1) $takmicenje="Liga Prvaka"; else if ($takm==2) $takmicenje="Kup Kralja";
else if ($takm==3) $takmicenje="Superkup Španije"; else if ($takm==4) $takmicenje="UEFA Superkup";
else if ($takm==5) $takmicenje="FIFA Svjetsko klupsko prvenstvo"; else $takmicenje="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Match Center | Admin</title>
<link rel="stylesheet" type="text/css" href="main.css" />
<script type="text/javascript" src="ajax_zahtjev.js"> </script>
<script type="text/javascript" src="unesi_igrace_koji_konkurisu.js"> </script>
</head>

<body onload="dodaj_prostor_za_igraca()">
<?php
if (isset($_POST['broj_igraca'])) // AKO SMO POSLALI PODATKE NA FORMU
{
	$broj_igraca=$_POST['broj_igraca']-1;
	
	if ($broj_igraca<18)
	{
		echo<<<_END
		<div id="omotac">
			<br>
			<center>
				<br /> <br/>
				<center><label class="labela"> Morate imati bar 18 igrača! </label> <br/><br />
				<a href="admin.php" class="dugme"> Povratak </a></center><br />
				<br /> <br />
			</center>
			<br>
		</div>
_END;
		die();
	}
	
	izbrisiPodatke();
	
	$imaGreska=false;
	
	for ($i=1; $i<=$broj_igraca; $i++)
	{
		$tmp1="dres_$i"; $tmp2="ime_$i"; $broj_pozicija=1;
		if (!isset($_POST["dres_$i"])) { die("Greska1"); }
		if (!isset($_POST["ime_$i"])) { die("Greska2"); }
		if (!isset($_POST["pozicije_$i"])) $broj_pozicija=0;
		
		$dres=$_POST["dres_$i"]; $ime=popraviString($_POST["ime_$i"]);
		
		if ($ime!="" && $dres!="")
		{
			$rez=mysql_query("INSERT INTO igraci(ime,broj_na_dresu) VALUES ('$ime',$dres)");
			if ($rez==false) { $imaGreska=true; break; }
			$umetnuti_id=mysql_insert_id();
		
			if ($broj_pozicija>0) { $pozicije=$_POST["pozicije_$i"];  $broj_pozicija=count($pozicije); }
		
			for ($j=0; $j<$broj_pozicija; $j++)
			{
				$tmp=$pozicije[$j];
				$rez=mysql_query("INSERT INTO $tmp(id_igraca) VALUES($umetnuti_id)");
				if ($rez==false) { $imaGreska=true; break; }
			}
		}
	}
	
	if ($imaGreska)
	{
		 izbrisiPodatke();
		 header("Location: greska.php"); die();
	}
	
	echo<<<_END
	<div id="meni" style="margin-top:50px;">
	<center>
	<a href="http://www.barcabih.com" class="lista"> Barca BiH </a> <span style="color:#CCC"> | </span>
	<a href="../index.php" class="lista"> Match Center </a> <span style="color:#CCC"> | </span>
	<a href="arhiva.php" class="lista"> Arhiva utakmica </a> <span style="color:#CCC"> | </span>
_END;
	if ($head) echo<<<_END
	<a href="dodaj_admina.php" class="lista"> Dodaj admina </a> <span style="color:#CCC"> | </span>
_END;
	echo <<<_END
	<a href="./logout.php" class="lista"> Odjavi se </a>
	</center>
	</div>
_END;


echo<<<_END
	<div id="omotac">
	<br>
	<center>
		<br /> <br/>
		<center><label class="labela"> Uspješno ste unijeli igrače! </label> <br/><br />
		<a href="admin.php" class="dugme"> Povratak </a></center><br />
		<br /> <br />
	</center>
	<br>
</div>
_END;

}
else // AKO NISMO POSLALI PODATKE NA FORMU
{
	echo<<<_END
	<div id="meni" style="margin-top:50px;">
	<center>
	<a href="http://www.barcabih.com" class="lista"> Barca BiH </a> <span style="color:#CCC"> | </span>
	<a href="../index.php" class="lista"> Match Center </a> <span style="color:#CCC"> | </span>
	<a href="arhiva.php" class="lista"> Arhiva utakmica </a> <span style="color:#CCC"> | </span>
_END;
	if ($head) echo<<<_END
	<a href="dodaj_admina.php" class="lista"> Dodaj admina </a> <span style="color:#CCC"> | </span>
_END;
	echo <<<_END
	<a href="./logout.php" class="lista"> Odjavi se </a>
	</center>
</div>
_END;
	
	echo<<<_END
	<center><div id="omotac" style="width:600px; padding:10px;">
	<form action="unesi_igrace_koji_konkurisu.php" method="post" onsubmit="foo()">
	<table id="tabela">
		<tr>
			<td class="dres"> Dres </td>
			<td class="ime"> Ime igrača </td>
			<td class="poz"> GK </td>
			<td class="poz"> RB </td>
			<td class="poz"> LB </td>
			<td class="poz"> CB </td>
			<td class="poz"> DMF </td>
			<td class="poz"> RMF </td>
			<td class="poz"> LMF </td>
			<td class="poz"> RWF </td>
			<td class="poz"> LWF </td>
			<td class="poz"> CF </td>
			<input type="hidden" value=0 id="trik0" />
		</tr>
	</table>
	<input type="hidden" name="broj_igraca" value=0 />
	<center><input type="submit" class="dugme" value="Dodaj" />
	<input type="button" value="Povratak" class="dugme" onclick="window.location.href='admin.php'"/></center>
	</form>
	</div></center>
_END;
}
?>
</body>
</html>