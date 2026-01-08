<?php
declare(strict_types=1);

//carrito: lista de productos. Cada producto es un array con 3 campos
$carrito = [
    ["producto" => "Portátil", "precio" => 1200, "cantidad" => 1],
    ["producto" => "Ratón", "precio" => 25, "cantidad" => 2],
    ["producto" => "Teclado", "precio" => 45, "cantidad" => 1],
];

/*Primero calculo el total sin descuento de todo el carrito
Uso una función para separar el cálculo de la presentación
$carrito es el dato que entra en la función y no es el mismo que está fuera de la función, no cambia el $carrito de fuera
Además con float pido que me devuelva un número decimal*/
function calcularTotal(array $carrito): float {
    $total = 0.0; //0.0 porque hablamos de dinero y usamos decimales

    foreach ($carrito as $item) {

        //convierto a tipos correctos float e int, para que php no lo cambie por error
        $precio = (float)$item["precio"];
        $cantidad = (int)$item["cantidad"];

        //sumo el subtotal de cada producto al total
        //con += coge lo que ya había y le suma lo siguiente
        $total += $precio * $cantidad;
    }

    return $total;
}

echo "=== Carrito de compras ===\n\n";

//muestro cada producto son su subtotal
//para cada elemento que hay dentro de $carrito lo llamo $item y se ejecuta el código
foreach ($carrito as $item) {
    $producto = (string)$item["producto"];
    $precio = (float)$item["precio"];
    $cantidad = (int)$item["cantidad"];

    //subtotal = precio unitario * cantidad
    $subtotal = $precio * $cantidad;

    echo "Producto: {$producto}\n";
    echo "Precio unitari: " . number_format($precio, 2) . " €\n";
    echo "Cantidad: {$cantidad}\n";
    echo "Subtotal: " . number_format($subtotal, 2) . " €\n";
    echo "--------------------------\n";
}

//total sin descuentos usando la función
$totalSinDescuento = 0.0;

if ($totalSinDescuento > 1000) {
    $portcentajeDescuento = 0.10; // 10%
} else if ($totalSinDescuento > 500) {
    $portcentajeDescuento = 0.5; // 5%
} // si no cumple ninguna de las dos, se queda en 0.0

//ahora calculo cuánto dinero se descuenta y el total final
$importeDescuento = $totalSinDescuento * $portcentajeDescuento;
$totalFinal = $totalSinDescuento - $importeDescuento;

echo "\n=== Totales ===\n";
echo "Total sin descuento: " . number_format($totalSinDescuento, 2) . " €\n";
echo "Descuento aplicado: " . number_format($portcentajeDescuento * 100, 0) . "% (" . numberformat($importeDescuento, 2) . " €)\n";
echo "Total final: " . number_format($totalFinal, 2) . " €\n";