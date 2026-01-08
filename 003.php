<?php

/*voy a crear un programa que analice una frase: 
para ello pondré todo en minúscula, limpiaré todos los símbolos, usaré el "explode" para separar por espacios
ignoraré palabras con menos de 3 letras, contaré ocurrencias con "array_count_values"
filtraré las que se repitan y encontraré la palabra más repetida*/

declare(strict_types=1);

$texto = "PHP no está muerto...  solo sigue trabajando silenciosamente en el 80% de Internet";

echo "=== Analizador de texto ===\n\n";
echo "Texto original: \n{$texto}\n\n";

// primero paso todo a minúsculas para contar las palabras sin distinguir mayúsculas o minúsculas
$textoMin = strtolower($texto);

/* limpio el texto: reemplazo signos de puntuación por espacios
 usaré una expresión "preg_place" que es una regular expression; sirve para buscar texto, reemplazar texto, validar texto o limpiar texto (en nuestro caso reemplazar)
 busca en el texto todo lo que coincida con un patrón y cámbialo por otra cosa - es lo que le digo al código
 ^ es negación; \p{L} se refiere a cualquier letra de la A-Z; \p{N} se refiere a cualquier número
 \s se refiere a cualquier espacio; estoy diciendo, cualquier caracter que no sea letra, número o espacio 
 /u añade tildes, la ñ y caracteres especiales; ' ' es literalmente el reemplazo (un espacio)  y $textoMin es dónde lo busco
 finalmente, las regex usan delimitadores // que indican el principio y el final de la expresión*/
$textoLimpio = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $textoMin);

//ahora quito espacios duplicados con la función trim() y recorto extremos
$textoLimpio = preg_replace('/\s+/u', ' ', trim($textoLimpio));

// convierto el texto limpio en un array de palabras separándolas por espacios
// === comparación estricta; ? es para condición; si $textoLimpio está vacío, $palabras será un array vacío "[]"
// si no está vacío [] entonces : (la condición es falsa) explode(' ', $textolimpio), rompe el texto en trozos usando el separador ' ' y devuelve un array
$palabras = ($textoLimpio === '') ? [] : explode(' ', $textoLimpio);

// filtro palabras con menos de 3 letras
//array_values reindexa un array, deja los índices como  0, 1, 2; elimina los huecos en los índices y deja una numeración continua desde 0
//array_filter(array, función) recorre un array y se queda con los elementos que cumplan una condición, si la función devuelve true se queda, si devuelve falsa se descarta

$palabrasFiltradas = array_values(array_filter($palabras, function ($p) {
    // mb_strlen cuenta con tildes y ñ
    //es una condición, si es true la palabra se queda, si es false, se elimina
    return mb_strlen($p, 'UTF-8') >= 3;
}));

// cuento cuántas palabras quedan después del filtrado
$totalPalabras = count($palabrasFiltradas);

// y ahora cuántas veces aparece cada palabra
// el resultado será un array tipo ["php" => 1, "internet" => 1, ...]
$frecuencias = array_count_values($palabrasFiltradas);

// ahora solo me quedo con las palabras repetidas, es decir frecuencia > 1
// actúa como un foreach ($frecuencias as $n) 
$repetidas = array_filter($frecuencias, function($n) {
    return $n > 1;
});

//busco la palabra más repetida recorriendo el array de fruencias
$palabraMasRepetida = null;
$max = 0;

foreach ($frecuencias as $palabra => $n) {
    if ($n > $max) {
        $max = $n;
        $palabraMasRepetida = $palabra;
    }
}

// muestro los resultados
echo "Texto en minúsculas: {$textoMin}\n\n";
echo "Total de palabras (>= 3 letras): {$totalPalabras}\n\n";

echo "Frecuencias (>= 3 letras):\n";
foreach ($frecuencias as $palabra => $n) {
    echo "- {$palabra}: {$n}\n";
}

echo "\nPalabras repetidas (más de 1 vez):\n";
if (count($repetidas) === 0) {
    echo "Ninguna.\n";
} else {
    foreach ($repetidas as $palabra => $n) {
        echo "- {$palabra}: {$n}\n";
    }
}

echo "\nPalabra más repetida:\n";
if ($palabraMasRepetida === null) {
    echo "No hay palabras para analizar.\n";
} else {
    echo  "{$palabraMasRepetida} ({$max})\n";
}