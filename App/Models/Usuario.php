<?php

namespace App\Models;
use MF\Model\Model;

class Usuario extends Model
{
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __get($atributo)
    {
        return $this->$atributo;
    }
    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    // Método para salvar um Novo Usuário no Banco de Dados
    public function salvar()
    {
        $query = "
            INSERT INTO usuarios(
                nome,
                email,
                senha
            ) VALUES (
                :nome,
                :email,
                :senha
            )
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nome", $this->__get("nome"));
        $stmt->bindValue(":email", $this->__get("email"));
        $stmt->bindValue(":senha", $this->__get("senha"));
        $stmt->execute();

        return $this;
    }

    // Método para validar se os dados estão corretos para cadastro
    public function validarCadastro()
    {
        $valido = true;

        if (strlen($this->__get("nome")) < 3) {
            $valido = false;
        }
        if (strlen($this->__get("email")) < 3) {
            $valido = false;
        }
        if (strlen($this->__get("senha")) < 3) {
            $valido = false;
        }

        return $valido;
    }

    // Método para verificar se o e-mail informado já não está cadastrado
    public function getUsuarioPorEmail()
    {
        $query = "SELECT nome, email FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":email", $this->__get("email"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}