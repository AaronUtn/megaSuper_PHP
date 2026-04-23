<?php

namespace App\Domain;

use App\Domain\ItemCarrito;

interface Descuento{
    public function aplicar(ItemCarrito $item
    ): float;
}