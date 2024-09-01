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
            $usuario->__set("id", $_SESSION["id"]);
            $usuarios = $usuario->getAll();
        }

        $this->view->usuarios = $usuarios ?? [];

        $this->render("quemSeguir");
    }

    public function acao()
    {
        $this->validaAutenticacao();

        $acao = $_GET["acao"] ?? "";
        $id_usuario_seguindo = $_GET["id_usuario"] ?? "";

        $usuario = Container::getModel("UsuariosSeguidores");
        $usuario->__set("id_usuario", $_SESSION["id"]);

        switch ($acao) {
            case 'seguir':
                $usuario->seguirUsuario($id_usuario_seguindo);
                break;
            case 'deixar-de-seguir':
                $usuario->deixarDeSeguirUsuario($id_usuario_seguindo);
                break;

            default:
                # code...
                break;
        }
        header("Location: /quem_seguir");
    }
}