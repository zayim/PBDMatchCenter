// JavaScript Document
function dodaj_prostor_za_igraca()
{
	sadrzaj="";
	var tabela=document.getElementById("tabela");
	var red=tabela.insertRow(tabela.rows.length);
	red.setAttribute('onclick',"f(this)");
	id=tabela.rows.length-1;
	id_="trik"+id;
	
	sadrzaj+="<td class='dres1'>";
	sadrzaj+="<input type='text' name='dres_"+id+"'/>";
	
	sadrzaj+="</td><td class='ime1'>";
	sadrzaj+="<input type='text' name='ime_"+id+"'/>";
	
	sadrzaj+="</td><td class='poz1'>";
	sadrzaj+="<input type='checkbox' name='pozicije_" + id + "[]' value='GK'";
	
	sadrzaj+="</td><td class='poz1'>";
	sadrzaj+="<input type='checkbox' name='pozicije_" + id + "[]' value='RB'";
	
	sadrzaj+="</td><td class='poz1'>";
	sadrzaj+="<input type='checkbox' name='pozicije_" + id + "[]' value='LB'";
	
	sadrzaj+="</td><td class='poz1'>";
	sadrzaj+="<input type='checkbox' name='pozicije_" + id + "[]' value='CB'";
	
	sadrzaj+="</td><td class='poz1'>";
	sadrzaj+="<input type='checkbox' name='pozicije_" + id + "[]' value='DMF'";
	
	sadrzaj+="</td><td class='poz1'>";
	sadrzaj+="<input type='checkbox' name='pozicije_" + id + "[]' value='RMF'";
	
	sadrzaj+="</td><td class='poz1'>";
	sadrzaj+="<input type='checkbox' name='pozicije_" + id + "[]' value='LMF'";
	
	sadrzaj+="</td><td class='poz1'>";
	sadrzaj+="<input type='checkbox' name='pozicije_" + id + "[]' value='RWF'";
	
	sadrzaj+="</td><td class='poz1'>";
	sadrzaj+="<input type='checkbox' name='pozicije_" + id + "[]' value='LWF'";
	
	sadrzaj+="</td><td class='poz1'>";
	sadrzaj+="<input type='checkbox' name='pozicije_" + id + "[]' value='CF'";
	
	sadrzaj+="</td>";
	
	sadrzaj+="<input type='hidden' value=0 id='"+id_+"'"; sadrzaj+="/"; sadrzaj+=">";
	red.innerHTML+=sadrzaj;
	document.getElementsByName("broj_igraca").item(0).value= (parseInt(document.getElementsByName("broj_igraca").item(0).value) + 1);
}
function f(arg)
{
	var x=document.getElementById('trik'+(arg.rowIndex-1)).value;
	if (x==0)
	{ 
		document.getElementById('trik'+(arg.rowIndex-1)).value=1;
		dodaj_prostor_za_igraca();
	}
}
/*function foo()
{
	params="";
	var bri=parseInt(document.getElementsByName("broj_igraca").item(0).value)-1;
	
	params="broj_igraca="+(bri+1);
	for (var i=1; i<=bri; i++)
	{
		var dres=document.getElementsByName("dres_"+i).item(0).value;
		var ime=document.getElementsByName("ime_"+i).item(0).value;
		params+="&dres_"+i+"="+dres+"&ime_"+i+"="+ime;	
	}
	alert(params);
	
	zahtjev = new ajaxZahtjev();
	zahtjev.open("POST","unesi_igrace_koji_konkurisu.php",true);
	zahtjev.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	zahtjev.onreadystatechange=function()
	{
		if (this.readyState==4 && this.status==200 && this.responseText)
		{
			alert("Nedo");
			alert(this.responseText);
		}
	}
	
	zahtjev.send(params);
}*/