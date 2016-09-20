<?php

require_once("konekcija.php");

$upit="SELECT * FROM utakmice WHERE status !=0";
$rez=mysql_query($upit);
 
$utakmica=mysql_fetch_assoc($rez);
$domacin=$utakmica['domacin']; $gost=$utakmica['gost'];
$rezultat_domacin=$utakmica['domacin_rezultat']; $rezultat_gost=$utakmica['gost_rezultat'];

$naslov="";
$domacin_niz=str_split($domacin);
$i=0; $br=0;
while ($br<3)
{
	if ($domacin_niz[$i]!=' ') { $naslov=$naslov.$domacin_niz[$i]; $br++; }
	$i++;
}
$naslov=$naslov." $rezultat_domacin:$rezultat_gost ";
$gost_niz=str_split($gost);
$i=0; $br=0;
while ($br<3)
{
	if ($gost_niz[$i]!=' ') { $naslov=$naslov.$gost_niz[$i]; $br++; }
	$i++;
}

$naslov=strtoupper($naslov)." | Barca BiH";

echo $naslov;

?>