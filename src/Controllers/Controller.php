<?php

namespace Edi\Controllers;

/**
 * Classe base do controller
 */
class Controller
{

    /**
     * retorna uma view
     *
     * @param [type] $path
     * @param array $params
     * @return void
     */
    public function view($path, $params = [])
    {                    
        echo file_get_contents(dirname(__DIR__) . '/View/' . $path . '.php');        
    }

}