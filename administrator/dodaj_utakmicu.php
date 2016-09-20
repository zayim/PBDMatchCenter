<?php
session_start(); if (!isset($_SESSION['pbd_mc_un'])) { header("Location: index.php"); die(); }
$head=false;
require_once("konekcija.php");
if (isset($_SESSION['head']) && $_SESSION['head']=='true') $head=true;
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

if (isset($_POST['domacin'])) // AKO SMO POSLALI PODATKE
{
	if (!isset($_POST['gost'])) { header("Location: greska.php"); die(); }
	if (!isset($_POST['opis'])) { header("Location: greska.php"); die(); }
	if (!isset($_POST['takmicenje'])) { header("Location: greska.php"); die(); }
	$domacin=popraviString($_POST['domacin']); $gost=popraviString($_POST['gost']); $opis=popraviString($_POST['opis']);
	$takmicenje=$_POST['takmicenje'];
	
	if ($domacin=="" || $gost=="") // ŠTA AKO NISMO UNIJELI GOSTA ILI DOMAĆINA
	{
		header("Location: greska.php?tip=homeawayerr"); die();
	}
	
	$treba_zavrsiti=false;
	if (isset($_GET['zavrsi_id']))
	{
		$zavrsi_id=$_GET['zavrsi_id'];
		$treba_zavrsiti=true;
	}
	else
	{
		$rez=mysql_query("SELECT id FROM utakmice WHERE status!=0");
		if ($rez)
		{
			if (mysql_num_rows($rez)>1) { header("Location: greska.php?tip=multiple"); die(); }
			elseif (mysql_num_rows($rez)==1)
			{
				$red=mysql_fetch_assoc($rez);
				$zavrsi_id=$red['id'];
				$treba_zavrsiti=true;
			}
		}
		else { header("Location: greska.php"); die(); }
	}

	if ($treba_zavrsiti) //// ZAVRŠI UTAKMICU
	{
		mysql_query("UPDATE utakmice SET status=0 WHERE id=$zavrsi_id");
		izbrisiPodatke();
		mysql_query("DROP TABLE linkovi_$zavrsi_id");
	}
	
	$upit="INSERT INTO utakmice(domacin,gost,opis,takmicenje,status) VALUES('$domacin','$gost','$opis',$takmicenje,1)";
	$rez=mysql_query($upit);
	if ($rez==false) { header("Location: greska.php"); die(); }
	
	$id_umetnute=mysql_insert_id();
	
	//// TABELA ZA LINKOVE
	$upit="CREATE TABLE linkovi_$id_umetnute(
					id INT AUTO_INCREMENT,
					link VARCHAR(255) NOT NULL,
					PRIMARY KEY(id)
					) ENGINE=InnoBD";
	$rez=mysql_query($upit);
	if ($rez==false) { header("Location: greska.php"); die(); }
	/////
	
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
		<center><label class="labela"> Uspješno ste unijeli utakmicu!<br />
		Sada unesite igrače koji konkurišu! </label> <br/><br />
		<a href="unesi_igrace_koji_konkurisu.php" class="dugme"> Unesi igrače </a></center><br />
		<br /> <br />
	</center>
	<br>
</div>
_END;

}


else // AKO TEK OTVARAMO STRANICU
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
<div id="omotac" style="width:550px">
<br>
	<form action="dodaj_utakmicu.php" method="post">
	<center>
	<table>
		<tr>
			<td> <label class="labela"> Domaćin </label> </td>
			<td> <input type="text" id="domacin"  name="domacin" class="polje"/> </td>
		</tr>
		<tr>
			<td> <label class="labela"> Gost </label> </td>
			<td> <input type="text" id="gost"  name="gost" class="polje"/> </td>
		</tr>
		<tr>
			<td> <label class="labela"> Opis (vrijeme/mjesto) </label> </td>
			<td> <input type="text" id="opis"  name="opis" class="polje" /> </td>
		</tr>
		<tr>
			<td> <label class="labela"> Takmičenje </label> </td>
			<td>
				<select class="polje" id="takmicenje"
				onchange="document.getElementById('takm').value=this.options[this.selectedIndex].value">
					<option selected value=0> La Liga </option>
					<option value=1> Liga Prvaka </option>
					<option value=2> Kup Kralja </option>
					<option value=3> Superkup Španije </option>
					<option value=4> UEFA Superkup </option>
					<option value=5> FIFA Svjetsko klupsko prvenstvo </option>
					<option value=6> Prijateljska </option>
				</select>
			</td>
		</tr>
	</table>
	<input type="hidden" name="takmicenje" id="takm" value=0 />
	<input type="submit" value="Dodaj" class="dugme"/>
	</center>
	</form>
<br>
</div>
_END;
}
?>

</body>
</html>