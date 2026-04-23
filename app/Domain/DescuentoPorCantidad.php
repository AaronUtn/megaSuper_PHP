<?php

namespace App\Domain;

use App\Domain\Exceptions\ValorALlevarInvalidoException;
use App\Domain\Exceptions\ValorAPagarInvalidoException;


class DescuentoPorCantidad implements Descuento{

    private int $cantidadALlevar;
    private int $cantidadAPagar;

    public function __construct(int $cantLlevar,int $cantPagar)
    {
        $this->validarCantidadALlevar($cantLlevar);
        $this->validarCantidadAPagar($cantPagar);
        $this->cantidadALlevar=$cantLlevar;
        $this->cantidadAPagar=$cantPagar;   
    }

    public function aplicar(ItemCarrito $item): float
    {   
        $productosGratis = floor($item->getCantidad()/$this->cantidadALlevar);
        $descuentoObtenido = $productosGratis*$item->getProducto()->precioBase();
        return $descuentoObtenido;
    }

    public function validarCantidadALlevar(int $valor):void{
        if($valor <= 0){
            throw new ValorALlevarInvalidoException("
            el valor tiene que ser mayor a 0");
        }
    }

    public function validarCantidadAPagar(int $valor):void{
        if($valor <= 0){
            throw new ValorAPagarInvalidoException("
            el valor tien que ser mayor a 0");
        }
    }

    
}