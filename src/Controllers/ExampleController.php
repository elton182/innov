<?php

namespace Edi\Controllers;
use Edi\Models\Order;

/**
 * ExampleController - Controller responsável por...
 */
class ExampleController extends Controller{

    /**
     * método que retorna a view index
     *
     * @return View
     */
    public function index()
    {                   
        return $this->view('example/index');
    }

    /**
     * método que retorna a view test
     *
     * @return void
     */
    public function test()
    {        
        return $this->view('example/test');
    }
    

}

?>