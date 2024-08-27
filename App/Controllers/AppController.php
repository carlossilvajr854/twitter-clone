<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action
{
    public function timeline()
    {
        if ($usuario->__get("id") != '' && $usuario->__get("nome") != '') {
            session_start();

            print_r($_SESSION);
            echo "chegamos até aqui!";
        } else {
            header("Location: /?login=erro");
        }
    }
}