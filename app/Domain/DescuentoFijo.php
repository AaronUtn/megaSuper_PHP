<?php
namespace App\Domain;

use App\Domain\Exceptions\DescuentoFijoInvalidoException;

class DescuentoFijo implements Descuento{

private float $valorADescontar;

    public function __construct(float $valor){
        $this->validarDescuentoFijo($valor);
        $this->valorADescontar = $valor;
    }

    public function aplicar(ItemCarrito $item): float
    {
        return $this->valorADescontar;
    }

    public function validarDescuentoFijo(float $valor):void{
        if($valor < 0){
            throw new DescuentoFijoInvalidoException(
                "el vlor de descuento fijo debe ser mayor a 0"
            );
        }
    }
}