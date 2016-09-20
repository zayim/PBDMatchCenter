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

$tabela=mysql_query("DESCRIBE utakmice");

if (!$tabela) { header("Location: greska.php"); die(); }
?>