<?php

namespace App\Database;

use \oci_connect;
use \oci_execute;
use \oci_error;
use Exception;

/**
 * Classe responsável pela conexão com o banco e pelas querys
 */
class Builder{

    /**
     * propriedade que armazena a conexao com o banco
     *
     * @var [type]
     */
    protected $con;    

    // 172.16.1.242
    // sistedi
    // ihgTsgdTYh5x

    /**
     * método que irá desconectar uma conexão com o banco
     *
     * @return void
     */
    public function disconnect()
    {
        oci_close($this->con);
    }

    /**
     * método que irá conectar no banco
     *
     * @return void
     */
    public function connect()
    {   
        
        $tns = "  
        (DESCRIPTION =
            (ADDRESS_LIST =
            (
                ADDRESS = (PROTOCOL = TCP)(HOST = " . env('DATABASE_HOST'). ")(PORT = " . env('DATABASE_PORT'). "))
            )
            (CONNECT_DATA =
                (SID = " . env('DATABASE_SID'). ")
            )
        )
            ";
        $db_username = env('DATABASE_USER');//Usuário do banco de dados
        $db_password = env('DATABASE_PASS');//Senha do banco de dados
        
        
        //Conecta com o banco de dados
        if ( function_exists('oci_connect') ){
            $this->con = oci_connect($db_username, $db_password, $tns); 
            
            if (!$this->con) {
                throw new Exception($this->error(), 1);                
            }
        }
        else{
            throw new Exception("A extensão OCI não está ativa no PHP", 1);
            
        }
        

    }

    /**
     * método que restorna uma query de select sql
     *
     * @param [type] $id - campo ID da tabela
     * @param [type] $model - array da model
     * @return void
     */
    public function get($id,$model)
    {
     
        $stmt = oci_parse($this->con, $sql);

    }

    /**
     * método que executa um insert no banco
     *
     * @param [type] $sql - query a ser executada
     * @param [type] $model - array do modelo
     * @return $id - retorna a chave primária da tabela
     */
    public function insert($sql, $model)
    {
        
        $stmt = oci_parse($this->con, $sql);
        $model = (array) $model;
        foreach ($model as $key => $value) {
                            
            $bind = [
                ''.$key => $value
            ];
            
            oci_bind_by_name($stmt, $key , $model[$key]);
        }
        oci_bind_by_name($stmt, ':ID' , $id);                
        oci_execute($stmt, OCI_NO_AUTO_COMMIT);
        // $this->error();
        return $id;
    }

    /**
     * método que retorna os itens filhos com base na model
     *
     * @param [type] $sql - query a ser executada
     * @param [type] $class - array do modelo
     * @return array - um array com os registros filhos
     */
    public function selectChildren($sql, $class)
    {
        
        $stmt = oci_parse($this->con, $sql);        
        oci_execute($stmt);
        $children = [];
               
        while (($row = oci_fetch_array($stmt, OCI_BOTH)) != false) {
            // Use the uppercase column names for the associative array indices

            $model = new $class;
            foreach ($row as $key => $value) {
                $model->set($key, $value);
            }            

            array_push($children, $model);
        }
        
        oci_free_statement($stmt);

        return $children;
    }

    /**
     * método que faz um select 
     *
     * @param [type] $sql - query a ser executada
     * @param [type] $model - array do modelo 
     * @return void
     */
    public function select($sql, $model)
    {
        
        $stmt = oci_parse($this->con, $sql);        
        oci_execute($stmt);
               
        while (($row = oci_fetch_array($stmt, OCI_BOTH)) != false) {
            // Use the uppercase column names for the associative array indices
            foreach ($row as $key => $value) {
                $model->set($key, $value);
            }            
        }
        
        oci_free_statement($stmt);
    }

    /**
     * método que retorna o ultimo erro de uma conexão aberta
     *
     * @return void
     */
    public function error()
    {
        $e = oci_error();   // For oci_connect errors do not pass a handle
        
        if ( !empty($e) )
            return $e['message'];
    }

    /**
     * método que executa um commit
     *
     * @return void
     */
    public function commit()
    {
        return oci_commit($this->con);
    }

    
}

?>