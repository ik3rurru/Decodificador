<?php

// Función para decodificar un valor de una base personalizada a un valor decimal
function decodeCustomBase($value, $baseDigits) {
    // Determinamos la base (número de caracteres en $baseDigits)
    $base = strlen($baseDigits);
    // Inicializamos el valor decimal acumulado
    $decimalValue = 0;

    // Recorremos cada carácter en el valor codificado
    for ($i = 0; $i < strlen($value); $i++) {
        $char = $value[$i];                 // Tomamos el carácter actual
        $pos = strpos($baseDigits, $char);   // Buscamos su posición en $baseDigits

        // Si el carácter no se encuentra en $baseDigits, lanzamos una excepción
        if ($pos === false) {
            throw new Exception("Caracter '$char' no encontrado en la base '$baseDigits'");
        }

        // Calculamos el nuevo valor decimal sumando el valor del carácter actual
        // (Multiplicamos el valor acumulado por la base y sumamos la posición del carácter)
        $decimalValue = $decimalValue * $base + $pos;
    }

    // Devolvemos el valor decimal resultante
    return $decimalValue;
}

// Datos que simulan las líneas de un archivo CSV con usuarios y puntuaciones codificadas
$data = [
    ["Patata", "oi8", "oo"],               // Entrada 1: usuario "Patata" con base personalizada "oi8" y puntuación "oo"
    ["ElMejor", "oF8", "oF8"],             // Entrada 2: usuario "ElMejor" con base "oF8" y puntuación "oF8"
    ["BoLiTa", "0123456789", "23"],        // Entrada 3: base numérica (base 10)
    ["Azul", "01", "01100"],               // Entrada 4: base binaria "01"
    ["OtRo", "54?t", "?4?"],               // Entrada 5: base "54?t"
    ["Manolita", "kju2aq", "u2ka"],        // Entrada 6: base "kju2aq"
    ["PiMiEnTo", "_-/.!#", "#_"]           // Entrada 7: base "_-/.!#"
];

// Array para almacenar las puntuaciones decodificadas
$decodedScores = [];

// Procesamos cada entrada del array de datos
foreach ($data as $entry) {
    // Descomponemos cada entrada en sus respectivas variables
    list($user, $baseDigits, $encodedScore) = $entry;

    try {
        // Intentamos decodificar la puntuación usando la función decodeCustomBase
        $decodedScore = decodeCustomBase($encodedScore, $baseDigits);
        // Guardamos el resultado en $decodedScores con el nombre de usuario como clave
        $decodedScores[$user] = $decodedScore;
    } catch (Exception $e) {
        // En caso de error, mostramos un mensaje indicando el usuario y el error
        echo "Error al decodificar la puntuación de $user: " . $e->getMessage() . "\n";
    }
}

// Mostramos los resultados decodificados para cada usuario
foreach ($decodedScores as $user => $score) {
    echo "$user: $score\n";   // Imprimimos el nombre del usuario y su puntuación decodificada
}

?>
