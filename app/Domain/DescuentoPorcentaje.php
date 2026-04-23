<?php
namespace App\Domain;

use App\Domain\Descuento;
use App\Domain\Exceptions\PorcentajeInvalidoException;

class DescuentoPorcentaje implements Descuento{

    private float $porcentaje;

    public function __construct(float $porcentaje){
        $this->validarPorcentaje($porcentaje);
        $this->porcentaje = $porcentaje;
    }

    public function aplicar(ItemCarrito $item): float
    {
        $precioTotal = $item->precioBaseTotal();
        $calcularDescuento = $this->porcentaje/100;
        return $precioTotal*$calcularDescuento;
    }

    public function validarPorcentaje(float $porcentaje):void{
        if($porcentaje < 0 && $porcentaje >=100){
            throw new PorcentajeInvalidoException(
                "el porcentaje debe ser mayor a 0 
                y menor a 100"); 
        }
    }
    
}