<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action
{
    public function validaAutenticacao()
    {
        session_start();

        if (!isset($_SESSION["id"]) || $_SESSION["id"] == "" || !isset($_SESSION["nome"]) || $_SESSION["nome"] == "") {
            header("Location: /?login=erro");
        }
    }

    public function timeline()
    {
        $this->validaAutenticacao();
        $tweet = Container::getModel("Tweet");

        $tweet->__set("id_usuario", $_SESSION["id"]);

        $this->view->tweets = $tweet->getAll();
        $this->render("timeline");
    }

    public function tweet()
    {
        $this->validaAutenticacao();
        $tweet = Container::getModel("Tweet");

        $tweet->__set("tweet", $_POST["tweet"]);
        $tweet->__set("id_usuario", $_SESSION["id"]);
        $tweet->salvar();
    }

    public function quemSeguir()
    {
        $this->validaAutenticacao();

        $pesquisarPor = $_GET["pesquisarPor"] ?? "";

        if ($pesquisarPor != "") {
            $usuario = Container::getModel("Usuario");
            $usuario->__set("nome", $pesquisarPor);
            $usuarios = $usuario->getAll();
        }

        $this->view->usuarios = $usuarios ?? [];

        $this->render("quemSeguir");
    }
}