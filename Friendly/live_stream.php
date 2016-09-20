<?php

require_once("konekcija.php");

$upit="SELECT * FROM utakmice WHERE status !=0";
$rez=mysql_query($upit);

if ($rez==false || mysql_num_rows($rez)!=1) { header("Location: greska.php"); die(); }
 
 /// OBRADA UTAKMICE
$utakmica=mysql_fetch_assoc($rez);
$id=$utakmica['id'];
$domacin=$utakmica['domacin']; $gost=$utakmica['gost'];
$rezultat_domacin=$utakmica['domacin_rezultat']; $rezultat_gost=$utakmica['gost_rezultat'];
$opis=$utakmica['opis'];

$upit="SELECT * FROM linkovi_$id";
$rez=mysql_query($upit);
if ($rez==false || mysql_num_rows($rez)==0) die("<center><div class='ls_warning'> Nema linkova!</div></center>");
$broj_linkova=mysql_num_rows($rez);

echo "<center>";

for ($i=0; $i<$broj_linkova; $i++)
{
	$red=mysql_fetch_assoc($rez);
	$link=$red['link'];
	$tmp=$i+1;
	$onclk = <<<_END
	 document.getElementById('ls_placeholder').innerHTML='$link'
_END;
	if (substr($link,4,6)!="iframe") $onclk="window.location.href='$link'";
	echo<<<_END
<input type="button" value="Link $tmp" onclick="$onclk" class="ls_dugme">
_END;
}

echo "</center>";
echo "<center><div id='ls_placeholder' style='margin:5px'></div></center>";

?>