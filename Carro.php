<?php

class Carro{
    public string $cor;
    public string $modelo;
    public string $numeroDeBancos;

    public function __construct($cor,$modelo,$numeroDeBancos) {
        $this->cor = $cor;
        $this->modelo = $modelo;
        $this->numeroDeBancos = $numeroDeBancos;
    } 
}
    $car1 = new Carro("Vermelho","Uno",5);
    echo $car1->cor . "\n";
    echo $car1->modelo . "\n";
    echo $car1->numeroDeBancos . "\n";