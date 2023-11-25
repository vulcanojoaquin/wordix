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
