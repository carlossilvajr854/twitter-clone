<?php

namespace App\Models;
use MF\Model\Model;

class Tweet extends Model
{
    private $id;
    private $id_usuario;
    private $tweet;
    private $data;

    public function __get($atributo)
    {
        return $this->$atributo;
    }
    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }
    public function salvar()
    {
        $query = "INSERT INTO tweets(id_usuario, tweet) VALUES(:id_usuario, :tweet)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get("id_usuario"));
        $stmt->bindValue(":tweet", $this->__get("tweet"));
        $stmt->execute();

        header("Location: /timeline");
    }

    public function getAll()
    {
        $query = "
            SELECT 
                t.id,
                t.id_usuario,
                u.nome AS usuario,
                t.tweet AS tweet,
                DATE_FORMAT(t.data, '%d/%m/%Y %H:%i') AS data_tweet
            FROM
                tweets AS t
            INNER JOIN
                usuarios AS u
            ON
                t.id_usuario = u.id
            WHERE
                t.id_usuario = :id_usuario
            ORDER BY
                t.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue("id_usuario", $this->__get("id_usuario"));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}