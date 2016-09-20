<?php
$veza=mysql_connect("Localhost","bhxcom_nadin","Zayimovic2013");

if (!$veza) { header("Location: greska.php"); die(); }
$imeBaze="bhxcom_pbd";
$imaLiBaza=mysql_select_db("$imeBaze",$veza);
if (!$imaLiBaza)
{
	mysql_query("CREATE DATABASE $imeBaze");
	$imaLiBaza=mysql_select_db("$imeBaze",$veza);
}

// igraci
$tabela=mysql_query("DESCRIBE igraci");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE igraci(
								id INT AUTO_INCREMENT UNIQUE,
								ime VARCHAR(20) NOT NULL,
								broj_glasova INT DEFAULT 0,
								broj_na_dresu INT UNIQUE,
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
}

// GK
$tabela=mysql_query("DESCRIBE GK");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE GK(
								id INT AUTO_INCREMENT UNIQUE,
								id_igraca INT,
								broj_glasova INT DEFAULT 0,
								FOREIGN KEY(id_igraca) REFERENCES igraci(id),
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
}

// RB

$tabela=mysql_query("DESCRIBE RB");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE RB(
								id INT AUTO_INCREMENT UNIQUE,
								id_igraca INT,
								broj_glasova INT DEFAULT 0,
								FOREIGN KEY(id_igraca) REFERENCES igraci(id),
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
}

// CB

$tabela=mysql_query("DESCRIBE CB");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE CB(
								id INT AUTO_INCREMENT UNIQUE,
								id_igraca INT,
								broj_glasova INT DEFAULT 0,
								FOREIGN KEY(id_igraca) REFERENCES igraci(id),
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
}

// LB

$tabela=mysql_query("DESCRIBE LB");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE LB(
								id INT AUTO_INCREMENT UNIQUE,
								id_igraca INT,
								broj_glasova INT DEFAULT 0,
								FOREIGN KEY(id_igraca) REFERENCES igraci(id),
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
}

// DMF

$tabela=mysql_query("DESCRIBE DMF");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE DMF(
								id INT AUTO_INCREMENT UNIQUE,
								id_igraca INT,
								broj_glasova INT DEFAULT 0,
								FOREIGN KEY(id_igraca) REFERENCES igraci(id),
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
}
	
// LMF

$tabela=mysql_query("DESCRIBE LMF");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE LMF(
								id INT AUTO_INCREMENT UNIQUE,
								id_igraca INT,
								broj_glasova INT DEFAULT 0,
								FOREIGN KEY(id_igraca) REFERENCES igraci(id),
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
}

// RMF

$tabela=mysql_query("DESCRIBE RMF");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE RMF(
								id INT AUTO_INCREMENT UNIQUE,
								id_igraca INT,
								broj_glasova INT DEFAULT 0,
								FOREIGN KEY(id_igraca) REFERENCES igraci(id),
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
}

// RWF

$tabela=mysql_query("DESCRIBE RWF");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE RWF(
								id INT AUTO_INCREMENT UNIQUE,
								id_igraca INT,
								broj_glasova INT DEFAULT 0,
								FOREIGN KEY(id_igraca) REFERENCES igraci(id),
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
}

// LWF

$tabela=mysql_query("DESCRIBE LWF");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE LWF(
								id INT AUTO_INCREMENT UNIQUE,
								id_igraca INT,
								broj_glasova INT DEFAULT 0,
								FOREIGN KEY(id_igraca) REFERENCES igraci(id),
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
}

// CF

$tabela=mysql_query("DESCRIBE CF");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE CF(
								id INT AUTO_INCREMENT UNIQUE,
								id_igraca INT,
								broj_glasova INT DEFAULT 0,
								FOREIGN KEY(id_igraca) REFERENCES igraci(id),
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
}



function popraviString($var)
{
	$var = mysql_real_escape_string($var);
	if (get_magic_quotes_gpc()) $var = stripslashes($var);
	$var = htmlentities($var);
	$var = strip_tags($var);
	return $var;
}
?>