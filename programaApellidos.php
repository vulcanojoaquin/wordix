<?php
include_once("wordix.php");
include_once("cases.php");

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
    echo "ingresa nombre del jugador:  ";
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

/**
 * esta funcion muestra la primer partida ganada
 * @param string $nombre
 * @param array $coleccionPartidas
 * @return array
 */
function primerPartidaGanada($nombre, $coleccionPartidas)
{
    $jugo = false;
    $centinela = 0;
    $posicion = 0;
    $ganador = -1;
    while ($centinela == 0 && $posicion < count($coleccionPartidas)) {
        if ($coleccionPartidas[$posicion]["jugador"] == $nombre) {
            $jugo = true;
            if ($coleccionPartidas[$posicion]["puntaje"] > 0) {
                $ganador = $posicion;
                $centinela = 1;
            }
        }
        $posicion++;
    }
    if ($ganador == -1 && $jugo) {
        $ganador = -2;
    }
    return $ganador;
}

/**
 * Buscar primera partida cargada 
 * @param $nombre string
 * @param $coleccionPartidas array
 * @return array
 */
function buscarPrimeraPartida($nombre, $coleccionPartidas)
{
    $newArray = [];

    foreach ($coleccionPartidas as $partida) {
        if ($partida['jugador'] === $nombre && $partida['puntaje'] > 0) {
            array_push($newArray, $partida);
        }
    }
    if (count($newArray) === 0) {
        $newArray = null;
    }
    return $newArray;
}

/**
 * Función de comparación para ordenar por palabraWordix y, en caso de empate, por jugador
 * @param array $a
 * @param array $b
 * @return 
 **/
function compararPorPalabraYJugador($a, $b)
{
    // Comparar por palabraWordix
    $comparacionPalabra = strcmp($a['jugador'], $b['jugador']);

    // Si las palabras son iguales, comparar por jugador
    if ($comparacionPalabra == 0) {
        $comparacionPalabra = strcmp($a['palabraWordix'], $b['palabraWordix']);
    }

    return $comparacionPalabra;
}


/**
 * funcion para estadisticas del jugador
 * @param string $verClaro;
 * @param string $reset;
 * @param string $nombre;
 * @param array $coleccionPartidasStaticas;
 * @return array
 * 
 */

function estadisticasjugador($nombre, $coleccionPartidasStaticas, $verdeClaro, $reset)
{
    $partidas = 0;
    $victorias = 0;
    $puntajeTotal = 0;
    $adivinadas = ["intento1" => 0, "intento2" => 0, "intento3" => 0, "intento4" => 0, "intento5" => 0, "intento6" => 0];
    foreach ($coleccionPartidasStaticas as $item) {
        if ($item['jugador'] === $nombre) {
            //array_push($partidasJugador,$item);
            $partidas++;
            $puntajeTotal = $puntajeTotal + $item["puntaje"];
            if ($item["intentos"] > 0) {
                $victorias++;
            }
        }
    }
    $porcentajeVictorias = intval(($victorias * 100) / $partidas);

    echo "********************************************\n";
    echo $verdeClaro . "   jugador: $nombre" . $reset . PHP_EOL;
    echo $verdeClaro . "   partidas: $partidas" . $reset . PHP_EOL;
    echo $verdeClaro . "   puntaje total: $puntajeTotal" . $reset . PHP_EOL;
    echo $verdeClaro . "   victorias: $victorias" . $reset . PHP_EOL;
    echo $verdeClaro . "   porcentaje victorias: $porcentajeVictorias %" . $reset . PHP_EOL;
    echo $verdeClaro . "   adivinadas: " . $reset . PHP_EOL;
    print_r($adivinadas);
    echo "********************************************\n";
    // array_push($estadisticas,$nombre);
    // array_push($estadisticas,$partidas);
    // array_push($estadisticas,$puntajeTotal);
    // array_push($estadisticas,$victorias);
    // array_push($estadisticas,$porcentajeVictorias);
    // array_push($estadisticas,$adivinadas);

    // return $estadisticas;


}


/* ****COMPLETAR***** */

/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:
$coleccionPalabras = cargarColeccionPalabras();
$coleccionPartidas = [];

$coleccionPartidasStaticas = [
    ["palabraWordix" => "MUJER", "jugador" => "nahuel", "intentos" => 0, "puntaje" => 0],
    ["palabraWordix" => "QUESO", "jugador" => "mateo", "intentos" => 1, "puntaje" => 14],
    ["palabraWordix" => "VERDES", "jugador" => "joako", "intentos" => 2, "puntaje" => 10],
    ["palabraWordix" => "NAVEZ", "jugador" => "nahuel", "intentos" => 3, "puntaje" => 8],
    ["palabraWordix" => "NAVES", "jugador" => "mateo", "intentos" => 4, "puntaje" => 6],
    ["palabraWordix" => "QUESO", "jugador" => "joako", "intentos" => 5, "puntaje" => 7],
    ["palabraWordix" => "MUJER", "jugador" => "nahuel", "intentos" => 6, "puntaje" => 8],
    ["palabraWordix" => "LINDA", "jugador" => "mateo", "intentos" => 0, "puntaje" => 0],
    ["palabraWordix" => "QUESO", "jugador" => "joako", "intentos" => 0, "puntaje" => 0],
];

//Colores
$rojo = "\033[0;31m";

$verdeMuyClaro = "\033[1;92m";
$verde = "\033[0;32m";
$amarillo = "\033[1;33m";
$celeste = "\033[0;36m";
$violeta = "\033[0;35m";
$naranja = "\033[0;33m";
$reset = "\033[0m";

//Acciones
$exit = false;
//Inicialización de variables:

//Proceso:

//print_r($partida);
//imprimirResultado($partida);
echo "\n";
echo "**             **- WORDIX -**             **\n";


do {
    echo "\n********************************************\n";
    echo "**                  MENU                  **\n";
    echo "********************************************\n";
    echo "1) Jugar al wordix con una palabra elegida \n";
    echo "2) Jugar al wordix con una palabra aleatoria \n";
    echo "3) Mostrar una partida \n";
    echo "4) Mostrar la primer partida ganadora \n";
    echo "5) Mostrar resumen de Jugador \n";
    echo "6) Mostrar listado de partidas ordenadas\n   por jugador y por palabra \n";
    echo "7) Agregar una palabra de 5 letras a Wordix \n";
    echo $amarillo . "8) salir \n" . $reset . PHP_EOL;
    echo "Elegir una opcion: ";
    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case 1:
            echo $naranja . "\n1) Jugar al wordix con una palabra elegida " . $reset . PHP_EOL;
            $len = count($coleccionPalabras) - 1;
            $nombre = solicitarNombre();
            do {
                $res = 'n';
                echo "Ingrese un numero entre 0 y $len:  ";
                $num = trim(fgets(STDIN));
                if ($num < 0 || $num > $len) {
                    echo $rojo . "No existe la palabra" . $reset . PHP_EOL;
                    do {
                        $res = pregunta();
                    } while ($res !== 'n' && $res !== 'y');
                } else {
                    $palabraBuscada = buscarPalabra($num, $coleccionPalabras);
                    echo "\n$palabraBuscada\n";
                    $palabraRepetida = buscarPalabraRepetida($coleccionPartidas, $nombre, $palabraBuscada);
                    if ($palabraRepetida) {
                        echo $rojo . "La palabra ya fue usada por $nombre" . $reset . PHP_EOL;
                        do {
                            $res = pregunta();
                        } while ($res !== 'n' && $res !== 'y');
                    } else {
                        $partida = jugarWordix("$palabraBuscada", strtolower($nombre));
                        array_push($coleccionPartidas, $partida);
                    }
                }
            } while ($res !== "n");
            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;

        case 2:
            echo $naranja . "\n2) Jugar al wordix con una palabra aleatoria " . $reset . PHP_EOL;
            // $arrayPalabras = cargarColeccionPalabras();
            // echo "el array es";
            // print_r($arrayPalabras);
            $nombre = solicitarNombre();
            do {
                $long = count($coleccionPalabras);
                $num = rand(0, $long - 1);
                echo "\n$num\n";
                $palabraBuscada = buscarPalabra($num, $coleccionPalabras);
                echo "$palabraBuscada";
                $palabraRepetida = buscarPalabraRepetida($coleccionPartidas, $nombre, $palabraBuscada);
            } while ($palabraRepetida);
            $partida = jugarWordix("$palabraBuscada", strtolower($nombre));
            array_push($coleccionPartidas, $partida);
           // print_r($coleccionPartidas);
            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;

        case 3:
            echo $verde . "\n3) Mostrar una partida " . $reset . PHP_EOL;
            $long = count($coleccionPartidas);
            if ($long == 0) {
                echo $amarillo . "No hay partidas registradas " . $reset . PHP_EOL;
                echo $celeste . "Presione enter para continuar..." . $reset . PHP_EOL;
                readline();
                break;
            }
            echo "Partidas jugadas: $long\nIngrese un numero de partida: ";
            $num = (solicitarNumeroEntre(1, $long, $amarillo, $reset) - 1);
            datosPartida('partida',$num,$coleccionPartidas);
            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;

        case 4:
            echo $naranja . "\n4) Mostrar la primer partida ganadora " . $reset . PHP_EOL;
            $nombre = solicitarNombre();
            $partidaGanada = primerPartidaGanada($nombre, $coleccionPartidas);
            if ($partidaGanada == -2) {
                echo "No gano ninguna";
            } elseif ($partidaGanada == -1) {
                echo $rojo . "No jugo ninguna partida." . $reset . PHP_EOL;
            } else {
                // print_r($coleccionPartidas[$partidaGanada]);
                datosPartida('ganada',$partidaGanada,$coleccionPartidas);
            }
            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;

        case 5:
            echo $naranja . "\n5) Mostrar resumen de Jugador " . $reset . PHP_EOL;
            $nombre = solicitarNombre();
            $estadisticas = estadisticasjugador($nombre, $coleccionPartidas, $verdeClaro, $reset);
            print_r($estadisticas);

            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;

        case 6:
            echo $naranja . "\nMostrar listado de partidas ordenadas por jugador y por palabra" . $reset . PHP_EOL;
            uasort($coleccionPartidas, 'compararPorPalabraYJugador');
            print_r($coleccionPartidas);

            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;

        case 7:
            echo $naranja . "\n7) Agregar una palabra de 5 letras a Wordix " . $reset . PHP_EOL;
            // $coleccionPalabras = cargarColeccionPalabras();
            do {
                $res = 'y';
                echo "Ingrese una palabra de 5 letras: ";
                $nuevaPalabra = trim(fgets(STDIN));
                $palabraLen = strlen($nuevaPalabra);
                $palabraRepetida = false;
                if ($palabraLen === 5) {
                    $nuevaPalabraMayus = strtoupper($nuevaPalabra);
                    foreach ($coleccionPalabras as $palabra) {
                        if ($palabra === $nuevaPalabraMayus) {
                            $palabraRepetida = true;
                        }
                    }
                    if ($palabraRepetida) {
                        echo $rojo . "La palabra ya existe" . $reset . PHP_EOL;
                        $res = pregunta();
                    } else {
                        // echo $nuevaPalabraMayus;
                        // print_r($coleccionPalabras);
                        array_push($coleccionPalabras, $nuevaPalabraMayus);
                        echo $verde . "Se agrego la palabra $nuevaPalabraMayus para jugar" . $reset . PHP_EOL;
                        $res = 'n';
                    }
                } else {
                    echo $rojo . "La palabra no contiene 5 letras" . $reset . PHP_EOL;
                }
            } while ($res === 'y');

            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;

        case 8:
            echo $amarillo . "\n8) salir" . $reset . PHP_EOL;
            echo ' Quiere cerrar el juego? Y/N  ';
            $res = strtolower(trim(fgets(STDIN)));
            if ($res !== 'n' && $res !== 'y') {
                echo $rojo . "Error al ingresar la respuesta" . $reset . PHP_EOL;
            } elseif ($res === 'y') {
                $exit = true;
                echo $violeta . "Muchas gracias, vuelva pronto!!!" . $reset . PHP_EOL;
            }else{
                echo $verdeClaro . "Bien sigamos jugando" . $reset .PHP_EOL;
            }

            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;
        default:
            echo $rojo . "No existe esa opción" . $reset . PHP_EOL;
            echo $verde . "Vuelva a intentarlo" . $reset . PHP_EOL;
    }
} while ($exit === false);

//presione cualquier letra