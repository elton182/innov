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
        // $template = file_get_contents(dirname(__DIR__) . '/View/' . $path . '.php');
        $template = dirname(__DIR__) . '/View/' . $path . '.php';
        extract($params);        
        ob_start();
        include $template;
        $content = ob_get_contents();
        $content = $this->resolveTemplate( $content, $params);
        // require (dirname(__DIR__) . '/View/' . $path . '.php');

        ob_end_clean();

        echo $content;

        // echo $this->resolveTemplate($template, $params);
    }

    public function resolveTemplate($template, $data){
        
        // search pattern

        $insideLoop = false;
        $pattern = '/{{([^}]+)}}/';

        $callback = function ($match) use($data){
            
            $string = '';
            if(isset($match[1])){
                $string = trim($match[1]);

                $aux = $string;

                if ( strpos($aux, '@each') !== false) {
                    $aux = str_replace('@each', 'foreach', $aux);
                    $aux = $aux . '{';

                    $insideLoop = true;
                    return $aux;
                }

                if ( strpos($aux, '@endEach') !== false) {
                    $aux = str_replace('@endEach', '}', $aux);
                    
                    $insideLoop = false;
                    return $aux;
                }

                
            }            
            
            if(isset($data[$string])){    
                                
                return $data[$string];
            }

        };
        
        return preg_replace_callback($pattern, $callback, $template);

    }

}