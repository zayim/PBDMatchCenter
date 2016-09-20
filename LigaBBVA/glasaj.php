<?php
require_once("konekcija.php");
if (!isset($_POST['gk'])) die();
if (!isset($_POST['rb'])) die();
if (!isset($_POST['cbr'])) die();
if (!isset($_POST['cbl'])) die();
if (!isset($_POST['lb'])) die();
if (!isset($_POST['rmf'])) die();
if (!isset($_POST['dmf'])) die();
if (!isset($_POST['lmf'])) die();
if (!isset($_POST['rwf'])) die();
if (!isset($_POST['cf'])) die();
if (!isset($_POST['lwf'])) die();

$gk=$_POST['gk']; $rb=$_POST['rb']; $cbr=$_POST['cbr']; $cbl=$_POST['cbl']; $lb=$_POST['lb']; $rmf=$_POST['rmf'];
$dmf=$_POST['dmf']; $lmf=$_POST['lmf']; $rwf=$_POST['rwf']; $cf=$_POST['cf']; $lwf=$_POST['lwf'];

mysql_query("UPDATE GK SET broj_glasova=broj_glasova+1 WHERE id_igraca=$gk") or die();
mysql_query("UPDATE RB SET broj_glasova=broj_glasova+1 WHERE id_igraca=$rb") or die();
mysql_query("UPDATE CB SET broj_glasova=broj_glasova+1 WHERE id_igraca=$cbr") or die();
mysql_query("UPDATE CB SET broj_glasova=broj_glasova+1 WHERE id_igraca=$cbl") or die();
mysql_query("UPDATE LB SET broj_glasova=broj_glasova+1 WHERE id_igraca=$lb") or die();
mysql_query("UPDATE RMF SET broj_glasova=broj_glasova+1 WHERE id_igraca=$rmf") or die();
mysql_query("UPDATE DMF SET broj_glasova=broj_glasova+1 WHERE id_igraca=$dmf") or die();
mysql_query("UPDATE LMF SET broj_glasova=broj_glasova+1 WHERE id_igraca=$lmf") or die();
mysql_query("UPDATE RWF SET broj_glasova=broj_glasova+1 WHERE id_igraca=$rwf") or die();
mysql_query("UPDATE CF SET broj_glasova=broj_glasova+1 WHERE id_igraca=$cf") or die();
mysql_query("UPDATE LWF SET broj_glasova=broj_glasova+1 WHERE id_igraca=$lwf") or die();

mysql_query("UPDATE igraci SET broj_glasova=broj_glasova+1 WHERE id=$gk") or die();
mysql_query("UPDATE igraci SET broj_glasova=broj_glasova+1 WHERE id=$rb") or die();
mysql_query("UPDATE igraci SET broj_glasova=broj_glasova+1 WHERE id=$cbr") or die();
mysql_query("UPDATE igraci SET broj_glasova=broj_glasova+1 WHERE id=$cbl") or die();
mysql_query("UPDATE igraci SET broj_glasova=broj_glasova+1 WHERE id=$lb") or die();
mysql_query("UPDATE igraci SET broj_glasova=broj_glasova+1 WHERE id=$rmf") or die();
mysql_query("UPDATE igraci SET broj_glasova=broj_glasova+1 WHERE id=$dmf") or die();
mysql_query("UPDATE igraci SET broj_glasova=broj_glasova+1 WHERE id=$lmf") or die();
mysql_query("UPDATE igraci SET broj_glasova=broj_glasova+1 WHERE id=$rwf") or die();
mysql_query("UPDATE igraci SET broj_glasova=broj_glasova+1 WHERE id=$cf") or die();
mysql_query("UPDATE igraci SET broj_glasova=broj_glasova+1 WHERE id=$lwf") or die();

echo "success";

?>