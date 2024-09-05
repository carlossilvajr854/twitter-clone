<?php

namespace App\Models;
use MF\Model\Model;
use PDO;

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

    public function autenticar()
    {
        $query = "
            SELECT
                id, nome, email
            FROM
                usuarios
            WHERE
                email = :email AND senha = :senha
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":email", $this->__get("email"));
        $stmt->bindValue(":senha", $this->__get("senha"));
        $stmt->execute();
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!empty($usuario["id"]) && !empty($usuario["nome"])) {
            $this->__set("id", $usuario["id"]);
            $this->__set("nome", $usuario["nome"]);
        }

        return $this;
    }

    public function getAll()
    {
        $query = "
            SELECT 
                u.id, 
                u.nome, 
                u.email,
                (
                    SELECT 
                        COUNT(*) 
                    FROM 
                        usuarios_seguidores AS us 
                    WHERE 
                        id_usuario = :id_usuario AND id_usuario_seguindo = u.id
                ) AS seguindo_sn
            FROM 
                usuarios AS u
            WHERE 
                u.nome LIKE :nome AND u.id != :id_usuario
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nome", "%" . $this->__get("nome") . "%");
        $stmt->bindValue(":id_usuario", $this->__get("id"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getInfoUsuario()
    {
        $query = "SELECT nome FROM usuarios WHERE id = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get("id"));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTotalTweets()
    {
        $query = "SELECT count(*) AS total_tweets FROM tweets WHERE id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get("id"));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTotalSeguindo()
    {
        $query = "SELECT count(*) AS total_seguindo FROM usuarios_seguidores WHERE id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get("id"));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTotalSeguidores()
    {
        $query = "SELECT count(*) AS total_seguidores FROM usuarios_seguidores WHERE id_usuario_seguindo = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get("id"));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}