<?php
session_start();
$poruka="Greška! Nemate pristup ovom dijelu!";

if (isset($_GET['tip']))
{
	$tip=$_GET['tip'];
	if ($tip=='badlogin') $poruka="Loša kombinacija username/password!";
	elseif ($tip=='multiple') $poruka="Više od jedne utakmice aktivno! Obrati se Nadinu :)";
	elseif ($tip=='homeawayerr') $poruka="Greška! Niste unijeli domaćina ili gosta!";
	elseif ($tip=='nominute') $poruka="Greška! Niste unijeli minutu!";
	elseif ($tip=='noscorer') $poruka="Greška! Niste unijeli strijelca!";
}

echo<<<_END
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Greška! </title>
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
	margin-top:50px;
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
.dugme
{
	background:#333;
	font-family:PenyaFont;
	font-size:16px;
	color:#CCC;
	border:#CCC 1px solid;
	outline:none;
	padding:5px;
	margin-top:10px;
}
.dugme:hover, .dugme:focus
{
	background:#06F;
	outline:none;
	color:#CCC;
}
.labela
{
	font-family:PenyaFont;
	font-size:18px;
	color:#CCC;
}
</style>
</head>
<body>
<div id="omotac">
<center><br><label class="labela">$poruka</label><br><br><a href="index.php" class="dugme">Povratak</a><br><br></center>
</div>
</body>
</html>
_END;

?>