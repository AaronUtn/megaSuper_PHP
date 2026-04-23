<?php
namespace App\Domain;

use App\Domain\Producto;
use App\Domain\Categoria;

class Carrito{
    private array $itemsCarrito;
    private float $precioTotal;
    private float $precioSinDescuento;

    public function __construct(){
        $this->itemsCarrito = [];
        $this->precioTotal =0;
        $this->precioSinDescuento = 0;

    }

    public function agregarItem(ItemCarrito $item):void{
        $this->itemsCarrito[] = $item;
    }

    public function mostrarItems():void{
        foreach($this->itemsCarrito as $item){
            echo $item->mostrar() . PHP_EOL;
        }
    }


    /**
     * 
     * productoMasCaro
     * caso donde no tiene item entonces comparacion > 0 es false
     * masCaro = null
     * --
     * caso donde tiene item entoces comparacion > 0 es true
     * entra a la funcion ternaria donde usamos el reduce
     * reduce max es la respuesta comienza con el item 0 de la lista
     * compara con el segundo ternearia it precioBaseTotal > max precioBaseTotal 
     * si item es mas caro reemplaza el valorde max
     * si item es menos caro sigue quedandose con max
     * 
     */

    public function productoMasCaro():Producto {
     $productoMasCaro = count($this->itemsCarrito) >0 ?
        array_reduce(
            $this->itemsCarrito,
            fn($max,$item) =>
                $item->precioFinal() > $max->precioFinal 
                ? $item : $max, $this->itemsCarrito[0]
        ):null;

    return $productoMasCaro;

    }

    public function buscarPorCategoria(Categoria $categoria): array{
        return array_filter($this->itemsCarrito,
        fn ($item) =>
            $item->getProducto()->categoria() === $categoria
        );
    }

    public function obtenerProductosConPrecioMenorA(float $monto): array
    {
        return array_filter($this->itemsCarrito,
        fn($item) => 
            $item->precioFinal()<$monto);
    }


    /**
     * usort() sirve para ordenar un array 
     * de objetos o cosas complejas usando una regla que vos definís.
     * fn($a,$b)
     * -1 $a va antes que $b
     * 0 son iguales
     * 1 $a va despues que $b
     * esto se obtiene usando <=> spaceship operator
     * en este caso usa ordena de menor a mayor
     */
    public function ordenarItemCarrito(): array{
        $ordenados = $this->itemsCarrito;

        usort($ordenados, fn($itemA,$itemB) =>
            $itemA->precioFinal() <=> $itemB->precioFinal()
        );

        return $ordenados;
    }
    

}