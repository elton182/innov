<?php

namespace Edi\Routes;

/**
 * Classe que faz a roterização da aplicação
 */
class Router
{
    /**
     * uri da request
     *
     * @var [type]
     */
    protected $uri;

    /**
     * porta do servidor
     *
     * @var [type]
     */
    protected $port;

    /**
     * tipo do método, GET ou POST
     *
     * @var [type]
     */
    protected $method;

    /**
     * rotas
     *
     * @var [type]
     */
    protected $routes;

    /**
     * variavel para guardar o conteudo do $_GET
     *
     * @var [type]
     */
    protected $get;

    /**
     * ariavel para guardar o conteudo do $_POST
     *
     * @var [type]
     */
    protected $post;

    /**
     * nome do host do servidor
     *
     * @var [type]
     */
    protected $host;    

    /**
     * arquivos enviados no request
     *
     * @var [type]
     */
    protected $files;

    /**
     * método que constroi a classe
     */
    public function __construct()
    {
        $this->routes = include(dirname(__DIR__) . '/Config/routes.php');
    }

    /**
     * método que faz o roteamento
     *
     * @param [type] $server
     * @return void
     */
    public function routes($server)
    {        
        $this->uri    = $server['REQUEST_URI'];
        $this->port   = $server['SERVER_PORT'];
        $this->method = $server['REQUEST_METHOD'];
        $this->get    = $_GET;
        $this->post   = $_POST;        
        $this->host   = $_SERVER['SERVER_NAME'];
        $this->files  = $_FILES;

        $this->call($this->route());
    }

    /**
     * método que irá retornar a rota com base no request
     *
     * @return void
     */
    public function route()
    {
        $path = $this->getUri();
        
        $pattern = '/^(?:(\w[\w\d+.-]+):\/\/)?(?:(.+?):(.+)@)?(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}|[^#:\/\?\s]+)(?::(\d+))?\/?(\/(?:[^#\/\?\s]+\/)*[^#\/\?\s]+\/?)?(?:\?((?:[^#=\/\s]+=[^&;#\/\s]+[&;]?)+))?(?:#(.+))?$/';
        
        $callback = function ($match){
            
            if ( isset($match[6])){
                $uri = $match[6];
            } else
                $uri = '';
            
            
            return $this->routes[$uri];
        
        };
        
        return preg_replace_callback($pattern, $callback, $path);

    }

    /**
     * retorna a URI completa
     *
     * @return void
     */
    public function getUri()
    {
        return 'http://' 
            . $this->host 
            . ':' 
            . $this->port
            . $this->uri;
    }

    /**
     * método que chama o controller desiginado pela rota
     *
     * @param [type] $route
     * @return void
     */
    public function call($route)
    {

        
        $call       = explode('@',$route);
        $controller = 'Edi\Controllers\\' . $call[0];
        $method     = $call[1];
        
        $request = new \StdClass;
        $request->get   = $this->get;
        $request->post  = $this->post;
        $request->files = $this->files;
    
        if(class_exists($controller)){
            
            $controller = new $controller;                                       
            $controller->$method($request);    
                        
        }
    }
}