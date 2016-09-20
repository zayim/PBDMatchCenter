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
if (isset($_POST['link'])) // DODAJEMO PODATKE
{
	
	$link=popraviString($_POST['link']);
	$upit="INSERT INTO linkovi_$id(link) VALUES('$link')";
	$rez=mysql_query($upit);
	if ($rez==false) { header("Location: greska.php"); die(); }
	
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
	echo<<<_END
<div id="omotac" style="width:550px">
<br>
	<form action="dodaj_link.php" method="post">
	<center>
	
	<label class="labela"> Link: </label><br>
	<input type="text" id="link" name="link" class="polje" style="width:90%"/> <br>
	
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