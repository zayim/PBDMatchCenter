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
		$takm=$utakmica['takmicenje'];
		$broj_igraca_na_klupi=7;
		if ($takm==6) $broj_igraca_na_klupi=11;
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

if (isset($_POST["igrac_id_0"])) // AKO DOBIJEMO PODATKE NA FORMU
{
	$imaGreska=false; $poruka="";
	$zvanicni_sastav=array();
	for ($i=0; $i<=10+$broj_igraca_na_klupi; $i++)
	{
		if (!isset($_POST["igrac_id_$i"])) { $imaGreska=true; break; }
		else $zvanicni_sastav[]=$_POST["igrac_id_$i"];
	}
	
	$jedinstveno=true;
	for ($i=0; $i<11+$broj_igraca_na_klupi; $i++)
		for ($j=$i+1; $j<11+$broj_igraca_na_klupi; $j++)
			if ($zvanicni_sastav[$i]==$zvanicni_sastav[$j])
			{
				$jedinstveno=false;
				break;
			}
	if (!$jedinstveno) $imaGreska=true;
	
	
	$rez=mysql_query("SELECT id FROM utakmice WHERE status!=0");
	if ($rez)
	{
		if (mysql_num_rows($rez)>1) $imaGreska=true;
		elseif (mysql_num_rows($rez)==1)
		{
			$utakmica=mysql_fetch_assoc($rez);
			$id_utakmice=$utakmica['id'];
		}
	}
	else $imaGreska=true;
	
	$upit="CREATE TABLE sastav_$id_utakmice(
							id INT AUTO_INCREMENT,
							ime VARCHAR(50) NOT NULL,
							broj_na_dresu INT NOT NULL,
							da_li_igra INT NOT NULL,
							glasovi_igrac_utakmice INT DEFAULT 0,
							prosjecna_ocjena FLOAT DEFAULT 0,
							broj_ocjena INT DEFAULT 0,
							PRIMARY KEY(id)
							) ENGINE=InnoDB";
							
	mysql_query($upit); $rez=mysql_query("DESCRIBE sastav_$id_utakmice");
	if ($rez==false) { $imaGreska=true; $poruka=$poruka."<br>tabela"; }
	
	for ($i=0; $i<11; $i++)
	{
		$_id=$zvanicni_sastav[$i];
		$rez=mysql_query("SELECT * FROM igraci WHERE id=$_id");
		$red=mysql_fetch_assoc($rez);
		$_broj=$red['broj_na_dresu']; $_ime=$red['ime'];
		mysql_query("INSERT INTO sastav_$id_utakmice(ime,broj_na_dresu,da_li_igra) VALUES ('$_ime',$_broj,1)");
	}
	
	for ($i=11; $i<11+$broj_igraca_na_klupi; $i++)
	{
		$_id=$zvanicni_sastav[$i];
		$rez=mysql_query("SELECT * FROM igraci WHERE id=$_id");
		$red=mysql_fetch_assoc($rez);
		$_broj=$red['broj_na_dresu']; $_ime=$red['ime'];
		mysql_query("INSERT INTO sastav_$id_utakmice(ime,broj_na_dresu,da_li_igra) VALUES ('$_ime',$_broj,0)");
	}
	
	mysql_query("UPDATE utakmice SET status=2 WHERE id=$id_utakmice");
	
	$poruka=""; $link="dodaj_zvanicni_sastav.php";
	if ($imaGreska) // AKO JE BILA GRESKA, POBRISI SVE I ISPISI GRESKU, VRATI SE...
	{
		mysql_query("DROP TABLE sastav_$id_utakmice");
		$poruka="Greška!";
	}
	else { $poruka="Uspješno uneseno!"; $link="admin.php"; }
	
		echo<<<_END
		<div id="omotac">
		<br>
		<center>
			<br /> <br/>
			<center><label class="labela"> $poruka </label> <br/><br />
			<a href="$link" class="dugme"> Povratak </a></center><br />
			<br /> <br />
		</center>
		<br>
		</div>
_END;
		die();
}
else //TEK TREBAMO UNIJETI PODATKE
{
	echo<<<_END
	<div id="omotac" style="width:600px">
	<form action="dodaj_zvanicni_sastav.php" method="post">
	<br />
	<center>
	<table>
		<tr>
			<td class="zvanicni_sastav_pozicija_header"> Pozicija </td>
			<td class="zvanicni_sastav_ime_header"> Igrač </td>
		</tr>
_END;

	$imena_pozicija=array("Golman","Desni bek","Štoper","Štoper","Lijevi bek","Zadnji vezni","Desni vezni",
						  "Lijevi vezni","Desno krilo","Lijevo krilo","Centarfor");
	$pozicije=array("GK","RB","CB","CB","LB","DMF","RMF","LMF","RWF","LWF","CF");
	
	for ($i=0; $i<11; $i++)
	{
		echo "<tr>";
		$tmp=$imena_pozicija[$i]; $tmp_pos=$pozicije[$i];
		echo "<td class='zvanicni_sastav_pozicija'> $tmp </td>";
		
		echo "<td class='zvanicni_sastav_ime'>";
		echo <<<_END
		<select  class="zvanicni_sastav_dropdown_ime" onchange="document.getElementById('igrac_id_$i').value=this.options[this.selectedIndex].value">
_END;
		$rez=mysql_query("SELECT DISTINCT igraci.id, igraci.broj_na_dresu, igraci.ime FROM igraci JOIN $tmp_pos ON igraci.id=$tmp_pos.id_igraca");
		$broj_igraca_na_poz=mysql_num_rows($rez);
		
		$id_prvog=0;
		for ($j=0; $j<$broj_igraca_na_poz; $j++)
		{
			$red=mysql_fetch_assoc($rez); $tmp_id=$red['id']; $tmp_broj=$red['broj_na_dresu']; $tmp_ime=$red['ime'];
			echo "<option value=$tmp_id> (<strong>$tmp_broj</strong>) $tmp_ime </option>";
			if($j==0) $id_prvog=$tmp_id;
		}
		
		echo "</select>";

		echo"</td>";
		echo<<<_END
		<input type="hidden" name="igrac_id_$i" id="igrac_id_$i" value=$id_prvog>
_END;
		echo "</tr>";
	}


echo<<<_END
	</table>
	</center>
	<br>
	<center><span class="labela"> Klupa </span></center>
	
	<center>
	<table>
		<tr>
			<td class="zvanicni_sastav_ime_header"> Igrač </td>
		</tr>
_END;
	
	for ($i=11; $i<11+$broj_igraca_na_klupi; $i++)
	{
		echo "<tr>";
		
		echo "<td class='zvanicni_sastav_ime'>";
		echo <<<_END
		<select  class="zvanicni_sastav_dropdown_ime" onchange="document.getElementById('igrac_id_$i').value=this.options[this.selectedIndex].value">
_END;
		$rez=mysql_query("SELECT id, broj_na_dresu, ime FROM igraci");
		$broj_igraca_na_poz=mysql_num_rows($rez);
		
		$id_prvog=0;
		for ($j=0; $j<$broj_igraca_na_poz; $j++)
		{
			$red=mysql_fetch_assoc($rez); $tmp_id=$red['id']; $tmp_broj=$red['broj_na_dresu']; $tmp_ime=$red['ime'];
			echo "<option value='$tmp_id'> (<strong>$tmp_broj</strong>) $tmp_ime </option>";
			if ($j==0) $id_prvog=$tmp_id;
		}
		
		echo "</select>";

		echo"</td>";
		echo<<<_END
		<input type="hidden" name="igrac_id_$i" id="igrac_id_$i" value=$id_prvog>
_END;
		echo "</tr>";
		
	}
	echo <<<_END
	</table></center><br>
	<center><input type="submit" value="Dodaj" class="dugme"/>
	 <input type="button" value="Povratak" class="dugme" onclick="window.location.href='admin.php'"/>
	 </center>
	
	</form>
	<br />
	</div>
_END;
}

?>
</body>
</html>