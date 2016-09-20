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
else if ($takm==5) $takmicenje="FIFA Svjetsko klupsko prvenstvo";
else if ($takm==6) $takmicenje="Prijateljska";
else $takmicenje="";

$broj_dozvoljenih_izmjena=3;
if ($takm==6) $broj_dozvoljenih_izmjena=1000;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Match Center | Admin</title>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>


<body>
<?php
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
if (isset($_POST['ulazi'])) // DODAJEMO PODATKE
{
	if (!isset($_POST['izlazi'])) { header("Location: greska.php"); die(); }
	$ulazi=$_POST['ulazi']; $izlazi=$_POST['izlazi'];
	
	$poruka="Uspješno uneseno!";
	$rez=mysql_query("SELECT * FROM sastav_$id WHERE da_li_igra=3");
	if ($rez==false) $poruka="Greška!";
	else if (mysql_num_rows($rez)>=$broj_dozvoljenih_izmjena) $poruka="Napravljene 3 izmjene!";
	else
	{
		mysql_query("UPDATE sastav_$id SET da_li_igra=2 WHERE id=$ulazi");
		mysql_query("UPDATE sastav_$id SET da_li_igra=3 WHERE id=$izlazi");
	}
	
	echo<<<_END
		<div id="omotac">
		<br>
		<center>
			<br /> <br/>
			<center><label class="labela"> $poruka </label> <br/><br />
			<a href="admin.php" class="dugme"> Povratak </a></center><br />
			<br /> <br />
		</center>
		<br>
		</div>
_END;
}
else
{	
	echo<<<_END
<div id="omotac" style="width:550px">
<br>
	<form action="napravi_izmjenu.php" method="post">
	<center>
	<table>
		<tr>
			<td> <label class="labela"> Izlazi igrač </label> </td>
			<td>
			<select class="polje" style="width:104%" onchange="document.getElementById('izlazi').value=this.options[this.selectedIndex].value">
_END;

		$rez=mysql_query("SELECT * FROM sastav_$id WHERE da_li_igra IN (1,2)");
		$broj_igraca=mysql_num_rows($rez);
		$prvi_izlazi=0;
		
		for ($i=0; $i<$broj_igraca; $i++)
		{
			$red=mysql_fetch_assoc($rez);
			$ime_igraca=$red['ime']; $id_igraca=$red['id'];
			echo<<<_NEDO
			<option value=$id_igraca> $ime_igraca </option>
_NEDO;
		if ($i==0) $prvi_izlazi=$id_igraca;
		}
		
		echo<<<_END
			</select>
			</td>
		</tr>
		<tr>
			<td> <label class="labela"> Ulazi igrač </label> </td>
			<td> 
			<select class="polje" style="width:104%" onchange="document.getElementById('ulazi').value=this.options[this.selectedIndex].value">
_END;
		
		$rez=mysql_query("SELECT * FROM sastav_$id WHERE da_li_igra = 0");
		$broj_igraca=mysql_num_rows($rez);
		$prvi_ulazi=0;
		
		for ($i=0; $i<$broj_igraca; $i++)
		{
			$red=mysql_fetch_assoc($rez);
			$ime_igraca=$red['ime']; $id_igraca=$red['id'];
			echo<<<_NEDO
			<option value=$id_igraca> $ime_igraca </option>
_NEDO;
			if ($i==0) $prvi_ulazi=$id_igraca;
		}
		
		echo<<<_END
		</select>
		</tr>
	</table>
	<input type="hidden" name="izlazi" id="izlazi" value=$prvi_izlazi>
	<input type="hidden" name="ulazi" id="ulazi" value=$prvi_ulazi>
	<input type="submit" value="Napravi izmjenu" class="dugme" style="width:150px"/>
	<input type="button" value="Povratak" class="dugme" onclick="window.location.href='admin.php'"/></center>
	</center>
	</form>
<br>
</div>
_END;
}
?>

</body>
</html>