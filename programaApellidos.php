<?php
include_once("wordix.php");



/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/

/* Apellido, Nombre. Legajo. Carrera. mail. Usuario Github */
/* ****ALDAY MATTEO,FAI-4557,TUDW,MATTEO.ALDAY@EST.FI.UNCOMA.EDU.AR,Aldaymatteo***** */
/* **** CHAMORRO NAHUEL,FAI-5035,TUDW,nahuel.chamorro@est.fi.uncoma.edu.ar,nahucham18***** */
/* **** Joaquin Dal dosso,FAI-4926,TUDW,joaquin.daldosso@est.fi.uncoma.edu.ar,vulcanojoaquin***** */


/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/


/**
 * Obtiene una colección de palabras
 * @return array
 */
function cargarColeccionPalabras()
{
    $coleccionPalabras = [
        "MUJER", "QUESO", "FUEGO", "CASAS", "RASGO",
        "GATOS", "GOTAS", "HUEVO", "TINTO", "NAVES",
        "VERDE", "MELON", "YUYOS", "PIANO", "PISOS",
        /* Agregar 5 palabras más */
    ];

    return ($coleccionPalabras);
}

/**
 * Buscar a la palabra segun el numero que eligio el usuario
 * @param $arrayPalabras array
 * @param $numPalabra int
 * @return string
 */
function buscarPalabra($numPalabra, $arrayPalabras)
{
    if (isset($arrayPalabras[$numPalabra])) {
        return $arrayPalabras[$numPalabra];
    } else {
        return "No existe esa palabra";
    }
}

/**
 * Busca si el jugador ya uso la palabra elegida
 * @param $coleccionPartidas array
 * @param $nombre string
 * @param $palabra string
 * @return boolean
 */
function buscarPalabraRepetida($coleccionPartidas, $nombre, $palabra)
{
    $existe = false;
    foreach ($coleccionPartidas as $item) {
        if ($item['jugador'] === $nombre && $item['palabraWordix'] === $palabra) {
            $existe = true;
            break;
        }
    }
    return $existe;
}


/**
 * ingresar nombre
 * @return string
 * 
 */

function solicitarNombre()
{
    echo "ingresa nombre del jugador";
    $nombre = trim(fgets(STDIN));


    while (($nombre === "") || ($nombre === null)) {
        echo "Debe ingresar algo";
        $nombre = trim(fgets(STDIN));
    }

    while (!ctype_alpha($nombre[0])) {

        echo "ingrese un nombre";
        $nombre = trim(fgets(STDIN));
        if (($nombre === "") || ($nombre === null)) {
            $nombre = 1;
        }
    }

    return strtolower($nombre);
}






/* ****COMPLETAR***** */



/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:

$coleccionPartidas = [];

//Inicialización de variables:


//Proceso:

//print_r($partida);
//imprimirResultado($partida);


do {
    echo "\n";
    echo '1) Jugar al wordix con una palabra elegida ';
    echo "\n";
    echo '2) Jugar al wordix con una palabra aleatoria ';
    echo "\n";
    echo '3) Mostrar una partida ';
    echo "\n";
    echo '4) Mostrar la primer partida ganadora ';
    echo "\n";
    echo '5) Mostrar resumen de Jugador ';
    echo "\n";
    echo '6) Mostrar listado de partidas ordenadas por jugador y por palabra ';
    echo "\n";
    echo '7) Agregar una palabra de 5 letras a Wordix ';
    echo "\n";
    echo '8) salir';
    echo "\n";
    echo "Elegir una opcion:";
    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case 0:

            break;
        case 1:
            $arrayPalabras = cargarColeccionPalabras();
            // echo "el array es";
            // print_r($arrayPalabras);

            $nombre = solicitarNombre();
            do {
                echo "Ingrese un numero entre 0 y 5";
                $num = trim(fgets(STDIN));
                $palabraBuscada = buscarPalabra($num, $arrayPalabras);
                echo "\n";
                echo "$palabraBuscada";
                echo "\n";
                $palabraRepetida = buscarPalabraRepetida($coleccionPartidas, $nombre, $palabraBuscada);
                if ($palabraRepetida) {
                    echo "La palabra ya fue usada por $nombre";
                }
            } while ($palabraRepetida === true);

            $partida = jugarWordix("$palabraBuscada", strtolower($nombre));
            array_push($coleccionPartidas, $partida);
            // print_r($coleccionPartidas);
            // $numPalabra = solicitarNumeroEntre($min, $max);
            break;
        case 2:
            $arrayPalabras = cargarColeccionPalabras();
            // echo "el array es";
            // print_r($arrayPalabras);

            $nombre = solicitarNombre();
            do {
                $long = count($arrayPalabras);
                $num = rand(0, $long);

                echo "\n";
                echo "$num";
                echo "\n";
                $palabraBuscada = buscarPalabra($num, $arrayPalabras);
                echo "$palabraBuscada";
                $palabraRepetida = buscarPalabraRepetida($coleccionPartidas, $nombre, $palabraBuscada);
            } while ($palabraRepetida);



            $partida = jugarWordix("$palabraBuscada", strtolower($nombre));

            array_push($coleccionPartidas, $partida);
            print_r($coleccionPartidas);


            break;
        case 3:

            $long = count($coleccionPartidas);
            if ($long == 0) {
                echo "no hay partidas registradas \n";
                echo "enter para continuar";
                trim(fgets(STDIN));
                break;
            }

            $aux = $long - 1;
            echo "numero de partidas: $long\n ";
            echo "ingrese un numero de partida:";
            // $num=trim(fgets(STDIN));
            $num = solicitarNumeroEntre(1, $long);
            print_r($coleccionPartidas[$num - 1]);


            /*if ($num>$long || $num<0) {
                echo "no existe esa partida";
            }
            else{
                print_r($coleccionPartidas [$num-1]);
            }*/
            break;
        case 4:
            $ganoElIntento = esIntentoGanado($arregloDeIntentosWordix[$indiceIntento]);
            $nroIntento = 0;
            if ($ganoElIntento) {
                $nroIntento++;
            }

            echo "hola";
            echo "chamorro gato";

        case 8:
            echo ' Quiere cerrar el juego? Y/N';
            $resp = trim(fgets(STDIN));
            if ($resp === 'n') {
                $opcion = 0;
            } else $opcion = 8;
            break;
    }
} while ($opcion !== 8);
