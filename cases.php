<?php

//COLORES
$rojo = "\033[0;31m";
$verdeClaro = "\033[1;32m";
$verdeMuyClaro = "\033[1;92m";
$verde = "\033[0;32m";
$amarillo = "\033[1;33m";
$celeste = "\033[0;36m";
$violeta = "\033[0;35m";
$naranja = "\033[0;33m";
$reset = "\033[0m";

/**
 * Funcion para volver a preguntar si quiere seguir con la misma accion
 * @return string $resMay
 */
function pregunta()
{
    $rojo = "\033[0;31m";
    $reset = "\033[0m";
    echo "Quiere intentar otra vez? (Y/N): ";
    $res = trim(fgets(STDIN));
    $resMen = strtolower($res);
    if ($resMen !== "n" && $resMen !== "y") {
        echo $rojo . "respuesta incorrecta\n" . $reset . PHP_EOL;
    }
    return $resMen;
}

/**
 * Funcion para mostrar datos de una partida 
 * @param int $num;
 * @param array $coleccionPartidas; 
 */
function datosPartida($tipo,$num, $coleccionPartidas)
{
    $reset = "\033[0m";
    $verde = "\033[0;32m";
    $verdeClaro = "\033[1;32m";
    if($tipo === 'partida'){
        $numPartida = $num + 1;
    }
    $palabraWordix = $coleccionPartidas[$num]['palabraWordix'];
    $jugador = $coleccionPartidas[$num]['jugador'];
    $intentos = $coleccionPartidas[$num]['intentos'];
    $puntaje = $coleccionPartidas[$num]['puntaje'];
    // print_r($coleccionPartidas[$num]);
    if($tipo === 'partida'){
        echo $verde . "\n   PARTIDA $numPartida" . $reset . PHP_EOL;
    }else{
        echo $verde . "\n   PRIMERA PARTIDA GANADA" . $reset . PHP_EOL;
    }
    echo $verdeClaro . "   [palabraWordix]: $palabraWordix" . $reset . PHP_EOL;
    echo $verdeClaro . "   [jugador]: $jugador" . $reset . PHP_EOL;
    echo $verdeClaro . "   [intentos]: $intentos" . $reset . PHP_EOL;
    echo $verdeClaro . "   [puntaje]: $puntaje" . $reset . PHP_EOL;
};
