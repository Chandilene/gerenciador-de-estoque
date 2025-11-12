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
            // Cria e retorna um objeto Usuario, aplicando POO
            return new Usuario(
                $dados['id_usuario'],
                $dados['usuario'],
                $dados['senha'] // O hash da senha é guardado aqui
            );
        }

        return null;
    }

    /**
     * Tenta realizar o login de um usuário.
     * @param string $nome_usuario O nome de usuário digitado.
     * @param string $senha_digitada A senha em texto puro digitada.
     * @return Usuario|null Retorna o objeto Usuario logado ou null se a autenticação falhar.
     */
    public function login($nome_usuario, $senha_digitada)
    {
        if (empty($nome_usuario) || empty($senha_digitada)) {
            // Se estiver vazio, a lógica de erro do acoes.php vai tratar
            return null;
        }

        // 1. Busca o objeto Usuario (POO)
        $usuario = $this->buscarUsuario($nome_usuario);

        // 2. Verifica se o usuário foi encontrado
        if (!$usuario) {
            return null;
        }

        // 3. Verifica a senha usando o hash encapsulado na classe Usuario
        $hash_do_banco = $usuario->getSenhaHash(); // Usa o getter para acessar a senha

        if (password_verify($senha_digitada, $hash_do_banco)) {
            // Login bem-sucedido
            return $usuario;
        }

        // 4. Falha na verificação da senha
        return null;
    }

    // logica para gerenciar dados do usuario

    public function atualizarCredenciais($id_usuario, $novo_usuario, $senha_atual, $nova_senha)
    {
        // 1. Verificar a senha atual primeiro (segurança máxima)
        $query_check = "SELECT senha FROM usuario WHERE id_usuario = ?";
        $stmt_check = mysqli_prepare($this->conn, $query_check);
        mysqli_stmt_bind_param($stmt_check, "i", $id_usuario);
        mysqli_stmt_execute($stmt_check);
        $resultado_check = mysqli_stmt_get_result($stmt_check);
        $usuario_db = mysqli_fetch_assoc($resultado_check);
        mysqli_stmt_close($stmt_check);

        if (!$usuario_db || !password_verify($senha_atual, $usuario_db['senha'])) {
            return false; // Senha atual incorreta
        }

        // 2. Preparar a atualização
        $campos_update = [];
        $tipos = '';
        $parametros = [];

        // A. Atualizar Nome de Usuário
        if ($_SESSION['usuario'] !== $novo_usuario) {
            $campos_update[] = "usuario = ?";
            $tipos .= 's';
            $parametros[] = $novo_usuario;
        }

        // B. Atualizar Senha (se a nova senha não estiver vazia)
        if (!empty($nova_senha)) {
            $novo_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $campos_update[] = "senha = ?";
            $tipos .= 's';
            $parametros[] = $novo_hash;
        }

        // Se não houver nada para atualizar além da senha atual, encerra
        if (empty($campos_update)) {
            return true;
        }

        $query = "UPDATE usuario SET " . implode(', ', $campos_update) . " WHERE id_usuario = ?";
        $tipos .= 'i';
        $parametros[] = $id_usuario;

        $stmt = mysqli_prepare($this->conn, $query);

        // Bind dos parâmetros dinamicamente
        mysqli_stmt_bind_param($stmt, $tipos, ...$parametros);

        $sucesso = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $sucesso;
    }
}
