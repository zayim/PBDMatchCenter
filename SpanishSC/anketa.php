<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Match Center | Barca BiH</title>
<link rel="shortcut icon" href="../ChampionsLeague/slike/pbd.ico" />
<link rel="stylesheet" type="text/css" href="stilovi/main.css" />
<script type="text/javascript" src="skripte/ajax_zahtjev.js"> </script>
<script type="text/javascript" src="skripte/skripta.js"> </script>
</head>

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
<div style="font-family:Trebuchet; font-size:36px; color:#FFF; margin-top:10px">
<?php echo "$domacin - $gost"; ?>
<br />
<span style="font-family:Trebuchet; font-size:22px; color:#FFF;"> <?php echo $opis; ?></span>
 
</div>
</center>
<center>
<span class="powered_by">
Powered by: <a href="http://www.barcabih.com" style="cursor:url(../slike/cursor.png), pointer;"> Bar&#231;a BiH</a> | Anketa
</span>
</center>

<center><div id="teren">
<div style="height:160px"></div>
<center>
<table align="center">

	<tr align="center"> <!--golman-->
		<td align="center"> 
        	<table>
			<tr align="center">
            	<td align="center">
                <div id="golman_broj" class="broj"> - </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
               		<label id="golman_ime">Golman</label> <input type="hidden" value="" id="golman_id" />
                	<ul> 
                    <?php
						$upit="SELECT DISTINCT igraci.ime, igraci.id, igraci.broj_na_dresu FROM igraci JOIN GK ON GK.id_igraca=igraci.id";
						$rez=mysql_query($upit);
						if (!$rez) { header("Location: greska.php"); die(); }
						
						$broj_redova=mysql_num_rows($rez);
						for ($i=0; $i<$broj_redova; $i++)
						{
							$red=mysql_fetch_assoc($rez);
							$id=$red['id']; $ime=$red['ime']; $dres=$red['broj_na_dresu'];
							echo<<<_END
							<li onclick="izaberi('$ime',$dres,1,$id)" value=$id > $ime </li>
_END;
						}
					?>
                    </ul> 
                </div>
                </td>
            </table>
            </tr>
		</td>
	</tr> <!--kraj golmana-->
</table></center>
<center>
<table> 
    <tr align="center"> <!--odbrana-->
    	<td align="center"> <!--desni bek-->
        	<table>
            <tr align="center">
            	<td align="center">
                <div id="rb_broj" class="broj"> - </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="rb_ime">Desni bek</label>  <input type="hidden" value="" id="rb_id" />
                	<ul> 
                    <?php
						$upit="SELECT DISTINCT igraci.ime, igraci.id, igraci.broj_na_dresu FROM igraci JOIN RB ON RB.id_igraca=igraci.id";
						$rez=mysql_query($upit);
						if (!$rez) { header("Location: greska.php"); die(); }
						
						$broj_redova=mysql_num_rows($rez);
						for ($i=0; $i<$broj_redova; $i++)
						{
							$red=mysql_fetch_assoc($rez);
							$id=$red['id']; $ime=$red['ime']; $dres=$red['broj_na_dresu'];
							echo<<<_END
							<li onclick="izaberi('$ime',$dres,2,$id)" value=$id > $ime </li>
_END;
						}
					?>
                    </ul> 
                </div>
                </td>
            </tr>
            </table>
        </td>
        <td align="center"> <!--desni stoper-->
        	<table>
        	<tr align="center">
            	<td align="center">
                <div id="cbr_broj" class="broj"> - </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="cbr_ime">Štoper</label>  <input type="hidden" value="" id="cbr_id" />
                	<ul> 
                    <?php
						$upit="SELECT DISTINCT igraci.ime, igraci.id, igraci.broj_na_dresu FROM igraci JOIN CB ON CB.id_igraca=igraci.id";
						$rez=mysql_query($upit);
						if (!$rez) { header("Location: greska.php"); die(); }
						
						$broj_redova=mysql_num_rows($rez);
						for ($i=0; $i<$broj_redova; $i++)
						{
							$red=mysql_fetch_assoc($rez);
							$id=$red['id']; $ime=$red['ime']; $dres=$red['broj_na_dresu'];
							echo<<<_END
							<li onclick="izaberi('$ime',$dres,3,$id)" value=$id > $ime </li>
_END;
						}
					?>
                    </ul> 
                </div>
                </td>
            </tr>
            </table>
        </td>
        <td align="center"> <!--lijevi stoper-->
        <table>
        <tr align="center">
            	<td align="center">
                <div id="cbl_broj" class="broj"> - </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                 	<label id="cbl_ime">Štoper</label>  <input type="hidden" value="" id="cbl_id" />
                	<ul>
                    <?php
						$upit="SELECT DISTINCT igraci.ime, igraci.id, igraci.broj_na_dresu FROM igraci JOIN CB ON CB.id_igraca=igraci.id";
						$rez=mysql_query($upit);
						if (!$rez) { header("Location: greska.php"); die(); }
						
						$broj_redova=mysql_num_rows($rez);
						for ($i=0; $i<$broj_redova; $i++)
						{
							$red=mysql_fetch_assoc($rez);
							$id=$red['id']; $ime=$red['ime']; $dres=$red['broj_na_dresu'];
							echo<<<_END
							<li onclick="izaberi('$ime',$dres,4,$id)" value=$id> $ime </li>
_END;
						}
					?>
                    </ul> 
                </div>
                </td>
            </tr>
        </table>
        </td>
        <td align="center"> <!--lijevi bek-->
        <table>
        <tr align="center">
            	<td align="center">
                <div id="lb_broj" class="broj"> - </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="lb_ime">Lijevi bek</label>  <input type="hidden" value="" id="lb_id" />
                	<ul> 
                    <?php
						$upit="SELECT DISTINCT igraci.ime, igraci.id, igraci.broj_na_dresu FROM igraci JOIN LB ON LB.id_igraca=igraci.id";
						$rez=mysql_query($upit);
						if (!$rez) { header("Location: greska.php"); die(); }
						
						$broj_redova=mysql_num_rows($rez);
						for ($i=0; $i<$broj_redova; $i++)
						{
							$red=mysql_fetch_assoc($rez);
							$id=$red['id']; $ime=$red['ime']; $dres=$red['broj_na_dresu'];
							echo<<<_END
							<li onclick="izaberi('$ime',$dres,5,$id)" value=$id > $ime </li>
_END;
						}
					?>
                    </ul> 
                </div>
                </td>
            </tr>
        </table>
        </td>
    </tr> <!--kraj odbrane-->

</table>
</center>
<br />
<center>
<table> 
    <tr align="center"> <!--vezni red-->
    	<td align="center"> <!--desni vezni-->
        	<table>
            <tr align="center">
            	<td align="center">
                <div id="rmf_broj" class="broj"> - </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="rmf_ime">Desni vezni</label>  <input type="hidden" value="" id="rmf_id" />
                	<ul> 
                    <?php
						$upit="SELECT DISTINCT igraci.ime, igraci.id, igraci.broj_na_dresu FROM igraci JOIN RMF ON RMF.id_igraca=igraci.id";
						$rez=mysql_query($upit);
						if (!$rez) { header("Location: greska.php"); die(); }
						
						$broj_redova=mysql_num_rows($rez);
						for ($i=0; $i<$broj_redova; $i++)
						{
							$red=mysql_fetch_assoc($rez);
							$id=$red['id']; $ime=$red['ime']; $dres=$red['broj_na_dresu'];
							echo<<<_END
							<li onclick="izaberi('$ime',$dres,6,$id)" value=$id > $ime </li>
_END;
						}
					?>
                    </ul> 
                </div>
                </td>
            </tr>
            </table>
        </td>
        <td align="center"> <!--defanzivni vezni-->
        	<table>
        	<tr align="center">
            	<td align="center">
                <div id="dmf_broj" class="broj"> - </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="dmf_ime">Zadnji vezni</label>   <input type="hidden" value="" id="dmf_id" />
                	<ul> 
                    <?php
						$upit="SELECT DISTINCT igraci.ime, igraci.id, igraci.broj_na_dresu FROM igraci JOIN DMF ON DMF.id_igraca=igraci.id";
						$rez=mysql_query($upit);
						if (!$rez) { header("Location: greska.php"); die(); }
						
						$broj_redova=mysql_num_rows($rez);
						for ($i=0; $i<$broj_redova; $i++)
						{
							$red=mysql_fetch_assoc($rez);
							$id=$red['id']; $ime=$red['ime']; $dres=$red['broj_na_dresu'];
							echo<<<_END
							<li onclick="izaberi('$ime',$dres,7,$id)" value=$id > $ime </li>
_END;
						}
					?>
                    </ul> 
                </div>
                </td>
            </tr>
            </table>
        </td>
        <td align="center"> <!--lijevi vezni-->
        <table>
        <tr align="center">
            	<td align="center">
                <div id="lmf_broj" class="broj"> - </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                 	<label id="lmf_ime">Lijevi vezni</label>  <input type="hidden" value="" id="lmf_id" />
                	<ul>
                    <?php
						$upit="SELECT DISTINCT igraci.ime, igraci.id, igraci.broj_na_dresu FROM igraci JOIN LMF ON LMF.id_igraca=igraci.id";
						$rez=mysql_query($upit);
						if (!$rez) { header("Location: greska.php"); die(); }
						
						$broj_redova=mysql_num_rows($rez);
						for ($i=0; $i<$broj_redova; $i++)
						{
							$red=mysql_fetch_assoc($rez);
							$id=$red['id']; $ime=$red['ime']; $dres=$red['broj_na_dresu'];
							echo<<<_END
							<li onclick="izaberi('$ime',$dres,8,$id)" value=$id> $ime </li>
_END;
						}
					?>
                    </ul> 
                </div>
                </td>
            </tr>
        </table>
        </td>
    </tr> <!--kraj veznog reda-->

</table>
</center>
<br />
<center>
<table> 
    <tr align="center"> <!--napad-->
    	<td align="center"> <!--desno krilo-->
        	<table>
            <tr align="center">
            	<td align="center">
                <div id="rwf_broj" class="broj"> - </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="rwf_ime">Desno krilo</label>  <input type="hidden" value="" id="rwf_id" />
                	<ul> 
                    <?php
						$upit="SELECT DISTINCT igraci.ime, igraci.id, igraci.broj_na_dresu FROM igraci JOIN RWF ON RWF.id_igraca=igraci.id";
						$rez=mysql_query($upit);
						if (!$rez) { header("Location: greska.php"); die(); }
						
						$broj_redova=mysql_num_rows($rez);
						for ($i=0; $i<$broj_redova; $i++)
						{
							$red=mysql_fetch_assoc($rez);
							$id=$red['id']; $ime=$red['ime']; $dres=$red['broj_na_dresu'];
							echo<<<_END
							<li onclick="izaberi('$ime',$dres,9,$id)" value=$id > $ime </li>
_END;
						}
					?>
                    </ul> 
                </div>
                </td>
            </tr>
            </table>
        </td>
        <td align="center"> <!--centarfor-->
        	<table>
        	<tr align="center">
            	<td align="center">
                <div id="cf_broj" class="broj"> - </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                	<label id="cf_ime">Centarfor</label>  <input type="hidden" value="" id="cf_id" />
                	<ul> 
                    <?php
						$upit="SELECT DISTINCT igraci.ime, igraci.id, igraci.broj_na_dresu FROM igraci JOIN CF ON CF.id_igraca=igraci.id";
						$rez=mysql_query($upit);
						if (!$rez) { header("Location: greska.php"); die(); }
						
						$broj_redova=mysql_num_rows($rez);
						for ($i=0; $i<$broj_redova; $i++)
						{
							$red=mysql_fetch_assoc($rez);
							$id=$red['id']; $ime=$red['ime']; $dres=$red['broj_na_dresu'];
							echo<<<_END
							<li onclick="izaberi('$ime',$dres,10,$id)" value=$id > $ime </li>
_END;
						}
					?>
                    </ul> 
                </div>
                </td>
            </tr>
            </table>
        </td>
        <td align="center"> <!--lijevo krilo-->
        <table>
        <tr align="center">
            	<td align="center">
                <div id="lwf_broj" class="broj"> - </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center">
                <div class="ime">
                 	<label id="lwf_ime">Lijevo krilo</label>  <input type="hidden" value="" id="lwf_id" />
                	<ul>
                    <?php
						$upit="SELECT DISTINCT igraci.ime, igraci.id, igraci.broj_na_dresu FROM igraci JOIN LWF ON LWF.id_igraca=igraci.id";
						$rez=mysql_query($upit);
						if (!$rez) { header("Location: greska.php"); die(); }
						
						$broj_redova=mysql_num_rows($rez);
						for ($i=0; $i<$broj_redova; $i++)
						{
							$red=mysql_fetch_assoc($rez);
							$id=$red['id']; $ime=$red['ime']; $dres=$red['broj_na_dresu'];
							echo<<<_END
							<li onclick="izaberi('$ime',$dres,11,$id)" value=$id> $ime </li>
_END;
						}
					?>
                    </ul> 
                </div>
                </td>
            </tr>
        </table>
        </td>
    </tr> <!--kraj napada-->

</table>
</center>

</div></center>

<center>
<input type="button" class="dugme" value="Glasaj" onclick="glasaj()" />
<input type="button" class="dugme" value="Rezultati" onclick="rezultati()" />
</center>

</body>
</html>