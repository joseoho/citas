//Funcion para validar que solo se introduzcan numeros
function justnumber(forma,cadena)
{
//***************************************************
// Valida que los datos introducidos sean caracteres
// numéricos. Recibe el nombre de la forma(forma), 
// y el nombre del textbox(cadena).
//***************************************************
	var contents;
	contents=document[forma][cadena].value;
	if(contents!=0)
		{if (((contents / contents) != 1)) 
			{alert('Introduzca sólo números en este campo.');
			 document[forma][cadena].focus();
			 document[forma][cadena].select(); 	 
			 return(false);}
		else
		{return(true);}
		}
	else
		{return(true);}
}

//Funcion para validar email 
function validarEmail11(valor,mensaje,postab) {
	tam=valor.value.length;
	valor2=valor.value;
	pos1=valor2.indexOf('@');
	valor3=valor2.substr(pos1+1,valor2.length);
	pos2=valor3.indexOf('@');
	pos3=valor2.indexOf('.');
	valor3=valor2.substr(pos3+1,valor2.length);
	pos4=valor3.indexOf('.');
	if (tam>0 &&  (((pos1<-1 || pos3<1)) ||  (!(pos1>0 && pos2<0 || pos3>0 && pos4<1) ))) {
			mostrarerror('La dirección de email de '+mensaje+' es incorrecta.',valor,postab);
			return false;
	}
	return true;
}

function emailValido(theElement, nombre_del_elemento )
{
var s = theElement.value;
var filter=/^[A-Za-z][A-Za-z0-9_]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
if (s.length == 0 ) return true;
if (filter.test(s))
return true;
else
alert("Ingrese una dirección de correo válida");
theElement.focus();
return false;
}

function validarEmail(valor) {
if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(valor)){
alert("La dirección de email " + valor + " es correcta.") 
return (true)
} else {
alert("La dirección de email es incorrecta.");
return (false);
}
}


///Funcion que cambia a mayusculas los campos de los formularios
function cambiaMayuscula(forma,cadena){
	  document[forma][cadena].value=document[forma][cadena].value.toUpperCase();
}

//Funcion para validar campos vacios en la creacion de usuario
function pageValidateCrearUsuario(){
        if(document.crearInstalacion.co_campo.value=="null")
        {
            alert('Debe Selecionar un Campo');
            document.crearInstalacion.co_campo.focus();
            return false;
        }else
        if(document.crearInstalacion.cod_inst.value=="")
        {
            alert('Debe Ingresar el Código de la Instalación');
            document.crearInstalacion.cod_inst.focus();
            return false;
        }else
        if(document.crearInstalacion.inst.value=="")
        {
            alert('Debe Ingresar el Nombre de la Instalación');
            document.crearInstalacion.inst.focus();
            return false;
        }
		else
	if (confirm('¿Esta seguro de enviar esta información?')){
	  // document.crearInstalacion.submit();
    } 
}

//*********************************************************************************
// Function que valida que un campo contenga un string y no solamente un " "
// Es tipico que al validar un string se diga
//    if(campo == "") ? alert(Error)
// Si el campo contiene " " entonces la validacion anterior no funciona
//*********************************************************************************

//busca caracteres que no sean espacio en blanco en una cadena
function vacio(q) {
        for ( i = 0; i < q.length; i++ ) {
                if ( q.charAt(i) != " " ) {
                        return true
                }
        }
        return false
}








function validaFloat(value){
	return(value.match(/^[0-9]+(,[0-9]+)*$/))
}

function validaInputFloat(oInput){
	if (! validaFloat(oInput.value) )	
	{
		alert(oInput.value + " no es un número válido!");
		try
		{
			ed.focus();
			ed.select();				
		}catch(ex){
		   /*me "como" la excepción porque se producirá 
		     en caso de que al control no se le pueda
		     pasar el foco
		   */
		}
		return(false);
	}
	return(true);
}

function validar(f, check) {
var valida = false;
var arrayCheck = f[check];
for (i = 0, total = arrayCheck.length; i < total; i ++) valida = (valida || arrayCheck[i].checked);
if (!valida) alert('no hay marcas');
return valida;
}

function validaAnaliza(F) {
        if( vacio(F.obs.value) == false ) {
                alert("Debe ingresar la observacion.")
                return false
        }
}


