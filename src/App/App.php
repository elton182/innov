<?php

namespace App\App;

use App\Routes\Router;

/**
 * Classe que inicializa a aplicação
 */
class App
{
    /**
     * propriedade router, onde irá ficar as rotas
     *
     * @var [type]
     */
    public $router;

    /**
     * método construtor da Aplicação
     */
    public function __construct()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $this->boot();
    }

    /**
     * método que inicia a aplicação instanciando um novo roteador
     *
     * @return void
     */
    public function boot()
    {
        $this->router = new Router();        
    }
    
}