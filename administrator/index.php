<?php session_start(); if (isset($_SESSION['pbd_mc_un'])) { header("Location: admin.php"); die(); } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Match Center | Admin</title>
<script type="text/javascript" src="ajax_zahtjev.js"> </script>
<script type="text/javascript" src="skripta.js"> </script>
<style type="text/css">
@font-face
{
	font-family:PenyaFont;
	src: url(segoeui.ttf);
}
body
{
	background:#222;
}
#omotac
{
	background:#666;
	border:#999 1px solid;
	width:400px;
	margin:auto;
	margin-top:10px;
}
.polje, .dugme
{
	background:#333;
	color:#09F;
	font-family:PenyaFont;
	font-size:18px;
	border:#CCC 1px solid;
	outline:none;
	padding:5px;
}
.dugme
{
	font-size:16px;
	color:#CCC;
}
.dugme:hover
{
	cursor:pointer;
}
.dugme:hover, .dugme:focus
{
	background:#06F;
	color:#FFF;
}
.polje:hover, .polje:focus, .dugme:hover, .dugme:focus
{
	outline:none;
}
.polje:focus
{
	border:#06F 1px solid !important;
}
.labela
{
	font-family:PenyaFont;
	font-size:18px;
	color:#CCC;
}
a, a:visited
{
	color:#999;
	text-decoration:none;
}
a:hover
{
	color:#06F;
	text-decoration:none;
}
a:focus, a:active
{
	color:#999;
	text-decoration:none;
}
</style>
</head>

<body>
<?php
require_once("konekcija.php");
?>

<div style="margin-top:50px">
<center>
<span style="color:#999; font-family:PenyaFont; font-size:18px"> Loguj se |
<a href="http://www.barcabih.com"> Barca BiH </a> </span>
</center>
</div>

<div id="omotac">
<br />
<br />
<form action="admin.php" method="post">
<center>
<table>
<tr>
<td> <label class="labela"> Username </label> </td>
<td> <input type="text" id="username"  name="username" class="polje"/> </td>
</tr>
<tr>
<td> <label class="labela"> Password </label> </td>
<td> <input type="password" id="password"  name="password" class="polje"/> </td>
</tr>
</table>
<input type="submit" value="Loguj se" class="dugme"/>
</center>
</form>
<br />
</div>
</body>
</html>