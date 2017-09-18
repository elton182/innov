<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Edi\Controllers\ExampleController;

class ExampleControllerTest extends \PHPUnit\Framework\TestCase{

    /**
     * testa se o metodo index retorna a view corretamente
     * deve conter a string bem vindo
     *
     * @return void
     */
    public function testIndex()
    {
        $exampleController = new ExampleController;           
                        
        ob_start();        
        $data = $exampleController->index();        
        $data = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains("Bem vindo", $data);
    }

    /**
     * testa se o metodo test retorna a view corretamente
     * deve conter a string Submit
     *
     * @return void
     */
    public function testTest()
    {
        $exampleController = new ExampleController;           
        
        ob_start();        
        $data = $exampleController->test();        
        $data = ob_get_contents();
        ob_end_clean();

        $this->assertContains("Hello", $data);
    }
    
    
}