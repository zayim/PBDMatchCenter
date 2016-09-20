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
else if ($takm==5) $takmicenje="FIFA Svjetsko klupsko prvenstvo"; else $takmicenje="";
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
if (isset($_POST['strijelac'])) // DODAJEMO PODATKE
{
	if (!isset($_POST['barca_domacin'])) { header("Location: greska.php"); die(); }
	if (!isset($_POST['minuta']) || $_POST['minuta']=="") { header("Location: greska.php"); die(); }
	if (!isset($_POST['strijelac']) || $_POST['strijelac']=="") { header("Location: greska.php"); die(); }
	if (!isset($_POST['asistent'])) { header("Location: greska.php"); die(); }
	
	$barca_domacin=$_POST['barca_domacin']; if ($barca_domacin==1) $tabela_za_ubaciti="gost_$id"; else $tabela_za_ubaciti="domacin_$id";
	$minuta=$_POST['minuta']; $strijelac=popraviString($_POST['strijelac']); $asistent=popraviString($_POST['asistent']);
	
	if ($asistent=="Bez asistenta" || $asistent=="") $upit="INSERT INTO $tabela_za_ubaciti(min,strijelac) VALUES($minuta,'$strijelac')";
	else $upit="INSERT INTO $tabela_za_ubaciti(min,strijelac,asistent) VALUES($minuta,'$strijelac','$asistent')";
	
	$rez=mysql_query($upit);
	if ($rez==false) { header("Location: greska.php"); die(); }
	
	if ($barca_domacin==1) $upit="UPDATE utakmice SET gost_rezultat=gost_rezultat+1 WHERE id=$id";
	else $upit="UPDATE utakmice SET domacin_rezultat=domacin_rezultat+1 WHERE id=$id";
	mysql_query($upit);
	
	echo<<<_END
		<div id="omotac">
		<br>
		<center>
			<br /> <br/>
			<center><label class="labela"> Uspješno uneseno! </label> <br/><br />
			<a href="admin.php" class="dugme"> Povratak </a></center><br />
			<br /> <br />
		</center>
		<br>
		</div>
_END;
}
else
{
	if (!isset($_GET['barca_domacin'])) { header("Location: greska.php"); die(); }
	$barca_domacin=$_GET['barca_domacin'];
	
	echo<<<_END
<div id="omotac" style="width:550px">
<br>
	<form action="primi_gol.php" method="post">
	<center>
	<table>
		<tr>
			<td> <label class="labela"> Minuta </label> </td>
			<td> <input type="text" id="minuta"  name="minuta" class="polje" style="width:100%"/> </td>
		</tr>
		<tr>
			<td> <label class="labela"> Strijelac </label> </td>
			<td> <input type="text" id="strijelac"  name="strijelac" class="polje" style="width:100%"/> </td>
		</tr>
		<tr>
			<td> <label class="labela"> Asistent </label> </td>
			<td> <input type="text" id="asistent"  name="asistent" class="polje" style="width:100%" value="Bez asistenta"
						onfocus="if(this.value=='Bez asistenta') this.value=''" onblur="if(this.value=='') this.value='Bez asistenta'" /> </td>
		</tr>
	</table>
	<input type="hidden" name="barca_domacin" value=$barca_domacin>
	<input type="submit" value="Dodaj" class="dugme"/>
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