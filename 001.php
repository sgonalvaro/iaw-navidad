<?php
/* PHP es muy permisivo con algunas cosas, usamos declare(strict_types=1)
para evitar bugs en producción, detectar errores antes, hace el código más predecible
y además facilita el mantenimiento 
Evita que el lenguaje realice conversiones automáticas de tipos al pasar argumentos a funciones*/
declare(strict_types=1);

/*La clave es el nombre del estudiante y el valor [x, y, z] es un array de notas*/
$estudiantes = [
    "Ana" => [8, 7, 9],
    "Luis" => [5, 6, 4],
    "María" => [10, 9, 10],
    "Carlos" => [6, 6, 6]
];

/*Esta función calcula el promedio de un array de notas 
Uso una función para no tener que repetir la fórmula con cada estudiante y que el código sea más limpio*/
function calcularPromedio(array $notas): float {
    // Si no hubiera notas, evito dividir entre 0, que daría error
    if (count($notas) === 0) {
        return 0.0;
    }

    //array_sum suma todas las notas. count cuenta cuántas notas hay
    // el promedio = suma / cantidad
    return array_sum($notas) / count($notas);
}


//variables que uso para contar el número de aprobados y suspendidos
$aprobados = 0;
$suspendidos = 0;

//variables para recordar el mejor promedio encontrado
//uso "" para guardar un nombre (string)
//uso -1 ya que 0 es un promedio válido
$mejorEstudiante = "";
$mejorPromedio = -1;


//uso \n para hacer un salto de página
echo "=== Gestor de notas ===\n\n";


//con el foreach recorremos todos los estudiantes de la variable
foreach ($estudiantes as $nombre => $notas) {
    
    //calculo el promedio usando otra función
    $promedio = calcularPromedio($notas);

    //se decide el estado según la condición que da el enunciado
    //usamos la siguiente estructura (condición) ? valor_si_verdadero : valor_si_falso ===> es como un if / else
    $estado = ($promedio >= 6) ? "Aprobado" : "Suspenso";

    //aquí muestro los datos del estudiante
    echo "Estudiante: {$nombre}\n";
    echo "Notas: " . implode(", ", $notas) . "\n"; //el . permite concatenar textos
    //implode es una función que convierte un array en texto, separa en función de lo que le des, en mi caso coma y espacio
    echo "Promedio: " . number_format($promedio, 2) . "\n"; // 2 se refiere a la cantidad de decimales
    echo "Estado: {$estado}\n";
    echo "-----------------------\n";



    if ($promedio >= 6) {
        $aprobados++; // ++ es el operador de incremento (suma 1 al valor actual)
    } else {
        $suspendidos++;
    }

    // para comprobar si este estudiante tiene el mejor promedio hasta ahora
    if ($promedio > $mejorPromedio) {
        $mejorPromedio = $promedio;
        $mejorEstudiante = $nombre;
    }
}

// imprime el resumen final
echo "\n=== Resumen ===\n";
echo "Aprobados: {$aprobados}\n";
echo "Suspendidos: {$suspendidos}\n";
echo "Mejor promedio: {$mejorEstudiante} (" . number_format($mejorPromedio, 2) . ")\n";