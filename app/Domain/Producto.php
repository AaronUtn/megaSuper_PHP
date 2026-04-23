<?php
namespace App\Domain;


use App\Domain\Categoria;
use App\Domain\Exceptions\PrecioInvalidoException;
use App\Domain\Exceptions\NombreInvalidoException;



class Producto{
    private String $nombre;
    private float $precioBase;
    private Categoria $categoria;

    public function __construct(String $nombre, Categoria $categoria, float $precioBase)
    {
        $this->validarPrecio($precioBase);
        $this->validarNombre($nombre);
        $this->precioBase = $precioBase;
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        
    }

    private function validarPrecio(float $precio): void{
        if($precio <= 0){
            throw new PrecioInvalidoException(
                "Precio invalido debe ser mayor a 0");
        }
    }

    private function validarNombre(String $nombre): void{
        if($nombre === null or trim($nombre)===" "){
            throw new NombreInvalidoException(
                'Nombre invalido'
            );
        }
    }

    public function cambiarPrecio(float $nuevoPrecio): void{
        $this->validarPrecio($nuevoPrecio);
        $this->precioBase = $nuevoPrecio;
    }

    public function precioBase(): float{
        return $this->precioBase;
    }

    public function nombreProducto(): String{
        return $this->nombre;
    }

    public function categoria(): Categoria {
        return $this->categoria;
    }
}