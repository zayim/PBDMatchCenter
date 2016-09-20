<?php
$veza=mysql_connect("localhost","root");

if (!$veza) { header("Location: greska.php"); die(); }
$imeBaze="pbd_match_center";
$imaLiBaza=mysql_select_db("$imeBaze",$veza);
if (!$imaLiBaza)
{
	mysql_query("CREATE DATABASE $imeBaze");
	$imaLiBaza=mysql_select_db("$imeBaze",$veza);
}

//admini

$tabela=mysql_query("DESCRIBE admini");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE admini(
								id INT AUTO_INCREMENT,
								username VARCHAR(20) NOT NULL,
								password VARCHAR(50) NOT NULL,
								head INT DEFAULT 0,
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
	mysql_query("INSERT INTO admini(username,password,head) VALUES('admin','28005273f2b7a59b085a7788586fbc37',1)");
}

// utakmice

$tabela=mysql_query("DESCRIBE utakmice");

if (!$tabela)
{
	$rez=mysql_query("CREATE TABLE utakmice(
								id INT AUTO_INCREMENT,
								opis VARCHAR(50),
								domacin VARCHAR(50) NOT NULL,
								gost VARCHAR(50) NOT NULL,
								domacin_rezultat INT,
								gost_rezultat INT,
								takmicenje INT NOT NULL,
								status INT NOT NULL,
								PRIMARY KEY(id)) ENGINE=InnoDB");
	if (!$rez) { header("Location: greska.php"); die(); }
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

function destroy_session_and_data()
{
	$_SESSION = array();
	if (session_id() != "" || isset($_COOKIE[session_name()]))
	setcookie(session_name(), '', time() - 2592000, '/');
	session_destroy();
}

function izbrisiPodatke()
{
	mysql_query("DELETE FROM GK"); mysql_query("DELETE FROM RB"); mysql_query("DELETE FROM CB");
	mysql_query("DELETE FROM LB"); mysql_query("DELETE FROM RMF"); mysql_query("DELETE FROM DMF");
	mysql_query("DELETE FROM LMF"); mysql_query("DELETE FROM RWF"); mysql_query("DELETE FROM CF");
	mysql_query("DELETE FROM LWF"); mysql_query("DELETE FROM igraci");
}

?>