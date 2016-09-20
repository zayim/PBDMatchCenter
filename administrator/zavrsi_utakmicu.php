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

if (isset($_GET['id']) && $_GET['id']!="") // TREBAMO ZAVRŠITI UTAKMICU
{
	izbrisiPodatke();
	mysql_query("UPDATE utakmice SET status=4 WHERE id=$id");
	header("Location: admin.php"); die();
}
else
{
	header("Location: greska.php"); die();
}

?>

</body>
</html>