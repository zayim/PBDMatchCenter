<?php

/*$veza=mysql_connect("localhost","root");

if (!$veza) { header("Location: greska.php"); die(); }
$imeBaze="bhxcom_pbd";
$imaLiBaza=mysql_select_db("$imeBaze",$veza);
if (!$imaLiBaza)
{
	echo "Greska! Nema baze.";
	die();
}*/

/// random queryy
/*$upit="select * from sastav_11";
$rez=mysql_query($upit);
if ($rez==false) die("Greska");

$broj_redova=mysql_num_rows($rez);
for ($i=0; $i<$broj_redova; $i++)
{
	$red=mysql_fetch_assoc($rez);
	echo "ID: ".$red['id']." ime: ".$red['ime']." ".$red['broj_na_dresu']."    ".$red['da_li_igra']."<br>";
}
echo "<br>Kraj<br><br>";*/

///IZMJENA UTAKMICE
/*$upit="UPDATE utakmice SET opis='Nedjelja, 26. 5. | 20:00 @ Cornella-El Prat' WHERE id=8";
$rez=mysql_query($upit);
if ($rez==false) die("Greska");
echo "<br>Kraj<br><br>";*/

///IZLISTAVANJE UTAKMICA

/*$upit="SELECT * FROM utakmice";
$rez=mysql_query($upit);
if ($rez==false) die("Greska");

$broj_redova=mysql_num_rows($rez);
for ($i=0; $i<$broj_redova; $i++)
{
	$red=mysql_fetch_assoc($rez);
	echo "ID: ".$red['id']." DOMACIN: ".$red['domacin']." GOST: ".$red['gost'];
	echo " OPIS: ".$red['opis']."<br>";
}
echo "<br>Kraj<br><br>";*/

//// IZLISTAVANJE IGRACA
/*$upit="SELECT * FROM igraci ORDER BY broj_glasova DESC";
$rez=mysql_query($upit);
if ($rez==false) die("Greska");

$broj_redova=mysql_num_rows($rez);
for ($i=0; $i<$broj_redova; $i++)
{
	$red=mysql_fetch_assoc($rez);
	echo "ID: ".$red['id']." IME: ".$red['broj_na_dresu']." ".$red['ime'];
	echo " BROJ GLASOVA: ".$red['broj_glasova']."<br>";
}
echo "<br>Kraj<br><br>";*/

/// IZLISTAVANJE POZICIJE
/*$pozicija="DMF";
$upit="SELECT * FROM $pozicija";
$rez=mysql_query($upit);
if ($rez==false) die("Greska");

echo "POZICIJA: $pozicija<br><br>";

$broj_redova=mysql_num_rows($rez);
for ($i=0; $i<$broj_redova; $i++)
{
	$red=mysql_fetch_assoc($rez);
	echo "ID: ".$red['id']." ID IGRACA: ".$red['id_igraca'];
	echo " BROJ GLASOVA: ".$red['broj_glasova']."<br>";
}
echo "<br>Kraj<br><br>";*/


///DODAVANJE IGRACA
/*$upit="INSERT INTO igraci(ime,broj_na_dresu) VALUES ('Sergi Roberto',28)";
$rez=mysql_query($upit);
if ($rez==false) die("Greska");*/
// DODAVANJE IGRACA NA POZICIJU
/*$pozicija="LMF";
$upit="INSERT INTO $pozicija(id_igraca) VALUES (107)";
$rez=mysql_query($upit);
if ($rez==false) die("Greska");
else echo "Uspjeh";*/

/////BRISANJE IGRACA
/*$id_igraca=104;
$tabela="igraci";

$upit="DELETE FROM $tabela WHERE id=$id_igraca";
$rez=mysql_query($upit);
if ($rez==false) die("Greska");
else die("Uspjeh");*/

/*mysql_query("DELETE FROM utakmice");
mysql_query("DROP TABLE utakmice");


$i1=1;
mysql_query("DELETE FROM sastav_$i1");
mysql_query("DROP TABLE sastav_$i1");
mysql_query("DELETE FROM domacin_$i1");
mysql_query("DROP TABLE domacin_$i1");
mysql_query("DELETE FROM gost_$i1");
mysql_query("DROP TABLE gost_$i1");

$i2=2;
mysql_query("DELETE FROM sastav_$i2");
mysql_query("DROP TABLE sastav_$i2");
mysql_query("DELETE FROM domacin_$i2");
mysql_query("DROP TABLE domacin_$i2");
mysql_query("DELETE FROM gost_$i2");
mysql_query("DROP TABLE gost_$i2");

$i3=3;
mysql_query("DELETE FROM sastav_$i3");
mysql_query("DROP TABLE sastav_$i3");
mysql_query("DELETE FROM domacin_$i3");
mysql_query("DROP TABLE domacin_$i3");
mysql_query("DELETE FROM gost_$i3");
mysql_query("DROP TABLE gost_$i3");

$i4=6;
mysql_query("DELETE FROM sastav_$i4");
mysql_query("DROP TABLE sastav_$i4");
mysql_query("DELETE FROM domacin_$i4");
mysql_query("DROP TABLE domacin_$i4");
mysql_query("DELETE FROM gost_$i4");
mysql_query("DROP TABLE gost_$i4");*/


?>