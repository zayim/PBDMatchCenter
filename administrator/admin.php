<?php session_start();

require_once("konekcija.php");

$head=false;
if (!isset($_SESSION['pbd_mc_un']))
{
	if (!isset($_POST['username']) || !isset($_POST['password'])) { header("Location: greska.php?tip=undefined"); die(); }
	$un=popraviString($_POST['username']);
	$pw=md5(popraviString($_POST['password']));
	
	
	$rez=mysql_query("SELECT * FROM admini WHERE username='$un'");
	if ($rez==false || mysql_num_rows($rez)!=1) { header("Location: greska.php?tip=badlogin"); die(); }
	$red=mysql_fetch_assoc($rez);
	
	if ($pw!=$red['password']) { header("Location: greska.php?tip=badlogin"); die(); }
	if ($red['head']==1) $head=true; else $head=false;
	
	$_SESSION['pbd_mc_un']=$un;
	if ($head) $_SESSION['head']='true'; else $_SESSION['head']='false';
}
else
{
	
	if (isset($_SESSION['head']) && $_SESSION['head']=='true') $head=true;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Match Center | Admin</title>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<div id="meni" style="margin-top:50px;">
<center>
<a href="http://www.barcabih.com" class="lista"> Barca BiH </a> <span style="color:#CCC"> | </span>
<a href="../index.php" class="lista"> Match Center </a> <span style="color:#CCC"> | </span>
<a href="arhiva.php" class="lista"> Arhiva utakmica </a> <span style="color:#CCC"> | </span>
<?php
if ($head) echo<<<_END
<a href="dodaj_admina.php" class="lista"> Dodaj admina </a> <span style="color:#CCC"> | </span>
_END;
?>
<a href="./logout.php" class="lista"> Odjavi se </a>
</center>
</div>
<div id="omotac" style="width:600px">
<?php
$upit="SELECT * FROM utakmice WHERE status!=0";
$rez=mysql_query($upit);
if ($rez==false || mysql_num_rows($rez)==0) $ima=false; else { $ima=true; $broj_aktivnih=mysql_num_rows($rez); }

if (!$ima)
{
	echo<<<_END
	<br /> <br/>
	<center><label class="labela"> Nijedna utakmica nije aktivna! </label> <br/><br />
	<a href="dodaj_utakmicu.php" class="dugme"> Dodaj utakmicu </a></center><br />
	<br /> <br />
_END;
}
else if ($broj_aktivnih==1)
{
	$utakmica=mysql_fetch_assoc($rez);
	$status=$utakmica['status'];
	$domacin_ime=$utakmica['domacin'];
	$gost_ime=$utakmica['gost'];
	$domacin_rez=$utakmica['domacin_rezultat'];
	$gost_rezultat=$utakmica['gost_rezultat'];
	$id=$utakmica['id'];
	if($status==1)  //  ANKETA PRIJE UTAKMICE U TOKU
	{
		echo<<<_END
		<br /> <br/>
	<center><label class="labela"> Naredna utakmica (u toku je anketa):<br />
	$domacin_ime vs $gost_ime </label> <br/><br />
	<a href="unesi_igrace_koji_konkurisu.php" class="dugme"> Promijeni spisak igrača </a>
	<a href="dodaj_zvanicni_sastav.php?id=$id" class="dugme"> Dodaj zvanični sastav </a>
	<a href="dodaj_link.php?id=$id" class="dugme"> Dodaj link </a>
	<a href="izbrisi_link.php?id=$id" class="dugme"> Izbriši link </a></center><br />
	</center><br />
	<br /> <br />
_END;
	}
	else if($status==2)  // TRENUTNO STOJI SLUZBENI SASTAV
	{
		echo<<<_END
		<br /> <br/>
	<center><label class="labela"> Naredna utakmica (postavljen je zvanični sastav):<br />
	$domacin_ime vs $gost_ime </label> <br/><br />
	<a href="dodaj_link.php?id=$id" class="dugme"> Dodaj link </a>
	<a href="izbrisi_link.php?id=$id" class="dugme"> Izbriši link </a>
	<a href="pocni_utakmicu.php?id=$id" class="dugme"> Počni utakmicu </a></center><br />
	<br /> <br />
_END;
	}
	else if($status==3)  // UTAKMICA U TOKU
	{
	echo<<<_END
		<br /> <br/>
	<center><label class="labela"> Utakmica u toku (trenutni rezultat):<br />
	$domacin_ime $domacin_rez:$gost_rezultat $gost_ime </label> <br/><br />
	<a href=
_END;

	if (strtoupper($domacin_ime)=="BARCELONA" || strtoupper($domacin_ime)=="BARCA" || strtoupper($domacin_ime)=="FC BARCELONA")
		echo "'dodaj_gol.php?id=$id&barca_domacin=1'";
	else echo "'dodaj_gol.php?id=$id&barca_domacin=0'";
	
	echo<<<_END
	class="dugme"> Postignut gol </a>
	<a href=
_END;
	if (strtoupper($domacin_ime)=="BARCELONA" || strtoupper($domacin_ime)=="BARCA" || strtoupper($domacin_ime)=="FC BARCELONA")
		echo "'primi_gol.php?id=$id&barca_domacin=1'";
	else echo "'primi_gol.php?id=$id&barca_domacin=0'";
	
	echo<<<_END
	class="dugme"> Primljen gol </a>
	<a href="napravi_izmjenu.php?id=$id" class="dugme"> Napravi izmjenu </a>
	<a href="zavrsi_utakmicu.php?id=$id" class="dugme"> Završi utakmicu </a><br> <br>
	<a href="dodaj_link.php?id=$id" class="dugme"> Dodaj link </a>
	<a href="izbrisi_link.php?id=$id" class="dugme"> Izbriši link </a>
	</center><br />
	<br /> <br />
_END;
	}
	else if($status==4)  // UTAKMICA ZAVRSENA, GLASANJE ZA IGRACA UTAKMICE
	{
		
		
		echo<<<_END
	<br /> <br/>
	<center><label class="labela"> Završena utakmica:<br />
	$domacin_ime $domacin_rez:$gost_rezultat $gost_ime </label> <br/><br />
	<a href="dodaj_utakmicu.php?zavrsi_id=$id" class="dugme"> Dodaj novu utakmicu </a></center><br />
	<br /> <br />
_END;
	}
	else
	{
		echo<<<_END
		<br /> <br/>
		<center><label class="labela"> Nepoznat status utakmice! Obrati se Nadinu :)</label> <br/><br />
		<a href="../index.php" class="dugme"> Match center </a></center><br />
		<br /> <br />
_END;
	}
}
else
{
	echo<<<_END
	<br /> <br/>
	<center><label class="labela"> Više utakmica je aktivno! Obrati se Nadinu :)</label> <br/><br />
	<a href="../index.php" class="dugme"> Match center </a></center><br />
	<br /> <br />
_END;
}
?>
</div>
</body>
</html>