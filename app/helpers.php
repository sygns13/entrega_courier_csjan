<?php

function validaFecha($fecha){
    $valores = explode('-', $fecha);
    if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0]) && strlen($fecha)==10){
        return true;

    }
    //var_dump($valores);
    return false;

}

function nombremes($mes){
	setlocale(LC_TIME, 'spanish');
	$nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000));
	return $nombre;
  }

function getFecha(){
	$date = Carbon\Carbon::now();
	$date = $date->format('d-m-Y');
	return $date;
}


function hoy()
{
	$date = Carbon\Carbon::now();
	$mes=nombremes($date->format('m'));
	$dia=$date->format('d');
	$anio=$date->format('Y');
	return ''.$dia.' de '.strtolower($mes).' '.$anio;
}

function accesoUser($array=[])
	{
		foreach ($array as $key) {
			if ($key==Auth::user()->tipo_user_id) {
				return true;
			}
		}
		return false;
	}




function pasFechaBD($fecha)
{	
	$fechadev="";
	if(strlen($fecha)==10)
	{
	$fechadev=substr($fecha, -4).'-'.substr($fecha, -7,2).'-'.substr($fecha, -10,2);
	}
	return $fechadev;
}

function pasFechaVista($fecha)
{	
	$fechadev="";
	if(strlen($fecha)==10)
	{
	$fechadev=substr($fecha, -2).'/'.substr($fecha, -5,2).'/'.substr($fecha, -10,4);
	}
	return $fechadev;
}

function genero($sexo)
{
	$genero="";
	if($sexo=="F")
	{
		$genero="FEMENINO";
	}
	elseif($sexo=="M")
	{
		$genero="MASCULINO";
	}

	return $genero;
}

function estadoCivil($ecivil,$sexo)
{
	$result="";
	if(intval($ecivil)==0 && $sexo=="M")
	{
		$result="SIN DATOS";
	}elseif(intval($ecivil)==1 && $sexo=="M")
	{
		$result="SOLTERO";
	}elseif(intval($ecivil)==2 && $sexo=="M")
	{
		$result="CASADO";
	}elseif(intval($ecivil)==3 && $sexo=="M")
	{
		$result="VIUDO";
	}elseif(intval($ecivil)==4 && $sexo=="M")
	{
		$result="DIVORCIADO";
	}

	if(intval($ecivil)==0 && $sexo=="F")
	{
		$result="SIN DATOS";
	}elseif(intval($ecivil==1) && $sexo=="F")
	{
		$result="SOLTERA";
	}elseif(intval($ecivil)==2 && $sexo=="F")
	{
		$result="CASADA";
	}elseif(intval($ecivil)==3 && $sexo=="F")
	{
		$result="VIUDA";
	}elseif(intval($ecivil)==4 && $sexo=="F")
	{
		$result="DIVORCIADA";
	}

	return $result;
}


function esDiscpacitado($var)
{
    $result="";
    if(intval($var)==0)
    {
        $result="No";
    }else if(intval($var)==1)
    {
        $result="Si";
    }
    return $result;
}

function maximoGrado($var)
{
    $result="";
    if(intval($var)==0)
    {
        $result="Sin Grado";
    }else
    {
        $result=$var;
    }
    return $result;
}

function cargoGeneral($var)
{
    $result="";
    if(intval($var)==0)
    {
        $result="Ninguno";
    }else
    {
        $result=$var;
    }
    return $result;
}

function modalidadEstudios($var)
{
    $result="";
    if(intval($var)==1)
    {
        $result="Presencial";
    }else if(intval($var)==2)
    {
        $result="Semipresencial";
    }else if(intval($var)==3)
    {
        $result="Virtual";
    }
    return $result;
}


function tipoDoc($var)
{
    $result="";
    if(intval($var)==1)
    {
        $result="DNI";
    }else if(intval($var)==2)
    {
        $result="RUC";
    }else if(intval($var)==3)
    {
        $result="Carnet de Extranjería";
    }else if(intval($var)==4)
    {
        $result="Pasaporte";
    }else if(intval($var)==5)
    {
        $result="Partida de Nacimiento";
    }
    return $result;
}


function estadoIngreso($var)
{
    $result="";
    if(intval($var)==0)
    {
        $result="No Ingresó";
    }else if(intval($var)==1)
    {
        $result="Ingresó";
    }
    return $result;
}

function gestionColegio($var)
{
    $result="";
    if(intval($var)==1)
    {
        $result="Público";
    }else if(intval($var)==2)
    {
        $result="Privado";
    }
    return $result;
}

function SiUnoNoCero($var)
{
    $result="";
    if(intval($var)==1)
    {
        $result="Si";
    }else if(intval($var)==0)
    {
        $result="No";
    }
    return $result;
}

function grado($var)
{
    $result="";
    if(intval($var)==3)
    {
        $result="Maestría";
    }else if(intval($var)==4)
    {
        $result="Doctorado";
    }
    return $result;
}

function estadoInvestigacion($var)
{
    $result="";
    if(intval($var)==0)
    {
        $result="Finalizado";
    }else if(intval($var)==1)
    {
        $result="En Ejecución";
    }else if(intval($var)==2)
    {
        $result="Cancelado";
    }
    return $result;
}


function tipoDependenciaAdmin($var)
{
    $result="";
    if(intval($var)==0)
    {
        $result="Unidad orgánica";
    }else if(intval($var)==1)
    {
        $result="Dirección general";
    }else if(intval($var)==2)
    {
        $result="Consejo asesor";
    }else if(intval($var)==3)
    {
        $result="Unidad académica";
    }else if(intval($var)==4)
    {
        $result="Unidad de investigación";
    }else if(intval($var)==5)
    {
        $result="Unidad de formación continua";
    }else if(intval($var)==6)
    {
        $result="Área de administración";
    }else if(intval($var)==7)
    {
        $result="Área de calidad o secretaria académica";
    }else if(intval($var)==8)
    {
        $result="Unidad de bienestar y empleabilidad";
    }else if(intval($var)==9)
    {
        $result="Facultad";
    }else if(intval($var)==10)
    {
        $result="Escuela profesional";
    }
    return $result;
}


function gradoAdmin($var)
{
    $result="";
    if(intval($var)==0)
    {
        $result="Sin grado";
    }else if(intval($var)==1)
    {
        $result="Primaria completa";
    }else if(intval($var)==2)
    {
        $result="Secundaria completa";
    }else if(intval($var)==3)
    {
        $result="Técnico";
    }else if(intval($var)==4)
    {
        $result="Bachiller";
    }else if(intval($var)==5)
    {
        $result="Maestro";
    }else if(intval($var)==6)
    {
        $result="Doctor";
    }
    return $result;
}



function estadoContrato($var)
{
    $result="";
    if(intval($var)==0)
    {
        $result="Finalizado";
    }else if(intval($var)==1)
    {
        $result="Activo";
    }
    return $result;
}


function tipoMedico($var)
{
    $result="";
    if(intval($var)==1)
    {
        $result="Médico";
    }else if(intval($var)==2)
    {
        $result="Participante";
    }else if(intval($var)==3)
    {
        $result="Voluntario";
    }
    return $result;
}

function tipoBeneficiario($var)
{
    $result="";
    if(intval($var)==1)
    {
        $result="Alumno";
    }else if(intval($var)==2)
    {
        $result="Docente";
    }else if(intval($var)==3)
    {
        $result="Personal Administrativo";
    }
    return $result;
}

function tipoBeneficiariosPlural($var)
{
    $result="";
    if(intval($var)==1)
    {
        $result="Alumnos";
    }else if(intval($var)==2)
    {
        $result="Docentes";
    }else if(intval($var)==3)
    {
        $result="Personales Administrativos";
    }
    return $result;
}

function tipoProyecto($var)
{
    $result="";
    if(intval($var)==1)
    {
        $result="Proyecto";
    }else if(intval($var)==2)
    {
        $result="Campaña Itinerante";
    }
    return $result;
}


function estadoConvenio($var)
{
    $result="";
    if(intval($var)==1)
    {
        $result="Vigente";
    }else if(intval($var)==0)
    {
        $result="Finalizado";
    }
    return $result;
}


function activoInactivo($var)
{
    $result="";
    if(intval($var)==1)
    {
        $result="ACTIVO";
    }else if(intval($var)==0)
    {
        $result="INACTIVO";
    }
    return $result;
}

function estadoServicio($var)
{
    $result="";
    if(intval($var)==1)
    {
        $result="SIN CORTE";
    }else if(intval($var)==0)
    {
        $result="CON CORTE";
    }
    return $result;
}



function tipoPersonaLlegaPasantia($var)
{
    $result="";
    if(intval($var)==4)
    {
        $result="Alumno";
    }else if(intval($var)==5)
    {
        $result="Docente";
    }else if(intval($var)==6)
    {
        $result="Personal Administrativo";
    }

    return $result;
}

function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                            
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                            
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO CON $xdecimales/100 ";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN SOL CON $xdecimales/100 ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " CON $xdecimales/100 "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}

// END FUNCTION
  



function is_valid_email($str)
{
  $matches = null;
  return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $str, $matches));
}