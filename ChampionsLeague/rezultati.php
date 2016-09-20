<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Match Center | Barca BiH</title>
<link rel="shortcut icon" href="slike/pbd.ico" />
<link rel="stylesheet" type="text/css" href="stilovi/main.css" />
<script type="text/javascript" src="skripte/skripta.js"> </script>
</head>

<?php
require_once("konekcija.php");

$poz=Array("GK","RB","CB","LB","RMF","DMF","LMF","RWF","CF","LWF");
$poz_glasovi=Array("GK"=>0, "RB"=>0, "CB"=>0, "LB"=>0, "RMF"=>0, "DMF"=>0, "LMF"=>0, "RWF"=>0, "CF"=>0, "LWF"=>0);
$registrovani_broj=Array("GK"=>0, "RB"=>0, "CBR"=>0, "CBL"=>0, "LB"=>0, "RMF"=>0, "DMF"=>0, "LMF"=>0, "RWF"=>0, "CF"=>0, "LWF"=>0);
$registrovani_ime=Array("GK"=>"", "RB"=>"", "CBR"=>"", "CBL"=>"", "LB"=>"", "RMF"=>"", "DMF"=>"", "LMF"=>"", "RWF"=>"", "CF"=>"", "LWF"=>"");

$imena=Array(); $glasovi=Array(); $idovi=Array(); $brojevi=Array();

$upit="SELECT ime,broj_glasova,id,broj_na_dresu FROM igraci ORDER BY broj_glasova DESC";
$rez=mysql_query($upit);
if ($rez==false) { header("Location: greska.php"); die(); }
$broj_igraca=mysql_num_rows($rez);

for ($i=0; $i<$broj_igraca; $i++)
{
	$red=mysql_fetch_array($rez);
	$imena[]=$red[0]; $glasovi[]=$red[1]; $idovi[]=$red[2]; $brojevi[]=$red[3];
}

$broj_registrovanih=0;
$i=0;

while ($broj_registrovanih!=11 && $i<$broj_igraca)
{
	// naci dvije najbolje pozicije
	$max_brg=0; $max_poz="";
	foreach ($poz_glasovi as $__poz => $__brg)
	{
    	$__upit="SELECT * FROM $__poz WHERE id_igraca=".$idovi[$i];
		$__rez=mysql_query($__upit);
		$__red=mysql_fetch_assoc($__rez);
		
		$poz_glasovi[$__poz]=$__red['broj_glasova'];
		//if ($__brg>$max_brg) { $max_brg=$__brg; $max_poz=$__poz; }
	}
	
	$max_brg=-1; $max_poz="";
	foreach ($poz_glasovi as $__poz => $__brg)
			if ($__brg>$max_brg) { $max_brg=$__brg; $max_poz=$__poz; }
	
	$max_dovoljna=false;
	
	if ($max_poz=="CB")
	{
		if ($registrovani_broj["CBR"]==0) { $registrovani_ime["CBR"]=$imena[$i]; $registrovani_broj["CBR"]=$brojevi[$i]; $max_dovoljna=true; }
		elseif($registrovani_broj["CBL"]==0) { $registrovani_ime["CBL"]=$imena[$i]; $registrovani_broj["CBL"]=$brojevi[$i]; $max_dovoljna=true; }
	}
	elseif ($registrovani_broj[$max_poz]==0)
	{
		$registrovani_ime[$max_poz]=$imena[$i];
		$registrovani_broj[$max_poz]=$brojevi[$i];
		$max_dovoljna=true;
	}
	
	if (!$max_dovoljna)
	{
		$max_brg1=-1; $max_poz1="";
		foreach ($poz_glasovi as $__poz => $__brg)
			if ($__poz!=$max_poz && $__brg>$max_brg1) { $max_brg1=$__brg; $max_poz1=$__poz; }
			
		if ($max_poz1!="")
		{	
			if ($max_poz1=="CB")
			{
				if ($registrovani_broj["CBR"]==0) { $registrovani_ime["CBR"]=$imena[$i]; $registrovani_broj["CBR"]=$brojevi[$i]; $broj_registrovanih++; }
				elseif($registrovani_broj["CBL"]==0) { $registrovani_ime["CBL"]=$imena[$i]; $registrovani_broj["CBL"]=$brojevi[$i]; $broj_registrovanih++; }
			}
			elseif ($registrovani_broj[$max_poz1]==0)
			{
				$registrovani_ime[$max_poz1]=$imena[$i];
				$registrovani_broj[$max_poz1]=$brojevi[$i];
				$broj_registrovanih++;
			}
		}
	}
	else $broj_registrovanih++;
		
	$i++;
}

$gk_ime=$registrovani_ime["GK"]; $gk_broj=$registrovani_broj["GK"];
$rb_ime=$registrovani_ime["RB"]; $rb_broj=$registrovani_broj["RB"];
$cbr_ime=$registrovani_ime["CBR"]; $cbr_broj=$registrovani_broj["CBR"];
$cbl_ime=$registrovani_ime["CBL"]; $cbl_broj=$registrovani_broj["CBL"];
$lb_ime=$registrovani_ime["LB"]; $lb_broj=$registrovani_broj["LB"];
$rmf_ime=$registrovani_ime["RMF"]; $rmf_broj=$registrovani_broj["RMF"];
$dmf_ime=$registrovani_ime["DMF"]; $dmf_broj=$registrovani_broj["DMF"];
$lmf_ime=$registrovani_ime["LMF"]; $lmf_broj=$registrovani_broj["LMF"];
$rwf_ime=$registrovani_ime["RWF"]; $rwf_broj=$registrovani_broj["RWF"];
$cf_ime=$registrovani_ime["CF"]; $cf_broj=$registrovani_broj["CF"];
$lwf_ime=$registrovani_ime["LWF"]; $lwf_broj=$registrovani_broj["LWF"];

?>

<body>
<?php
require_once("konekcija.php");

$upit="SELECT * FROM utakmice WHERE status !=0";
$rez=mysql_query($upit);

if ($rez==false || mysql_num_rows($rez)!=1) { header("Location: greska.php"); die(); }
$utakmica=mysql_fetch_assoc($rez);
$id=$utakmica['id'];
$domacin=$utakmica['domacin']; $gost=$utakmica['gost'];
$opis=$utakmica['opis'];

?>
<center>
<div style="font-family:SegoeBold; font-size:36px; color:#FFF; margin-top:10px">
<?php echo "$domacin - $gost"; ?>
<br />
<span style="font-family:Segoe; font-size:22px; color:#FFF;"> <?php echo $opis; ?></span>
 
</div>
</center>
<center>
<span class="powered_by">
Powered by: <a href="http://www.barcabih.com" style="cursor:url(../slike/cursor.png), pointer;"> Bar&#231;a BiH</a> | Rezultati ankete
</span>
</center>

<center><table><tr>

<td> <div id="stats_lijevo">
<center><span style="padding:5px; background:#000; opacity:0.8; text-align:center"> TOP 10 </span></center>
<br />
<table width="100%">
<tr>
</tr>
<?php
	$rez=mysql_query("SELECT * FROM igraci ORDER BY broj_glasova DESC LIMIT 10"); if($rez==false) { header("Location: greska.php"); die(); }
	$broj_igraca=mysql_num_rows($rez);
	$rez2=mysql_query("SELECT SUM(broj_glasova) AS 'zbir' FROM igraci"); if($rez2==false) { header("Location: greska.php"); die(); }
	$red2=mysql_fetch_assoc($rez2);
	$broj_glasova=($red2['zbir']+591)/11;
	
	for ($i=0; $i<$broj_igraca; $i++)
	{
		echo "<tr>";
		$red=mysql_fetch_assoc($rez);
		if ($broj_glasova!=0) $postotak=round(($red['broj_glasova']*100)/$broj_glasova,2); else $postotak=0;
		echo "<td style='padding:5px; text-align:left; background:#000; opacity:0.8; width:10%'> ".($i+1).". </td>";
		echo "<td style='padding:5px; text-align:left; background:#000; opacity:0.8; width:40%'> ".$red['ime']." </td>";
		echo "<td style='padding:5px; text-align:left; background:#000; opacity:0.8; width:50%'> ".$red['broj_glasova']." ($postotak%)</td>";
		echo "</tr>";
	}
?></table>
</div></td>

<td>
<center><div id="teren">
<div style="height:100px"></div>
<center>
<table> 
    <tr align="center"> <!--napad-->
    	<td align="center"> <!--lijevo krilo-->
        <table>
        <tr align="center">
            	<td align="center">
                <div id="lwf_broj" class="broj"> <?php echo "$lwf_broj"; ?> </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                 	<label id="lwf_ime"><?php echo "$lwf_ime"; ?></label>
                </div>
                </td>
            </tr>
        </table>
        </td>
        <td align="center"> <!--centarfor-->
        	<table>
        	<tr align="center">
            	<td align="center">
                <div id="cf_broj" class="broj"> <?php echo "$cf_broj"; ?> </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="cf_ime"><?php echo "$cf_ime"; ?></label>  
                    </ul> 
                </div>
                </td>
            </tr>
            </table>
        </td>
        <td align="center"> <!--desno krilo-->
        	<table>
            <tr align="center">
            	<td align="center">
                <div id="rwf_broj" class="broj"> <?php echo "$rwf_broj"; ?> </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="rwf_ime"><?php echo "$rwf_ime"; ?></label>
                </div>
                </td>
            </tr>
            </table>
        </td>
        
    </tr> <!--kraj napada-->

</table>
</center>
<center>
<table> 
    <tr align="center"> <!--vezni red-->
    	
        <td align="center"> <!--lijevi vezni-->
        <table>
        <tr align="center">
            	<td align="center">
                <div id="lmf_broj" class="broj"> <?php echo "$lmf_broj"; ?> </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                 	<label id="lmf_ime"><?php echo "$lmf_ime"; ?></label>
                </div>
                </td>
            </tr>
        </table>
        </td>
        <td align="center"> <!--defanzivni vezni-->
        	<table>
        	<tr align="center">
            	<td align="center">
                <div id="dmf_broj" class="broj"> <?php echo "$dmf_broj"; ?> </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="dmf_ime"><?php echo "$dmf_ime"; ?></label>
                </div>
                </td>
            </tr>
            </table>
        </td>
        <td align="center"> <!--desni vezni-->
        	<table>
            <tr align="center">
            	<td align="center">
                <div id="rmf_broj" class="broj"> <?php echo "$rmf_broj"; ?> </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="rmf_ime"><?php echo "$rmf_ime"; ?></label>
                </div>
                </td>
            </tr>
            </table>
        </td>
    </tr> <!--kraj veznog reda-->

</table>
</center>
<center>
<table> 
    <tr align="center"> <!--odbrana-->
    	<td align="center"> <!--lijevi bek-->
        <table>
        <tr align="center">
            	<td align="center">
                <div id="lb_broj" class="broj"> <?php echo "$lb_broj"; ?> </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="lb_ime"><?php echo "$lb_ime"; ?></label>
                </div>
                </td>
            </tr>
        </table>
        </td>
        <td align="center"> <!--lijevi stoper-->
        <table>
        <tr align="center">
            	<td align="center">
                <div id="cbl_broj" class="broj"> <?php echo "$cbl_broj"; ?> </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                 	<label id="cbl_ime"><?php echo "$cbl_ime"; ?></label> 
                </div>
                </td>
            </tr>
        </table>
        </td>
        <td align="center"> <!--desni stoper-->
        	<table>
        	<tr align="center">
            	<td align="center">
                <div id="cbr_broj" class="broj"> <?php echo "$cbr_broj"; ?> </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="cbr_ime"><?php echo "$cbr_ime"; ?></label> 
                </div>
                </td>
            </tr>
            </table>
        </td>
        <td align="center"> <!--desni bek-->
        	<table>
            <tr align="center">
            	<td align="center">
                <div id="rb_broj" class="broj"> <?php echo "$rb_broj"; ?> </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="rb_ime"><?php echo "$rb_ime"; ?></label>
                </div>
                </td>
            </tr>
            </table>
        </td>
    </tr> <!--kraj odbrane-->

</table>
</center>
<center>
<table align="center">

	<tr align="center"> <!--golman-->
		<td align="center"> 
        	<table>
			<tr align="center">
            	<td align="center">
                <div id="golman_broj" class="broj_golman"> <?php echo "$gk_broj"; ?> </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
               		<label id="golman_ime"><?php echo "$gk_ime"; ?></label>
                </div>
                </td>
            </table>
            </tr>
		</td>
	</tr> <!--kraj golmana-->
</table></center>

</div></center>


</td>

<td> <div id="stats_desno" style="padding:5px; background:#000; opacity:0.8;"> Broj glasova: <?php echo round($broj_glasova); ?> </div></td>

</tr></table></center>
<center>
<input type="button" class="dugme" value="Početna" onclick="window.location.href='index.php'" />
</center>

</body>
</html>