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
        $message = 'Hello World';
        $array = [
            'item1' => 'valor1',
            'item2' => 'valor2',
            'item3' => 'valor3',
        ];
        return $this->view('example/index',compact('message','array'));
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