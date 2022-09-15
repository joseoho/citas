function tree(type){
  switch (type){
    case 1:
       if (document.getElementById("submenuone").style.display == "none"){
          document.getElementById("submenuone").style.display = "block";
       	  document.getElementById("imgelmat").src="menu_tee_minus.jpg";
		}else{
      	  document.getElementById("submenuone").style.display = "none";
	   	 document.getElementById("imgelmat").src="menu_tee_plus.jpg";
    }
    break;
    case 2: 
       if (document.getElementById("submenutwo").style.display == "none"){
          document.getElementById("submenutwo").style.display = "block";
          document.getElementById("imgestadistica").src="menu_tee_minus.jpg";
 	}
        else{
          document.getElementById("submenutwo").style.display = "none";
	   	  document.getElementById("imgestadistica").src="menu_tee_plus.jpg";
        }
    break;
    case 3: 
       if (document.getElementById("submenuthree").style.display == "none"){
       document.getElementById("submenuthree").style.display = "block";
          document.getElementById("imgfinanciamiento").src="menu_tee_plus.jpg";
	}
        else if (document.getElementById("submenuthree").style.display = "none"){
           document.getElementById("imgfinanciamiento").src="menu_tee_minus.jpg";
                 
	}
    break;
    case 4: 
       if (document.getElementById("submenufour").style.display == "none"){
          document.getElementById("submenufour").style.display = "block";
       	  document.getElementById("imgmercadeo").src="menu_tee_minus.jpg";
	}
        else{
          document.getElementById("submenufour").style.display = "none";
          document.getElementById("imgmercadeo").src="menu_tee_plus.jpg";	
	}
    break;
    case 5: 
       if (document.getElementById("submenufive").style.display == "none"){
          document.getElementById("submenufive").style.display = "block";
          document.getElementById("imgjuntas").src="menu_tee_minus.jpg";
	}
        else{
         document.getElementById("submenufive").style.display = "none";
         document.getElementById("imgjuntas").src="menu_tee_plus.jpg";
	 }
    break;
    case 6: 
       if (document.getElementById("submenusix").style.display == "none"){
          document.getElementById("submenusix").style.display = "block";
       	  document.getElementById("imgsistema").src="menu_tee_minus.jpg";
	}
        else{
          document.getElementById("submenusix").style.display = "none";
          document.getElementById("imgsistema").src="menu_tee_plus.jpg";
	}
    break;
  } 
}


function subnav(option){
   var arr1= new Array("noticias", "encuestas", "banners", "usuarios");	
   var arr2 = new Array("subnav1","subnav2","subnav3","subnav4");
   i = 0;
   for(i; i<arr1.length;i++){
	string = arr2[i];
	if(option == arr1[i]){
	 document.getElementById(string).style.visibility="visible";
  	}else{
  	 document.getElementById(string).style.visibility="hidden";
 	}
    }
 }
 
 function poll(){
  	n = parseInt(document.getElementById("sltOptions").value);
  	if(n!=5){
  		i= n+1;
  		for(i;i<=5;i++){ 		
  			document.getElementById(""+i).style.visibility="hidden"; 
  		}
  	}else{
  		for(i=1;i<=5;i++){
  			document.getElementById(""+i).style.visibility="visible";
  		}
  	}
 	document.getElementById("shadow").value="" + n;
 }

//Script para rotacion de banners
//set image paths
src = ["imagenes/banners/sasa.gif", "imagenes/banners/inti.gif", "imagenes/banners/insapesca.gif", "imagenes/banners/pan.gif", "imagenes/banners/inder.gif", "imagenes/banners/fondafa.gif", "imagenes/banners/planimara.gif", "imagenes/banners/cva.gif"]

//set corresponding urls
url = ["?modulo=organismos&accion=9", "?modulo=organismos&accion=6", "?modulo=organismos&accion=4", "?modulo=organismos&accion=7", "?modulo=organismos&accion=5", "?modulo=organismos&accion=3", "?modulo=organismos&accion=8", "?modulo=organismos&accion=2"]

//set duration for each image
duration = 2;

//Please do not edit below
ads=[]; ct=0;
function switchAd() {
var n=(ct+1)%src.length;
if (ads[n] && (ads[n].complete || ads[n].complete==null)) {
document["Ad_Image"].src = ads[ct=n].src;
}
ads[n=(ct+1)%src.length] = new Image;
ads[n].src = src[n];
setTimeout("switchAd()",duration*1000);
}
function doLink(){
escrolea()
location.href = url[ct];
} onload = function(){
if (document.images)
switchAd();
escrolea();
}

function ventanaSecundaria (URL){
window.open(URL,"ventana1","width=820, height=600, scrollbars=yes, menubar=no, location=no, resizable=no")
} 
function vs (URL){
window.open(URL,"ventana1","width=800, height=600, scrollbars=no, menubar=no, location=no, resizable=no")
} 

function vss (URL){
window.open(URL,"ventana1","width=800, height=600, scrollbars=yes, menubar=no, location=no, resizable=no")
} 