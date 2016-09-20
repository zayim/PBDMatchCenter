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

if (isset($_GET['id']) && $_GET['id']!="") // TREBAMO ZAPOČETI UTAKMICU
{
	mysql_query("UPDATE utakmice SET status=3, domacin_rezultat=0, gost_rezultat=0 WHERE id=$id");
	mysql_query("CREATE TABLE domacin_$id(
						id INT AUTO_INCREMENT,
						min INT NOT NULL,
						strijelac VARCHAR(50) NOT NULL,
						asistent VARCHAR(50),
						PRIMARY KEY(id)
						) ENGINE=InnoDB");
						
	mysql_query("CREATE TABLE gost_$id(
						id INT AUTO_INCREMENT,
						min INT NOT NULL,
						strijelac VARCHAR(50) NOT NULL,
						asistent VARCHAR(50),
						PRIMARY KEY(id)
						) ENGINE=InnoDB");
						
	$rez=mysql_query("DESCRIBE domacin_$id"); if ($rez==false)
	{ 
		mysql_query("UPDATE utakmice SET status=2, domacin_rezultat=NULL, gost_rezultat=NULL WHERE id=$id");
		header("Location: greska.php");
		die();
	}
	$rez=mysql_query("DESCRIBE gost_$id"); if ($rez==false)
	{
		mysql_query("UPDATE utakmice SET status=2, domacin_rezultat=NULL, gost_rezultat=NULL WHERE id=$id");
		mysql_query("DROP TABLE domacin_$id");
		header("Location: greska.php");
		die();
	}
	header("Location: admin.php"); die();
}
else
{
	header("Location: greska.php"); die();
}

?>

</body>
</html>