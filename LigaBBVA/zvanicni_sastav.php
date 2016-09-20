<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Match Center | Barca BiH</title>
<link rel="shortcut icon" href="../ChampionsLeague/slike/pbd.ico" />
<link rel="stylesheet" type="text/css" href="stilovi/main.css" />
<script type="text/javascript" src="skripte/skripta.js"> </script>
</head>

<?php

require_once("konekcija.php");

$upit="SELECT * FROM utakmice WHERE status !=0";
$rez=mysql_query($upit);

if ($rez==false || mysql_num_rows($rez)!=1) { header("Location: greska.php"); die(); }
 
$utakmica=mysql_fetch_assoc($rez);
$status=$utakmica['status'];
$id=$utakmica['id'];

$upit="SELECT * FROM sastav_$id ORDER BY id";
$rez=mysql_query($upit);
if ($rez==false) { header("Location: greska.php"); die(); }

$red=mysql_fetch_assoc($rez); $gk_ime=$red['ime'];  $gk_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $rb_ime=$red['ime'];  $rb_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $cbr_ime=$red['ime']; $cbr_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $cbl_ime=$red['ime']; $cbl_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $lb_ime=$red['ime'];  $lb_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $dmf_ime=$red['ime']; $dmf_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $rmf_ime=$red['ime']; $rmf_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $lmf_ime=$red['ime']; $lmf_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $rwf_ime=$red['ime']; $rwf_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $lwf_ime=$red['ime']; $lwf_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $cf_ime=$red['ime'];  $cf_broj=$red['broj_na_dresu'];

$red=mysql_fetch_assoc($rez); $klupa1_ime=$red['ime'];  $klupa1_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $klupa2_ime=$red['ime'];  $klupa2_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $klupa3_ime=$red['ime'];  $klupa3_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $klupa4_ime=$red['ime'];  $klupa4_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $klupa5_ime=$red['ime'];  $klupa5_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $klupa6_ime=$red['ime'];  $klupa6_broj=$red['broj_na_dresu'];
$red=mysql_fetch_assoc($rez); $klupa7_ime=$red['ime'];  $klupa7_broj=$red['broj_na_dresu'];

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
<div style="font-family:Din; font-size:36px; color:#FFF; margin-top:10px">
<?php echo "$domacin - $gost"; ?>
<br />
<span style="font-family:Din; font-size:22px; color:#FFF;"> <?php echo $opis; ?></span>
 
</div>
</center>
<center>
<span class="powered_by">
Powered by: <a href="http://www.barcabih.com" style="cursor:url(../slike/cursor.png), pointer;"> Bar&#231;a BiH</a> | Zvanicni sastav
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
                <div id="golman_broj" class="broj"> <?php echo "$gk_broj"; ?> </div>
                </td>
            </tr>
			<tr align="center">
            	<td align="center" width="600"
                <div class="ime">
               		<label id="golman_ime"><?php echo "$gk_ime"; ?>
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
    </tr> <!--kraj napada-->

</table>
</center>

</div></center>
<center>
<table>
	<tr>
    	<td>
        	<table><tr>
            	<td class="igrac_klupa_broj"> <?php echo $klupa1_broj ?> </td>
                
                <td class="igrac_klupa_ime"> <?php echo $klupa1_ime; ?> </td>
            
            </tr></table> 	
         </td>  
   		<td>
    		<table><tr>
            	<td class="igrac_klupa_broj"> <?php echo $klupa2_broj ?> </td>
                
                <td class="igrac_klupa_ime"> <?php echo $klupa2_ime; ?> </td>
            
            </tr></table> 	
    	</td>
        
        <td>
    		<table><tr>
            	<td class="igrac_klupa_broj"> <?php echo $klupa3_broj ?> </td>
                
                <td class="igrac_klupa_ime"> <?php echo $klupa3_ime; ?> </td>
            
            </tr></table> 	
    	</td>
    
   		<td>
    		<table><tr>
            	<td class="igrac_klupa_broj"> <?php echo $klupa4_broj ?> </td>
                
                <td class="igrac_klupa_ime"> <?php echo $klupa4_ime; ?> </td>
            
            </tr></table> 	
    	</td>
    </tr>
</table>
</center>
<center>
<table>
	<tr>
		<td>
    		<table><tr>
            	<td class="igrac_klupa_broj"> <?php echo $klupa5_broj ?> </td>
                
                <td class="igrac_klupa_ime"> <?php echo $klupa5_ime; ?> </td>
            
            </tr></table> 	
    	</td>
    
   		<td>
    		<table><tr>
            	<td class="igrac_klupa_broj"> <?php echo $klupa6_broj ?> </td>
                
                <td class="igrac_klupa_ime"> <?php echo $klupa6_ime; ?> </td>
            
            </tr></table> 	
    	</td>
        
        <td>
    		<table><tr>
            	<td class="igrac_klupa_broj"> <?php echo $klupa7_broj ?> </td>
                
                <td class="igrac_klupa_ime"> <?php echo $klupa7_ime; ?> </td>
            
            </tr></table> 	
    	</td>
    
   		<td>
    		<table><tr>
            	<td class="igrac_klupa_broj"> TR </td>
                
                <td class="igrac_klupa_ime"> Tito Vilanova </td>
            
            </tr></table> 	
    	</td>
    </tr>
</table>
</center>


<center>
<input type="button" class="dugme" value="Osvježi" style="margin-bottom:20px" onclick="window.location.href='index.php'" />
</center>

</body>
</html>