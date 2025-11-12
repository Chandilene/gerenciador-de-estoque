<?php

class Usuario
{
    private $id;
    private $usuario;
    private $senha_hash;

    public function __construct($id, $usuario, $senha_hash)
    {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->senha_hash = $senha_hash;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function getSenhaHash()
    {
        return $this->senha_hash;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
}
