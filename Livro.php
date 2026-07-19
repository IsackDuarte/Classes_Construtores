<?php

class Livro{
    public string $titulo;
    public string $autor;
    public int $ano;

    public function __construct(string $titulo,string $autor,int $ano)
    {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->ano = $ano;
    }
}
    $livro1 = new Livro("Como fazer PIZZA "," Dom Ramon ", 2015);
    echo $livro1 ->titulo;
    echo $livro1 ->autor;
    echo $livro1 ->ano;
