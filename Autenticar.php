<?php
require 'connection.php';
require 'Usuario.php';
class Autenticar
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    private function buscarUsuario($nome_usuario)
    {
        // Usa prepared statements para prevenir SQL Injection
        $query = "SELECT id_usuario, usuario, senha FROM usuario WHERE usuario = ?";

        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $nome_usuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $dados = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);

        if ($dados) {
          
            return new Usuario(
                $dados['id_usuario'],
                $dados['usuario'],
                $dados['senha'] 
            );
        }

        return null;
    }

    /**
     * @param string $nome_usuario .
     * @param string $senha_digitada 
     * @return Usuario|null 
     */
    public function login($nome_usuario, $senha_digitada)
    {
        if (empty($nome_usuario) || empty($senha_digitada)) {
            return null;
        }

        $usuario = $this->buscarUsuario($nome_usuario);

        if (!$usuario) {
            return null;
        }

        $hash_do_banco = $usuario->getSenhaHash(); 

        if (password_verify($senha_digitada, $hash_do_banco)) {
            
            return $usuario;
        }

        return null;
    }


    public function atualizarCredenciais($id_usuario, $novo_usuario, $senha_atual, $nova_senha)
    {
        $query_check = "SELECT senha FROM usuario WHERE id_usuario = ?";
        $stmt_check = mysqli_prepare($this->conn, $query_check);
        mysqli_stmt_bind_param($stmt_check, "i", $id_usuario);
        mysqli_stmt_execute($stmt_check);
        $resultado_check = mysqli_stmt_get_result($stmt_check);
        $usuario_db = mysqli_fetch_assoc($resultado_check);
        mysqli_stmt_close($stmt_check);

        if (!$usuario_db || !password_verify($senha_atual, $usuario_db['senha'])) {
            return false; 
        }

        $campos_update = [];
        $tipos = '';
        $parametros = [];

        if ($_SESSION['usuario'] !== $novo_usuario) {
            $campos_update[] = "usuario = ?";
            $tipos .= 's';
            $parametros[] = $novo_usuario;
        }

        if (!empty($nova_senha)) {
            $novo_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $campos_update[] = "senha = ?";
            $tipos .= 's';
            $parametros[] = $novo_hash;
        }

        if (empty($campos_update)) {
            return true;
        }

        $query = "UPDATE usuario SET " . implode(', ', $campos_update) . " WHERE id_usuario = ?";
        $tipos .= 'i';
        $parametros[] = $id_usuario;

        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, $tipos, ...$parametros);

        $sucesso = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $sucesso;
    }
}
