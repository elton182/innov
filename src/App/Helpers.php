<?php

    /**
     * retorna uma variavel de ambiente do arquivo .env
     *
     * @param [type] $var
     * @return string
     */
    function env($var)
    {
        $file = dirname(__DIR__) . '/../.env';
        $env = '';
        if ($file = fopen($file, "r")) {
            while(!feof($file)) {
                $line = fgets($file);
                
                $envLine = explode('=',$line);
                if( !is_null($envLine) ){
                    if ($envLine[0] == $var){
                        $env = $envLine[1];
                    }
                }
            }
            fclose($file);
        }
        
        return preg_replace( "/\r|\n/", "", $env );;
    }

    /**
     * retorna uma data formatada como string no format d/m/Y H:i:s
     * recebe uma data no formato 2015-10-15T17:37:58-03:00
     *
     * @param [type] $string
     * @return string
     */
    function formatDate($string)
    {
        if ( empty($string) ){
            return '';
        }
        //2015-10-15T17:37:58-03:00
        $format = 'd/m/Y H:i:s';
        $year   = substr($string, 0, 4);
        $month  = substr($string, 5, 2);
        $day    = substr($string, 8, 2);

        $hour   = substr($string, 11, 2);
        $minute = substr($string, 14, 2);
        $second = substr($string, 17, 2);

        $bar = '/';
        $date = $day . '/' . $month . '/' . $year . ' ' . $hour . ':' . $minute . ':' . $second;
        return DateTime::createFromFormat($format, $date)->format($format);

    }

    /**
     * retorna o var_dump formatado
     *
     * @param [type] $obj
     * @return void
     */
    function debug($obj, $exit = false)
    {
        echo '<pre>';
        var_dump($obj);

        if ($exit){
            exit();
        }
    }
    
    /**
     * retorna o caminho para um diretório na pasta storage
     *
     * @param [type] $folder
     * @return void
     */
    function storageDir($folder)
    {
        $ds = DIRECTORY_SEPARATOR;

        return dirname(__DIR__) . $ds . '..' . $ds . 'storage' . $ds . $folder . $ds;
    }

    /**
     * habilita a exibição de erros e alertas
     *
     * @return void
     */
    function enableErrors()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    /**
     * retorna o caminho do arquivo de log
     *
     * @return void
     */
    function logFile()
    {
        return storageDir('log') . date('d_m_Y', time()) . '.log';
    }

    /**
     * metodo que escreve o log no arquivo
     *
     * @param [type] $message
     * @param [type] $filename
     * @return void
     */
    function writeLog($message, $filename)
    {
        $message = date('d/m/Y H:i:s', time()) 
                 . '    ' 
                 . 'Erro no processamento do arquivo: "' 
                 . $filename 
                 . '" Mensagem: "' 
                 . $message 
                 . '"' 
                 . "\n";

        error_log($message, 3, logFile());
    }

    /**
     * retorna uma response com um status code
     *
     * @param [type] $msg
     * @param [type] $statusCode
     * @return void
     */
    function response($msg, $statusCode)
    {

        // header('HTTP/1.1' . $statusCode);
        http_response_code($statusCode);
        echo $msg;
    }
    
?>