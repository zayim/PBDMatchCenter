// JavaScript Document
function izaberi(ime,dres,pos,id) //dres,ime,pozicija
{
	var poz="";
	switch(pos)
	{
		case 1: poz="golman"; break;
		case 2: poz="rb"; break;
		case 3: poz="cbr"; break;
		case 4: poz="cbl"; break;
		case 5: poz="lb"; break;
		case 6: poz="rmf"; break;
		case 7: poz="dmf"; break;
		case 8: poz="lmf"; break;
		case 9: poz="rwf"; break;
		case 10: poz="cf"; break;
		case 11: poz="lwf"; break;
	}
	
	document.getElementById(poz+"_broj").innerHTML=dres;
	document.getElementById(poz+"_ime").innerHTML=ime;
	document.getElementById(poz+"_id").value=id;
}
function glasaj()
{
	var params="";
	var poruka="Niste izabrali sve igrače!";
	
	gk=document.getElementById("golman_id").value;
	rb=document.getElementById("rb_id").value;
	cbr=document.getElementById("cbr_id").value;
	cbl=document.getElementById("cbl_id").value;
	lb=document.getElementById("lb_id").value;
	rmf=document.getElementById("rmf_id").value;
	dmf=document.getElementById("dmf_id").value;
	lmf=document.getElementById("lmf_id").value;
	rwf=document.getElementById("rwf_id").value;
	cf=document.getElementById("cf_id").value;
	lwf=document.getElementById("lwf_id").value;
	
	if (document.getElementById("golman_id").value=="") { alert(poruka); return; }
	params+="gk="+document.getElementById("golman_id").value;
	
	if (document.getElementById("rb_id").value=="") { alert(poruka); return; }
	params+="&rb="+document.getElementById("rb_id").value;
	
	if (document.getElementById("cbr_id").value=="") { alert(poruka); return; }
	params+="&cbr="+document.getElementById("cbr_id").value;
	
	if (document.getElementById("cbl_id").value=="") { alert(poruka); return; }
	params+="&cbl="+document.getElementById("cbl_id").value;
	
	if (document.getElementById("lb_id").value=="") { alert(poruka); return; }
	params+="&lb="+document.getElementById("lb_id").value;
	
	if (document.getElementById("rmf_id").value=="") { alert(poruka); return; }
	params+="&rmf="+document.getElementById("rmf_id").value;
	
	if (document.getElementById("dmf_id").value=="") { alert(poruka); return; }
	params+="&dmf="+document.getElementById("dmf_id").value;
	
	if (document.getElementById("lmf_id").value=="") { alert(poruka); return; }
	params+="&lmf="+document.getElementById("lmf_id").value;
	
	if (document.getElementById("rwf_id").value=="") { alert(poruka); return; }
	params+="&rwf="+document.getElementById("rwf_id").value;
	
	if (document.getElementById("cf_id").value=="") { alert(poruka); return; }
	params+="&cf="+document.getElementById("cf_id").value;
	
	if (document.getElementById("lwf_id").value=="") { alert(poruka); return; }
	params+="&lwf="+document.getElementById("lwf_id").value;
	
	if (gk==rb || gk==cbr || gk==cbl || gk==lb || gk==rmf || gk==dmf || gk==lmf || gk==rwf || gk==cf || gk==lwf)
	{ alert("Neke igrače ste dva puta izabrali!"); return; }
	
	if (rb==cbr || rb==cbl || rb==lb || rb==rmf || rb==dmf || rb==lmf || rb==rwf || rb==cf || rb==lwf)
	{ alert("Neke igrače ste dva puta izabrali!"); return; }
	
	if (cbr==cbl || cbr==lb || cbr==rmf || cbr==dmf || cbr==lmf || cbr==rwf || cbr==cf || cbr==lwf)
	{ alert("Neke igrače ste dva puta izabrali!"); return; }
	
	if (cbl==lb || cbl==rmf || cbl==dmf || cbl==lmf || cbl==rwf || cbl==cf || cbl==lwf)
	{ alert("Neke igrače ste dva puta izabrali!"); return; }
	
	if (lb==rmf || lb==dmf || lb==lmf || lb==rwf || lb==cf || lb==lwf)
	{ alert("Neke igrače ste dva puta izabrali!"); return; }
	
	if (rmf==dmf || rmf==lmf || rmf==rwf || rmf==cf || rmf==lwf)
	{ alert("Neke igrače ste dva puta izabrali!"); return; }
	
	if (dmf==lmf || dmf==rwf || dmf==cf || dmf==lwf)
	{ alert("Neke igrače ste dva puta izabrali!"); return; }
	
	if (lmf==rwf || lmf==cf || lmf==lwf)
	{ alert("Neke igrače ste dva puta izabrali!"); return; }
	
	if (rwf==cf || rwf==lwf)
	{ alert("Neke igrače ste dva puta izabrali!"); return; }
	
	if (cf==lwf)
	{ alert("Neke igrače ste dva puta izabrali!"); return; }
	
	zahtjev = new ajaxZahtjev();
	if (zahtjev==false) window.location.href="greska.php";
	zahtjev.open("POST","glasaj.php",true);
	zahtjev.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	zahtjev.onreadystatechange=function()
	{
		if (this.readyState==4 && this.status==200 && this.responseText)
		{
			
			if (this.responseText.substr(0,7)=="success") { rezultati(); } 
			else alert("Greška!");
		}
	}
	
	zahtjev.send(params);
}
function rezultati()
{
	
	window.location.href="rezultati.php";
}
function osvjezi_rezultat()
{
	zahtjev = new ajaxZahtjev();
	if (zahtjev==false) window.location.href="greska.php";
	
	zahtjev.open("POST","daj_naslov.php",true);
	zahtjev.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	zahtjev.onreadystatechange=function()
	{
		if (this.readyState==4 && this.status==200 && this.responseText)
		{
				if(this.responseText!=document.getElementsByTagName("title").item(0).innerHTML)
				{
					document.getElementsByTagName("title").item(0).innerHTML=this.responseText;
					window.location.reload(true);
				}
		}
	}
	zahtjev.send();
}
function prikazi_live_stream()
{
	zahtjev = new ajaxZahtjev();
	if (zahtjev==false) window.location.href="greska.php";
	
	zahtjev.open("POST","live_stream.php",true);
	zahtjev.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	zahtjev.onreadystatechange=function()
	{
		if (this.readyState==4 && this.status==200 && this.responseText)
		{
				document.getElementById("live_stream").innerHTML=this.responseText;
				document.getElementsByClassName("klikni_live_stream").item(0).innerHTML="<a href='javascript:sakrij_live_stream()'>Sakrij LIVE Stream prijenos</a>";
		}
	}
	zahtjev.send();
	
	
}
function sakrij_live_stream()
{	
	document.getElementById("live_stream").innerHTML="";
	document.getElementsByClassName("klikni_live_stream").item(0).innerHTML="<a href='javascript:prikazi_live_stream()'>Klikni za LIVE Stream prijenos</a>";
}