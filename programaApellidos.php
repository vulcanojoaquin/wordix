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
 * Funcion para mostrar el menu principal
 * @param string $amarillo
 * @param string $reset
 */
function mostrarMenu($amarillo, $reset) //establece el puntero interno de un array a su primer elemento.
{
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
}


/**
 * Funcion para cargar una colección de palabras
 * @return array
 */
function cargarColeccionPalabras()
{
    $coleccionPalabras = [
        "MUJER", "QUESO","FUEGO", "CASAS", "RASGO",
        "GATOS", "GOTAS", "HUEVO", "TINTO", "NAVES",
        "VERDE", "MELON", "YUYOS", "PIANO", "PISOS",
        "HOJAS", "FIDEO", "AUDIO", "AUTOS", "MOTOS",
    ];
    return ($coleccionPalabras);
}


/**
 * Funcion para cargar partidas
 * @return array
 */
function cargarColeccionPartidasStaticas()
{
    $coleccionPartidas = [
        ["palabraWordix" => "VERDE", "jugador" => "nahuel", "intentos" => 0, "puntaje" => 0],
        ["palabraWordix" => "QUESO", "jugador" => "mateo", "intentos" => 1, "puntaje" => 15],
        ["palabraWordix" => "TINTO", "jugador" => "joako", "intentos" => 2, "puntaje" => 16],
        ["palabraWordix" => "FUEGO", "jugador" => "nahuel", "intentos" => 3, "puntaje" => 11],
        ["palabraWordix" => "NAVES", "jugador" => "mateo", "intentos" => 4, "puntaje" => 14],
        ["palabraWordix" => "AUDIO", "jugador" => "joako", "intentos" => 5, "puntaje" => 8],
        ["palabraWordix" => "PIANO", "jugador" => "nahuel", "intentos" => 6, "puntaje" => 10],
        ["palabraWordix" => "MOTOS", "jugador" => "mateo", "intentos" => 0, "puntaje" => 0],
        ["palabraWordix" => "MELON", "jugador" => "joako", "intentos" => 2, "puntaje" => 14],
        ["palabraWordix" => "MUJER", "jugador" => "joako", "intentos" => 0, "puntaje" => 0],
    ];
    return $coleccionPartidas;
}


/**
 * Funcion para buscar a la palabra segun el numero que eligio el usuario
 * @param  array $arrayPalabras
 * @param  int $numPalabra
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
//isset determina si una variable esta declarada y es diferente de nula.

/**
 * busca la partida de algun jugador
 * @param array $coleccionPartidas
 */
function buscarPartidasDeUnJugador($coleccionPartidas, $nombre)
{
    $partidasDelJugador = [];
    foreach ($coleccionPartidas as $partida) {
        if ($partida['jugador'] === $nombre) {
            array_push($partidasDelJugador, $partida);
        }
    }
    return $partidasDelJugador;
}


/**
 * Funcion para volver a preguntar si quiere seguir con la misma accion
 * @return string $resMenor
 */
function pregunta()
{
    $rojo = "\033[0;31m";
    $reset = "\033[0m";
    do {
        echo "Quiere intentar otra vez? (Y/N): ";
        $respuesta = trim(fgets(STDIN));
        $resMenor = strtolower($respuesta);
        if ($resMenor !== "n" && $resMenor !== "y") {
            echo $rojo . "respuesta incorrecta\n" . $reset . PHP_EOL;
        }
    } while ($resMenor !== 'y' && $resMenor !== 'n');

    return $resMenor;
}


/**
 * Funcion que busca si el jugador ya uso la palabra elegida
 * @param array $partidasDelJugador
 * @param string $rojo
 * @param  string $reset
 * @param string $palabraBuscada
 * @return boolean
 */
function buscarPalabraRepetida($partidasDelJugador, $palabraBuscada, $rojo, $reset,$case)
{
    $existe = false;
    foreach ($partidasDelJugador as $items) {
        if ($items['palabraWordix'] === $palabraBuscada) {
            if($case === 1){
                echo $rojo . "Ya jugo esa palabra" . $reset . PHP_EOL;
            }
            $existe = true;
        }
    }
    return $existe;
}
//foreach presenta los elementos en el orden q fueron agregados.


/**
 * Funcion para mostrar datos de una partida 
 * @param int $num;
 * @param array $coleccionPartidas; 
 */
function datosPartida($tipo, $num, $coleccionPartidas)
{
    $reset = "\033[0m";
    $verde = "\033[0;32m";
    $verdeClaro = "\033[1;32m";
    if ($tipo === 'partida') {
        $numPartida = $num + 1;
    }
    $palabraWordix = $coleccionPartidas[$num]['palabraWordix'];
    $jugador = $coleccionPartidas[$num]['jugador'];
    $intentos = $coleccionPartidas[$num]['intentos'];
    $puntaje = $coleccionPartidas[$num]['puntaje'];
    // print_r($coleccionPartidas[$num]);
    if ($tipo === 'partida') {
        echo $verde . "\n   PARTIDA $numPartida" . $reset . PHP_EOL;
    } else {
        echo $verde . "\n   PRIMERA PARTIDA GANADA" . $reset . PHP_EOL;
    }
    echo $verdeClaro . "   [palabraWordix]: $palabraWordix \n";
    echo "   [jugador]: $jugador \n";
    echo "   [intentos]: $intentos \n";
    echo "   [puntaje]: $puntaje " . $reset . PHP_EOL;
};


/**
 * Funcion para buscar y mostrar una partida de un jugador.
 * @param int $cantidadDePartidas
 * @param array $coleccionPartidas
 * @param string $amarillo
 * @param string $celeste
 * @param string $reset
 */
function  mostrarUnaPartida($cantidadDePartidas, $coleccionPartidas, $amarillo, $celeste, $reset)
{
    if ($cantidadDePartidas == 0) {
        echo $amarillo . "No hay partidas registradas " . $reset . PHP_EOL;
        echo $celeste . "Presione enter para continuar..." . $reset . PHP_EOL;
        readline();
    } else {
        echo "Partidas jugadas: $cantidadDePartidas\nIngrese un numero de partida: ";
        $numeroPartida = (solicitarNumeroEntre(1, $cantidadDePartidas, $amarillo, $reset) - 1);
        datosPartida('partida', $numeroPartida, $coleccionPartidas);
        echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
        readline();
    }
}


/**
 * Funcion para ingresar y validar un nombre
 * @return string
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
//ctype_alpha se fija q sea caracteres alfabeticos y no numeros.


/**
 * Funcion que muestra la primera partida ganada.
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
//count cuenta todos los elementos de un arreglo o objeto contable.


/**
 * Función de comparación para ordenar por jugador y, en caso de empate, por palabraWordix.
 * @param array $a
 * @param array $b
 * @return 
 **/
function compararPorPalabraYJugador($a, $b)
{
    // Comparar por jugador
    $comparacionPalabra = strcmp($a['jugador'], $b['jugador']);
    // Si las palabras son iguales, comparar por palabraWordix
    if ($comparacionPalabra == 0) {
        $comparacionPalabra = strcmp($a['palabraWordix'], $b['palabraWordix']);
    }
    return $comparacionPalabra;
}
//strcmp comparacion de mayusculas y minusculas.


/**
 * Funcion para mostrar las partidas ordenadas.
 * @param array $coleccionPartidas;
 * @param string $verdeClaro; 
 * @param string $reset;
 */
function mostrarPartidasOrdenadas($coleccionPartidas, $verdeClaro, $reset)
{
    foreach ($coleccionPartidas as $partida) {
        $jugador = $partida['jugador'];
        $palabraWordix = $partida['palabraWordix'];
        $intentos = $partida['intentos'];
        $puntaje = $partida['puntaje'];
        echo $verdeClaro . "   [jugador]: $jugador\n";
        echo "   [palabraWordix]: $palabraWordix\n";
        echo "   [intentos]: $intentos\n";
        echo "   [puntaje]: $puntaje\n" . $reset . PHP_EOL;
    }
}


/**
 * funcion para mostrar estadisticas del jugador
 * @param string $verdeClaro;
 * @param string $reset;
 * @param string $nombre;
 * @param array $coleccionPartidas;
 * @return array
 * 
 */
function estadisticasjugador($nombre, $coleccionPartidas, $verdeClaro, $reset)
{
    $partidas = 0;
    $victorias = 0;
    $puntajeTotal = 0;
    $adivinadas = ["intento1" => 0, "intento2" => 0, "intento3" => 0, "intento4" => 0, "intento5" => 0, "intento6" => 0];
    foreach ($coleccionPartidas as $item) {
        if ($item['jugador'] === $nombre) {
            $partidas++;
            $puntajeTotal = $puntajeTotal + $item["puntaje"];
            if ($item["intentos"] > 0) {
                switch ($item["intentos"]) {
                    case 1:
                        $adivinadas["intento1"]++;
                        break;
                    case 2:
                        $adivinadas["intento2"]++;
                        break;
                    case 3:
                        $adivinadas["intento3"]++;
                        break;
                    case 4:
                        $adivinadas["intento4"]++;
                        break;
                    case 5:
                        $adivinadas["intento5"]++;
                        break;
                    case 6:
                        $adivinadas["intento6"]++;
                        break;
                    default:
                        echo 'No existe el intento';
                        break;
                }
                $victorias++;
            }
        }
    }
    $porcentajeVictorias = intval(($victorias * 100) / $partidas);
    echo PHP_EOL . $verdeClaro . "   jugador: $nombre \n";
    echo "   partidas: $partidas \n";
    echo "   puntaje total: $puntajeTotal \n";
    echo "   victorias: $victorias \n";
    echo "   porcentaje victorias: $porcentajeVictorias % \n";
    echo "   adivinadas: \n";
    echo "      Intentos 1: $adivinadas[intento1]\n";
    echo "      Intentos 2: $adivinadas[intento2]\n";
    echo "      Intentos 3: $adivinadas[intento3]\n";
    echo "      Intentos 4: $adivinadas[intento4]\n";
    echo "      Intentos 5: $adivinadas[intento5]\n";
    echo "      Intentos 6: $adivinadas[intento6] " . $reset . PHP_EOL;
}


/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables: 
//string $nombre,$respuesta,$palabraBuscada, $amarillo, $reset, $naranja, $rojo, $celeste, $verde, $verdeClaro, $violeta
//int $opcion, $cantidadPalabras,$mostrarCantidadPalabras, $numeroPalabra,$cantidadPartidas,
//boolean $palabraRepetida, $exit
//array $partida, $coleccionPartidas, $coleccionPalabras
$coleccionPalabras = cargarColeccionPalabras();
$coleccionPartidas = cargarColeccionPartidasStaticas();

//Inicialización de variables:
//Colores
$rojo = "\033[0;31m";
$verde = "\033[0;32m";
$verdeClaro = "\033[1;32m";
$amarillo = "\033[1;33m";
$celeste = "\033[0;36m";
$violeta = "\033[0;35m";
$naranja = "\033[0;33m";
$reset = "\033[0m";
//Acciones
$exit = false;

echo "\n";
echo "**             **- WORDIX -**             **\n";
    
do {
    mostrarMenu($amarillo, $reset);
    $opcion = trim(fgets(STDIN));
    //switch se ulitiza como un if(estructura alternativa)
    switch ($opcion) {
        case 1:
            echo $naranja . "\n1) Jugar al wordix con una palabra elegida " . $reset . PHP_EOL;
            $cantidadPalabras = count($coleccionPalabras);
            $mostrarCantidadPalabras = $cantidadPalabras - 1;
            $nombre = solicitarNombre();
            $partidasDelJugador = buscarPartidasDeUnJugador($coleccionPartidas, $nombre);
            $cantidadPartidas = count($partidasDelJugador);
            if ($cantidadPartidas === $cantidadPalabras) {
                echo $rojo . "$nombre ya jugo toda las palabras" . $reset . PHP_EOL;
            } else {
                $respuesta = 'n';
                do {
                    echo "Ingrese un numero de partida entre 0 y $mostrarCantidadPalabras: ";
                    $numeroPalabra = solicitarNumeroEntre(0, $cantidadPalabras, $amarillo, $reset);
                    $palabraBuscada = buscarPalabra($numeroPalabra, $coleccionPalabras);

                    $palabraRepetida = buscarPalabraRepetida($partidasDelJugador, $palabraBuscada, $rojo, $reset,1);
                    if ($palabraRepetida) {
                        $respuesta = pregunta();
                    } else {
                        $partida = jugarWordix($palabraBuscada, strtolower($nombre)); //strtolower letras minuscula
                        array_push($coleccionPartidas, $partida); //array push agregar elementos a lo ultimo del array
                    }
                } while ($respuesta !== 'n');
            }
            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline(); //espera una entrada del teclado
            break;

        case 2:
            echo $naranja . "\n2) Jugar al wordix con una palabra aleatoria " . $reset . PHP_EOL;
            $nombre = solicitarNombre();
            $cantidadPalabras = count($coleccionPalabras);
            $partidasDelJugador = buscarPartidasDeUnJugador($coleccionPartidas, $nombre);
            $cantidadPartidas = count($partidasDelJugador);
            if($cantidadPartidas === $cantidadPalabras){
                echo $rojo . "$nombre ya jugo toda las palabras" . $reset . PHP_EOL;
            } else {
            do {
                $numeroPalabra = rand(0, $cantidadPalabras - 1); //rand numero random
                $palabraBuscada = buscarPalabra($numeroPalabra, $coleccionPalabras);    
                $palabraRepetida = buscarPalabraRepetida($partidasDelJugador, $palabraBuscada, $rojo, $reset,2);
            } while ($palabraRepetida);
            $partida = jugarWordix("$palabraBuscada", strtolower($nombre));
            array_push($coleccionPartidas, $partida);
            }
            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;

        case 3:
            echo $verde . "\n3) Mostrar una partida " . $reset . PHP_EOL;
            $cantidadDePartidas = count($coleccionPartidas);
            mostrarUnaPartida($cantidadDePartidas, $coleccionPartidas, $amarillo, $celeste, $reset);
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
                datosPartida('ganada', $partidaGanada, $coleccionPartidas);
            }
            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;

        case 5:
            echo $naranja . "\n5) Mostrar resumen de Jugador " . $reset . PHP_EOL;
            $nombre = solicitarNombre();
            $partidasDelJugador = buscarPartidasDeUnJugador($coleccionPartidas, $nombre);
            $cantidadPartidas = count($partidasDelJugador);
            if ($cantidadPartidas === 0) {
                echo $rojo . "El jugador no jugo ninguna partida." . $reset . "\n";
            } else {
                $estadisticas = estadisticasjugador($nombre, $coleccionPartidas, $verdeClaro, $reset);
                print_r($estadisticas);
            }
            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;

        case 6:
            echo $naranja . "\nMostrar listado de partidas ordenadas por jugador y por palabra\n" . $reset . PHP_EOL;
            uasort($coleccionPartidas, 'compararPorPalabraYJugador'); //ordena alfabeticamente o numericamente arreglo
            mostrarPartidasOrdenadas($coleccionPartidas, $verdeClaro, $reset);
            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;

        case 7:
            echo $naranja . "\n7) Agregar una palabra de 5 letras a Wordix " . $reset . PHP_EOL;
            do {
                $res = 'n';
                $palabraRepetida = false;
                $palabra = leerPalabra5Letras();
                foreach ($coleccionPalabras as $item) {
                    if ($palabra === $item) {
                        $palabraRepetida = true;
                    }
                }
                if ($palabraRepetida === false) {
                    array_push($coleccionPalabras, $palabra);
                    echo $verde . "Se agrego la palabra $palabra para jugar" . $reset . PHP_EOL;
                } else {
                    echo $rojo . "La palabra ya existe" . $reset . PHP_EOL;
                    $res = pregunta();
                }
            } while ($palabraRepetida !== false && $res !== 'n');
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
            } else {
                echo $verdeClaro . "Bien sigamos jugando" . $reset . PHP_EOL;
            }
            echo $celeste . "\nPresione enter para continuar..." . $reset . PHP_EOL;
            readline();
            break;
        default: //se utiliza para ejecutar el codigo cuando la opcion no es uno de los case.
            echo $rojo . "No existe esa opción" . $reset . PHP_EOL;
            echo $verde . "Vuelva a intentarlo" . $reset . PHP_EOL;
            break;
    }
} while ($exit === false);
