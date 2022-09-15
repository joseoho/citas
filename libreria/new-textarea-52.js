var rte;
var browser;

//object RTE
function RTE() {
  //rte elements
  this.win;       //iframe contentwindow
  this.doc;       //iframe contentWindow.document
  this.buttons;   //buttons table
  this.tableButtons;   //buttons table
  this.colorWin;  //iframe color window
  this.frame;     //iframe editor window
  this.textarea;  //rte textarea for swich mode
  this.status;    //status bar

  //user variable
  this.command;   //command issued for rte
  this.range;     //currently selected range
  this.rangeEl;   //parent element(node) of range 
}

//start point 
function replaceTextarea(taid, width, height, rteUrl) {
   var ta = document.getElementById(taid);
   var divid = "rte_"+taid;
	 browser=new BROWSER();
   if (!browser.isRTEable)
      return false;
      
   rte = new RTE(taid);
   document.writeln('<div class="rteDiv" id="'+divid+'" style="background-color:#cccccc">'); //Color del formulario
   writeRTE();
   document.writeln('</div>');
   
   ta.style.display = 'none';
   if (!initRTE(divid, ta.value, width, height, rteUrl))
     return false;

   if (typeof ta.form.onsubmit == "function") {
     var frmstr = ta.form.onsubmit.toString();
     frmstr = frmstr.substring( frmstr.indexOf("{")+1 , frmstr.lastIndexOf("}") );
   }
   ta.form.onsubmit = new Function("rtePresubmit('"+taid+"');" + frmstr);   

}

function rtePresubmit (taid) {
  //find RTE text area and window
  var rteEls = document.getElementById('rte_'+taid).childNodes;
	for (var i=0; i<rteEls.length; i++) {
		if ( rteEls[i].id == "rteWin" )			rte.frame      = rteEls[i];
    if ( rteEls[i].id == "rteTxt" )       rte.textarea = rteEls[i];
	}  
  rte.win = rte.frame.contentWindow;
  rte.doc = rte.win.document;

  //set textarea value by rteTxt value
  document.getElementById(taid).value = rte.doc.body.innerHTML;
  
}

//set width, set height, and turn on RTE mode
function initRTE(divid, html, width, height, rteUrl) {
  //set width and height of table, window, and textarea
  var rteEls = document.getElementById(divid).childNodes;
	for (var i=0; i<rteEls.length; i++) {
		if ( rteEls[i].id == "rteWin" )			rte.frame      = rteEls[i];
    if ( rteEls[i].id == "rteTxt" )       rte.textarea = rteEls[i];
    if ( rteEls[i].id == "rteButtons" )   rte.buttons  = rteEls[i];
    if ( rteEls[i].id == "rteStatus" )    rte.status  = rteEls[i];
    if ( rteEls[i].id == "rteTableButtons" )  rte.tableButtons  = rteEls[i];    
		if ( rteEls[i].id == "rteColorWin")	rte.colorWin = rteEls[i];        
	}
  rte.win = rte.frame.contentWindow;
  rte.doc = rte.win.document;

  document.getElementById(divid).style.width= width;
  rte.frame.style.width = width;  
  rte.frame.style.height = height;  
  rte.textarea.style.width = width;  
  rte.textarea.style.height = height;  
    
  var x = rte.colorWin.src.lastIndexOf("/");
  var colorFile = rte.colorWin.src.substring(x+1,rte.colorWin.src.length);
  rte.colorWin.src = rteUrl + "/" + colorFile;
  
  
  /*
  Codigo malicioso y privativo
  var kim = document.getElementById('__kim');
  if (kim==null || kim.tagName != "A" || kim.innerHTML<="" ) {
    alert("New-Textarea Requires Link To CityPost.ca");
    return false;
  }*/

  var imgEls = document.getElementById(divid).getElementsByTagName("img");
  for (var i=0; i<imgEls.length; i++) {
    if (!rteUrl) break;
    var x = imgEls[i].src.lastIndexOf("/");
    var imgFile = imgEls[i].src.substring(x+1,imgEls[i].src.length);
    imgEls[i].src = rteUrl + "/img/" + imgFile;
    } 

  //turn on RTE mode
  try {
    if (browser.isGecko)
       rte.frame.contentDocument.designMode = "on";
   	rte.doc.open();
    rte.doc.write("<body>"+html+"</body>");
   	rte.doc.close();
    if (browser.isIE)
       rte.doc.designMode = "On";
	} catch (e) {
   		//gecko may take some time to enable design mode.
   		//Keep looping until able to set.
      if (browser.isGecko) {
      	setTimeout("setupRTE('"+divid+"','"+html+"','+width+','+height+');", 10);
      } else {
         alert("setupRTE Failed."+e);
      	return false;
      }
	} //end catch
  
  setRangeEl(1);
  return true;
}

//set the parent Element of current cursor
function setRangeEl(cont) {

  if (cont==0) 
    return;
   
  var node;
  try {
     var sel  = (browser.isIE)?
         rte.win.document.selection : rte.win.getSelection();
     var range = (browser.isIE)? 
         sel.createRange():sel.getRangeAt(sel.rangeCount - 1).cloneRange();
  }
  catch (e) {  //it continues although error occurs when no range
    setTimeout("setRangeEl(1)", 500 );
    return;
  }
      
  var pEl;
  if (browser.isIE) {
      switch (sel.type) {
         case "Text":case "None":
           pEl= range.parentElement(); break;
         case "Control":
           pEl = range.item(0); break;
         default:
           pEl = rte.doc;
      }
   } 
   else {
      try {
         var p = range.commonAncestorContainer;
         if (!range.collapsed && range.startContainer == range.endContainer 
            && range.startOffset - range.endOffset <= 1 
            && range.startContainer.hasChildNodes())
           p = range.startContainer.childNodes[range.startOffset];
         while (p.nodeType == 3)
           p = p.parentNode;
         pEl = p;
      } catch (e) {
         pEl = rte.doc;
      }
  }

  rte.tableButtons.style.display = (pEl.tagName.toLowerCase()=="td")?
         "inline":"none";
  
  rte.rangeEl = pEl;
  rte.status.innerHTML = "&lt;"+pEl.tagName.toLowerCase()+"&gt;";
  setTimeout("setRangeEl(1)", 500 );
}


function toEmptyContent(){
	document.getElementById("shadow").value =rte.doc.body.innerHTML;
	
}


function toggleMode(e) {
  el = e.target || e.srcElement;
  try {
    setRTEObj(e);
  } catch(e) {}

  //show or hide
  rte.buttons.style.visibility= (el.checked)? "hidden" : "visible";
  rte.tableButtons.style.visibility= (el.checked)? "hidden": "visible";  
  rte.frame.style.display= (el.checked)? "none": "block";
  rte.textarea.style.display= (el.checked)? "block": "none";

  //synchronize rteWindow, and textarea
  if (el.checked)   
    rte.textarea.value = rte.doc.body.innerHTML;
  else {
    rte.doc.body.innerHTML = rte.textarea.value;
    if (browser.isGecko)
       rte.frame.contentDocument.designMode = "on";
    rte.doc.open();
    rte.doc.write(rte.textarea.value);
    rte.doc.close();
    if (browser.isIE)
       rte.doc.designMode = "On";
  }
}

//set RTE variables again by each click occurs for multiple instances
function setRTEObj(e) {
  //find rte window, textarea, and button elements.
	var el = e.target || e.srcElement;
	while (el.className != "rteDiv")
		el = el.parentNode;
  var rteEls = document.getElementById(el.id).childNodes;
	for (var i=0; i<rteEls.length; i++) {
		if ( rteEls[i].id == "rteWin" )			rte.frame = rteEls[i];  
		if ( rteEls[i].id == "rteTxt")			rte.textarea = rteEls[i];  
		if ( rteEls[i].id == "rteButtons")		rte.buttons = rteEls[i];
		if ( rteEls[i].id == "rteColorWin")		rte.colorWin = rteEls[i];        
		if ( rteEls[i].id == "rteTableButtons")	rte.tableButtons = rteEls[i];        
		if ( rteEls[i].id == "rteStatus")	   	rte.status = rteEls[i];        
	}
	rte.win = rte.frame.contentWindow;
	rte.doc = rte.win.document;
  
  var sel = (browser.isIE)?
         rte.win.document.selection : rte.win.getSelection();
  rte.range = (browser.isIE)? 
      sel.createRange():sel.getRangeAt(sel.rangeCount - 1).cloneRange();
}

//Function to format text in the text box
function formatText(e, command, option) {
  setRTEObj(e);
  rte.command = command;

  try {
    //when about color
		if ((command == "forecolor") || (command == "hilitecolor")) {
        //position and show color palette
        var colorImg = e.target || e.srcElement;
        rte.colorWin.style.left = getPosX(colorImg) + "px";
        rte.colorWin.style.top = getPosY(colorImg)+20 + "px";
        rte.colorWin.style.display = 
          (rte.colorWin.style.display=="block")?"none":"block";
 		} 
    //when about link
    else if (command == "createlink") {
        var szURL = prompt("Ingrese un URL:", "");
        try {
         	rte.doc.execCommand("Unlink", false, null);
         	rte.doc.execCommand("CreateLink", false, szURL);
        }catch (e) {
          	//do nothing although blank url is given
        }
		} 
    //for all commands
    else {
  		  rte.win.focus();
	      rte.doc.execCommand(command, false, option);
		    rte.win.focus();
		}
	} catch (e) {
		alert(e);
	}
}

//Function to set color
function setColor(color) {
	if (browser.isIE) {
		//retrieve selected range
		var sel = rte.doc.selection; 
		if (rte.command == "hilitecolor") rte.command = "backcolor";
		if (sel != null) {
			var newRng = sel.createRange();
			newRng = rte.range;
			newRng.select();
		}
	}
	
	rte.win.focus();
	rte.doc.execCommand(rte.command, false, color);
	rte.win.focus();
	rte.colorWin.style.display = "none";
}

function getPosX(obj) {
	var curleft = 0;
	if (obj.offsetParent)	{
		while (obj.offsetParent)		{
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
		curleft += obj.x;
	return curleft;
}

function getPosY(obj) {
	var curtop = 0;
	if (obj.offsetParent)	{
		while (obj.offsetParent)		{
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (obj.y)
		curtop += obj.y;
	return curtop;
}

//Function to add image
function addImage(e) {
	var imgUrl = prompt('Ingrese la ubicacion de la imagen:', '');				
	if ((imgUrl != null) && (imgUrl != "")) 
	//var newUrl = imgUrl;
     formatText(e, "InsertImage", imgUrl);
}

// Called when the user clicks the Insert Table button
function insertTable(e) {
  var rows =  parseInt(prompt('Filas   :', 2));
  var cols =  parseInt(prompt('Columnas:', 3));

	if (rows && cols && rows>0 && cols>0);
  else
     return false;
    
  //make a table 
	var table = document.createElement("table");
  table.border=1; table.width=100; table.height=50
	var tbody = document.createElement("tbody");
	table.appendChild(tbody);
	for (var i = 0; i < rows; ++i) {
		var tr = document.createElement("tr");
		tbody.appendChild(tr);
		for (var j = 0; j < cols; ++j) {
			var td = document.createElement("td");
			tr.appendChild(td);
			if (browser.isGecko) 
         td.appendChild(document.createElement("br")); //no br, no display
		}
	}
  
  setRTEObj(e);
  //insert to selected range 
	if (rte.range && browser.isIE) 
		rte.range.pasteHTML(table.outerHTML);
  else 
		rte.range.insertNode(table);

};

function addTD(e) {
  var newTD = document.createElement("td");
  newTD.innerHTML = "&nbsp;"; 

  setRTEObj(e);
  //insert to selected range
	if (browser.isIE) { //wish IE follow standard.
     rte.range.pasteHTML("#P#");
     var tmp = rte.rangeEl.outerHTML;
     var newTmp = tmp + newTD.outerHTML;
     
     var html = rte.doc.body.innerHTML.replace(tmp,newTmp);
     html = html.replace("#P#","");
     rte.doc.body.innerHTML =html;
  }
  else {//See! so simple
     var p = rte.rangeEl.parentNode;
     p.insertBefore(newTD, rte.rangeEl.nextSibling);
  }
}

function addTR(e) {
  setRTEObj(e);

  var curTR = rte.rangeEl.parentNode;  //container tr
  var curTDs = curTR.getElementsByTagName("TD");
  
  var newTR = document.createElement("tr");
  for (var i=0; i<curTDs.length; i++) {
    var colspan = (rte.rangeEl.getAttribute("colSpan")<1)? 
               1:parseInt(curTDs[i].getAttribute("colSpan"));

    for (var j=0; j<colspan; j++) {
       var newTD = document.createElement("TD");
       newTD.innerHTML = "&nbsp;";
       newTR.appendChild(newTD);
    }
  }
  
	if (browser.isIE) { //wish IE follow standard.
     rte.range.pasteHTML("#P#");
     var html = rte.doc.body.innerHTML;

     for (var i=html.indexOf("#P#"); i < html.length ; i++) {
         if (html.substr(i,3) == "<TR") {
            html = html.substr(0,i)+"#TRE#"+ html.substring(i);
            break;
          }
         if (html.substr(i,5) == "</TR>") {
            html = html.substr(0,i+5)+"#TRE#"+ html.substring(i+5);
            break;
         }
     }
     
     html = html.replace("#TRE#", newTR.outerHTML);
     html = html.replace("#P#","");
     html = html.replace("#TRE#","");
     rte.doc.body.innerHTML =html;     
  }
  else {//See! so simple
     var curTABLE = curTR.parentNode;
     curTABLE.insertBefore(newTR, curTR.nextSibling);
  }

}

function delTD(e) {
  setRTEObj(e);
  var p = rte.rangeEl.parentNode;
  p.removeChild(rte.rangeEl);
}

function delTR(e) {
  setRTEObj(e);
  var curTR = rte.rangeEl.parentNode;
  var curTABLE = curTR.parentNode;
  curTABLE.removeChild(curTR);
}

function setColspan(e,no) {
  setRTEObj(e);
 
  var colspan;
  var attr = (browser.isIE)?"colSpan":"colspan";
  if (rte.rangeEl.getAttribute(attr)<1)
      colspan = 0 + no;
  else
      colspan = parseInt(rte.rangeEl.getAttribute(attr)) + no;
  
  if (colspan>0) {
    rte.rangeEl.setAttribute( attr, colspan );

   	if (browser.isIE) 
      redisplay();
  }
}

function setRowspan(e,no) {
  setRTEObj(e);
 
  var rowspan;
  var attr = (browser.isIE)?"rowSpan":"rowspan";
  if (rte.rangeEl.getAttribute(attr)<1)
      rowspan = 0 + no;
  else
      rowspan = parseInt(rte.rangeEl.getAttribute(attr)) + no;
  
  if (rowspan>0) {
    rte.rangeEl.setAttribute( attr, rowspan );

   	if (browser.isIE) 
       redisplay()
  }
}

function resizeWin(e,height) {
  setRTEObj(e);
  rte.frame.style.height = height;
  rte.textarea.style.height = height;
}

function redisplay() {  //this is for IE
  rte.frame.style.visibility="hidden";
  rte.frame.style.visibility="visible";
}

// object browser
function BROWSER() {
   var ua = navigator.userAgent.toLowerCase(); 

   this.isGecko     = (ua.indexOf('gecko') != -1 && ua.indexOf('safari') == -1);
   this.isMozilla   = (this.isGecko && ua.indexOf('gecko/') + 14 == ua.length);
   this.isNS        = ( (this.isGecko) ? (ua.indexOf('netscape') != -1) : ( (ua.indexOf('mozilla') != -1) && (ua.indexOf('spoofer') == -1) && (ua.indexOf('compatible') == -1) && (ua.indexOf('opera') == -1) && (ua.indexOf('webtv') == -1) && (ua.indexOf('hotjava') == -1) ) );
   this.isIE        = ( (ua.indexOf('msie') != -1) && (ua.indexOf('opera') == -1) && (ua.indexOf('webtv') == -1) ); 
   this.isSafari    = (ua.indexOf('safari') != - 1);
   this.isOpera     = (ua.indexOf('opera') != -1); 
   this.isKonqueror = (ua.indexOf('konqueror') != -1 && !this.isSafari); 
   this.isIcab      = (ua.indexOf('icab') != -1); 
   this.isAol       = (ua.indexOf('aol') != -1); 
   this.isIE5up = (this.isIE && this.versionMajor >= 5);

   this.isRTEable  = (document.getElementById && document.designMode && !this.isSafari && !this.isKonqueror);   
}

function writeRTE() {
   document.writeln('<style>#rteButtons img {vertical-align:bottom;}</style>');
   document.writeln('<style>#rteButtons select {height:21px;}</style>');
   document.writeln('<style>#rteTableButtons img {vertical-align:bottom;}</style>');
   document.writeln('<span id="rteButtons">');
/*   document.writeln('	<select onchange="formatText(event, \'formatblock\', this.options[this.selectedIndex].value)">');
   document.writeln('		<option value="">[Estilo]</option>');
   document.writeln('		<option value="<p>">Paragraph</option>');
   document.writeln('		<option value="<h1>"><h1>Heading 1</h1></option>');
   document.writeln('		<option value="<h2>"><h2>Heading 2</h2></option>');
   document.writeln('		<option value="<h3>"><h3>Heading 3</h3></option>');
   document.writeln('		<option value="<h4>"><h4>Heading 4</h4></option>');
   document.writeln('		<option value="<h5>"><h5>Heading 5</h5></option>');
   document.writeln('		<option value="<h6>"><h6>Heading 6</h6></option>');
   document.writeln('		<option value="<address>"><addr>Address</addr></option>');
   document.writeln('		<option value="<pre>"><pre>Formatted</pre></option>');
   document.writeln('	</select>');
 
 document.writeln('	<select onchange="formatText(event, \'fontname\', this.options[this.selectedIndex].value);">');
   document.writeln('		<option value="">[Font]</option>');
    document.write('           <option style="font-family:Andale Mono IPA;" value="Andale Mono IPA">Andale Mono IPA');
    document.write('           <option style="font-family:Arial;" value="Arial">Arial');
    document.write('           <option style="font-family:Arial Narrow;" value="Arial Narrow">Arial Narrow');
    document.write('           <option style="font-family:Arial Black;" value="Arial Black">Arial Black');
    document.write('           <option style="font-family:Arial Unicode MS;" value="Arial Unicode MS">Arial Unicode MS');
    document.write('           <option style="font-family:Batang;" value="Batang">Batang');
    document.write('           <option style="font-family:Book Antiqua;" value="Book Antiqua">Book Antiqua');
    document.write('           <option style="font-family:Bookman Old Style;" value="Bookman Old Style">Bookman Old Style');
    document.write('           <option style="font-family:Century;" value="Century">Century');
    document.write('           <option style="font-family:Century Gothic;" value="Century Gothic">Century Gothic');
    document.write('           <option style="font-family:Comic Sans MS;" value="Comic Sans MS">Comic Sans MS');
    document.write('           <option style="font-family:Courier;" value="Courier">Courier');
    document.write('           <option style="font-family:Fantasy;" value="Fantasy">Fantasy');
    document.write('           <option style="font-family:Fixedsys;" value="Fixedsys">Fixedsys');
    document.write('           <option style="font-family:Garamond;" value="Garamond">Garamond');
    document.write('           <option style="font-family:Haettenschweiler;" value="Haettenschweiler">Haettenschweiler');
    document.write('           <option style="font-family:Impact;" value="Impact">Impact');
    document.write('           <option style="font-family:Lucida Console;" value="Lucida Console">Lucida Console');
    document.write('           <option style="font-family:Lucida Sans Unicode;" value="Lucida Sans Unicode">Lucida Sans Unicode');
    document.write('           <option style="font-family:Microsoft Sans Serif;" value="Microsoft Sans Serif">Microsoft Sans Serif');
    document.write('           <option style="font-family:Monotype Corsiva;" value="Monotype Corsiva">Monotype Corsiva');
    document.write('           <option style="font-family:Monospace;" value="Monospace">Monospace');
    document.write('           <option style="font-family:MT Extra;" value="MT Extra">MT Extra');
    document.write('           <option style="font-family:Palatino Linotype;" value="Palatino Linotype">Palatino Linotype');
    document.write('           <option style="font-family:Roman;" value="Roman">Roman');
    document.write('           <option style="font-family:Script;" value="Script">Script');
    document.write('           <option style="font-family:Small Font;" value="Small Font">Small Font');
    document.write('           <option style="font-family:SimSun;" value="SimSun">SimSun');
    document.write('           <option style="font-family:Symbol;" value="Symbol">Symbol');
    document.write('           <option style="font-family:System;" value="System">System');
    document.write('           <option style="font-family:Tahoma;" value="Tahoma">Tahoma');
    document.write('           <option style="font-family:Terminal;" value="Terminal">Terminal');
    document.write('           <option style="font-family:Times New Roman;" value="Times New Roman">Times New Roman');
    document.write('           <option style="font-family:Trebuchet MS;" value="Trebuchet MS">Trebuchet MS');
    document.write('           <option style="font-family:Verdana;" value="Verdana">Verdana');
    document.write('           <option style="font-family:Wingdings;" value="Wingdings">Wingdings');
   document.writeln('	</select>');
*/
   document.writeln('	<select onchange="formatText(event, \'fontsize\', this.options[this.selectedIndex].value);">');
   document.writeln('		<option value="">[Tama&ntilde;o]</option>');
   document.writeln('		<option value="1">1</option>');
   document.writeln('		<option value="2">2</option>');
   document.writeln('		<option value="3">3</option>');
   document.writeln('		<option value="4">4</option>');
   document.writeln('		<option value="5">5</option>');
   document.writeln('		<option value="6">6</option>');
   document.writeln('		<option value="7">7</option>');
   document.writeln('	</select>');
   document.writeln(    '<img src="../textarea/img/bold.gif" title="Negrilla" onClick="formatText(event,  \'bold\', \'\')">');
   document.writeln(    '<img src="../textarea/img/italic.gif" title="Cursiva" onClick="formatText(event,  \'italic\', \'\')">');
   document.writeln(    '<img src="../textarea/img/underline.gif" title="Subrayado" onClick="formatText(event,  \'underline\', \'\')">');
   document.writeln(    '|');
   document.writeln(    '<img src="../textarea/img/left_just.gif" title="Alineaci&oacute;n Izquierda" onClick="formatText(event,  \'justifyleft\', \'\')">');
   document.writeln(    '<img src="../textarea/img/centre.gif" title="Centrado" onClick="formatText(event,  \'justifycenter\', \'\')">');
   document.writeln(    '<img src="../textarea/img/right_just.gif" title="Alineaci&oacute;n Derecha" onClick="formatText(event,  \'justifyright\', \'\')">');
   document.writeln(    '<img src="../textarea/img/justifyfull.gif" title="Justificar " onclick="formatText(event,  \'justifyfull\', \'\')">');
   document.writeln(    '|');
   document.writeln(    '<img src="../textarea/img/hr.gif" title="L&iacute;nea Horizontal" onClick="formatText(event,  \'inserthorizontalrule\', \'\')">');
   document.writeln(    '|');
   document.writeln(    '<img src="../textarea/img/numbered_list.gif" title="Lista Ordenada" onClick="formatText(event,  \'insertorderedlist\', \'\')">');
   document.writeln(    '<img src="../textarea/img/list.gif" title="Lista Desordenada" onClick="formatText(event,  \'insertunorderedlist\', \'\')">');
   document.writeln(    '|');
   document.writeln(    '<img src="../textarea/img/outdent.gif" title="Outdent" onClick="formatText(event,  \'outdent\', \'\')">');
   document.writeln(    '<img src="../textarea/img/indent.gif" title="Indent" onClick="formatText(event,  \'indent\', \'\')">');
   document.writeln(    '<img src="../textarea/img/textcolor.gif" title="Color de Texto" onClick="formatText(event,  \'forecolor\', \'\')">');
   document.writeln(    '<img src="../textarea/img/bgcolor.gif" title="Color de Fondo" onClick="formatText(event,  \'hilitecolor\', \'\')">');
   document.writeln(    '|');
   document.writeln(    '<img src="../textarea/img/hyperlink.gif" title="Insertar Link" onClick="formatText(event,  \'createlink\')">');
   //document.writeln(    '<img src="../textarea/img/image.gif" title="A&ntilde;adir Imagen" onClick="addImage(event)">');
   document.writeln(    '<img src="../textarea/img/table.gif" title="Insertar Tabla" onClick="insertTable(event)">');
   document.writeln('</span>');
   document.writeln('<span id="rteTableButtons">');
   document.writeln(    '|');
   document.writeln(    '<img src="../textarea/img/coladd.gif" title="A&ntilde;adir una columna" onClick="addTD(event)">');
   document.writeln(    '<img src="../textarea/img/coldel.gif" title="Eliminar una columna" onClick="delTD(event)">');
   document.writeln(    '|');
   document.writeln(    '<img src="../textarea/img/colspan1.gif" title="Incrementar columna" onclick="setColspan(event,1)">');
   document.writeln(    '<img src="../textarea/img/colspan2.gif" title="Decremetar columna" onclick="setColspan(event,-1)">');
   document.writeln(    '<img src="../textarea/img/rowspan1.gif" title="Incrementar fila" onclick="setRowspan(event,1)">');
   document.writeln(    '<img src="../textarea/img/rowspan2.gif" title="Decrementar fila" onclick="setRowspan(event,-1)">');
   document.writeln(    '|');
   document.writeln(    '<img src="../textarea/img/rowadd.gif" title="A&ntilde;adir una fila" onclick="addTR(event)">');
   document.writeln(    '<img src="../textarea/img/rowdel.gif" title="Eliminar una fila" onclick="delTR(event)">');
   document.writeln('</span>');
   document.writeln('<iframe id="rteWin" marginwidth=0 marginheight=0 style="background-color:#ffffff;border:1px inset grey;"></iframe>');
   document.writeln('<iframe id="rteColorWin" marginwidth=0 marginheight=0 width="154" height="104" src="palette.htm" marginwidth="0" marginheight="0" scrolling="no" style="display: none; position: absolute;"></iframe>');
   document.writeln('<textarea id="rteTxt" style="display:none"></textarea>');
  // Link Maligno document.writeln('<a id="__kim" style="font-size:8px;font-weight:bolder;font-family:verdana;float:right;text-decoration:none;" href="http://tech.CityPost.ca">&copy;</a>');
   document.writeln('<select onchange="resizeWin(event, this.value);">');
   document.writeln('		<option value="">Alto del Editor</option>');
   document.writeln('		<option value="100px">100 pixel</option>');
   document.writeln('		<option value="200px">200 pixel</option>');
   document.writeln('		<option value="300px">300 pixel</option>');
   document.writeln('		<option value="400px">400 pixel</option>');
   document.writeln('		<option value="500px">500 pixel</option>');
   document.writeln('		<option value="600px">600 pixel</option>');
   document.writeln('</select>');
   document.writeln('<input type="checkbox" onclick="toggleMode(event);" />Ver C&oacute;digo');
   document.writeln('<span id="rteStatus"></span>');
}