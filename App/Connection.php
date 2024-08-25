<?php
namespace App;

use PDOException;

class Connection
{
    public static function getDb()
    {
        $host = "localhost";
        $dbname = "twitter-clone";
        $charset = "utf8";
        $user = "root";
        $pass = "";

        try {
            $conn = new \PDO(
                "mysql:host=$host;dbname=$dbname;charset=$charset",
                $user,
                $pass
            );
            return $conn;
        } catch (PDOException $e) {
            // Tratar de alguma forma
        }
    }
}