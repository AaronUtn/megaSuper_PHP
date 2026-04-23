<?
namespace App\Domain;

use App\Domain\Producto;
use App\Domain\Exceptions\CantidadInvalidaException;
use App\Domain\Descuento;

class ItemCarrito{
    private Producto $producto;
    private int $cantidad;
    private array $descuentos;

    public function __construct(Producto $unProducto, int $unaCantidad)
    {
        $this->validarCantidad($unaCantidad);
        $this->producto = $unProducto;
        $this->cantidad = $unaCantidad;
        $this->descuentos = [];
    }

    private function validarCantidad(int $cantidad): void{
        if($cantidad <= 0){
            throw new CantidadInvalidaException(
                "la cantidad debe ser mayor a 0");
        }
    }

    public function agregarDescuento(Descuento $descuento):void{
        $this->descuentos[] = $descuento;
    }

    public function getProducto(): Producto{
        return $this->producto;
    }

    public function getCantidad(): int{
        return $this->cantidad;
    }

    public function precioBaseTotal(): float{
        return $this->producto->precioBase()*$this->cantidad;
    }

    public function precioFinal():float{
        $precioFinal = array_reduce(
            $this->descuentos,
            fn($acum,$desc) =>
                $acum -$desc->aplicar($this)
            ,$this->precioBaseTotal()

        );

        return max(0,$precioFinal);
    }

    public function mostrar(): string{
        return 
            "Producto:"
            .$this->producto->nombreProducto()
            ." | Cantidad: "
            .$this->cantidad
            ." | Precio final: "
            .$this->precioFinal();
    }

    
}