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
if (isset($_POST['link_id'])) // DODAJEMO PODATKE
{	
	$link_id=$_POST['link_id'];
	
	if ($link_id==-1) $poruka="Link je već bio izbrisan!";
	else
	{
		$poruka="Link uspješno izbrisan!";
		
		$upit="DELETE FROM linkovi_$id WHERE id=$link_id";
		$rez=mysql_query($upit);
		if ($rez==false) { header("Location: greska.php"); die(); }
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
	<form action="izbrisi_link.php" method="post">
	<center>
	<label class="labela"> Link: </label> <br> <br>
		<select class="polje" style="width:90%" onchange="document.getElementById('link_id').value=this.options[this.selectedIndex].value">
_END;

		$rez=mysql_query("SELECT * FROM linkovi_$id");
		$broj_linkova=mysql_num_rows($rez);
		$prvi_link=-1;
		
		for ($i=0; $i<$broj_linkova; $i++)
		{
			$red=mysql_fetch_assoc($rez);
			$id_linka=$red['id'];
			$tmp=$i+1;
			$ime_linka=substr($red['link'],0,80);
			echo<<<_NEDO
			<option value=$id_linka> Link $tmp: $ime_linka </option>
_NEDO;
			if ($i==0) $prvi_link=$id_linka;
		}
		
		echo<<<_END
			</select>
			
	<input type="hidden" name="link_id" id="link_id" value=$prvi_link>
	<input type="submit" value="Izbriši" class="dugme"/>
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