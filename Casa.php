<?php

class Casa{
    public string $cor;
    public int $numeroDeQuarto;
    public int $numeroDeBanheiro;
    

    public function __construct($cor,$numeroDeBanheiro,$numeroDeQuarto){
        $this->cor = $cor;
        $this->numeroDeBanheiro = $numeroDeBanheiro;
        $this->numeroDeQuarto = $numeroDeQuarto;
    }
}
    $casa1 = new Casa ("Azul",2,1);
    echo ("Cor da casa: $casa1->cor, Nr de banheiro: $casa1->numeroDeBanheiro,  Nr de Quarto: $casa1->numeroDeQuarto."); 