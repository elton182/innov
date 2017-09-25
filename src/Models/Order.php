<?php

namespace App\Models;

use App\Database\Builder;
use App\Models\OrderItem;
use Exception;

/**
 * Class Order - é um modelo virtual da tabela PEDIDO_VALE
 */
class Order extends Model
{
    /**
     * Nome do campo chave primária da tabela
     *
     * @var string
     */
    protected $primaryKey   = 'ID_PEDIDO_VALE';

    /**
     * Nome da tabela a qual esse model se refere
     *
     * @var string
     */
    protected $tableName    = 'PEDIDO_VALE';

    /**
     * nome da sequence para chave primária
     *
     * @var string
     */
    protected $sequenceName = 'PEDIDO';

    /**
     * campos da model que são do tipo data
     *
     * @return void
     */
    protected $dateFields   = ['DT_INCLUSAO','UPDATED_DATE'];

    /**
     * array com a tabela filha 
     *
     * @var array
     */
    protected $relation     = [
        'model' => 'App\Models\OrderItem',
        'table' => 'PEDIDO_VALE_ITEM',
        'foreign_key' => 'ID_PEDIDO_VALE'
    ];

    /**
     * propriedade com os registros filhos da classe
     *
     * @var array
     */
    public    $children     = [];

    /* class attributes */
    protected $ID_PEDIDO_VALE;
    protected $ID_ORDEM_CLI;
    protected $ID_ORDEM_CLI_SEQ;
    protected $ID_ORDEM_FORNEC;
    protected $TS_ORDEM;
    protected $ID_CONTA;
    protected $DS_FINALIDADE;
    protected $DS_TIPO_COMPRA;
    protected $DS_TIPO_ORDEM;
    protected $CD_VALE_QUADREM;
    protected $DS_MOEDA;
    protected $DS_TPID_CLI;
    protected $DS_ORGID_CLI;
    protected $DS_NAME1_CLI;
    protected $DS_NAME2_CLI;
    protected $DS_END1_CLI;
    protected $DS_END2_CLI;
    protected $DS_END3_CLI;
    protected $DS_CEP_CLI;
    protected $DS_CIDADE_CLI;
    protected $DS_REGIAO_CLI;
    protected $CD_FUNC_CLI;
    protected $DS_CONTATO_NOME_CLI;
    protected $DS_CONTATO_EMAIL_CLI;
    protected $DS_CONTATO_TEL_CLI;
    protected $DS_CONTATO_FAX_CLI;
    protected $DS_REQUISITANTE_CLI;
    protected $DS_TPID_FORNEC;
    protected $DS_ORGID_FORNEC;
    protected $DS_NAME1_FORNEC;
    protected $DS_NAME2_FORNEC;
    protected $DS_END1_FORNEC;
    protected $DS_END2_FORNEC;
    protected $DS_END3_FORNEC;
    protected $DS_CEP_FORNEC;
    protected $DS_CIDADE_FORNEC;
    protected $DS_REGIAO_FORNEC;
    protected $CD_FUNC_FORNEC;
    protected $DS_CONTATO_NOME_FORNEC;
    protected $DS_CONTATO_EMAIL_FORNEC;
    protected $DS_CONTATO_TEL_FORNEC;
    protected $DS_CONTATO_FAX_FORNEC;
    protected $DS_REQUISITANTE_FORNEC;
    protected $DS_TPID_FATURA;
    protected $DS_ORGID_FATURA;
    protected $DS_NAME1_FATURA;
    protected $DS_NAME2_FATURA;
    protected $DS_END1_FATURA;
    protected $DS_END2_FATURA;
    protected $DS_END3_FATURA;
    protected $DS_CEP_FATURA;
    protected $DS_CIDADE_FATURA;
    protected $DS_REGIAO_FATURA;
    protected $CD_FUNC_FATURA;
    protected $DS_CONTATO_NOME_FATURA;
    protected $DS_CONTATO_EMAIL_FATURA;
    protected $DS_CONTATO_TEL_FATURA;
    protected $DS_CONTATO_FAX_FATURA;
    protected $DS_REQUISITANTE_FATURA;
    protected $DS_TRANSP_TIPO;
    protected $DS_TRANSP_NAME;
    protected $DS_TRANSP_ENDERECO;
    protected $DS_TRANSP_OBS;
    protected $DS_COND_PAGAMENTO;
    protected $DS_NOTE1;
    protected $DS_NOTE2;
    protected $DS_NOTE3;
    protected $DS_NOTE4;
    protected $DS_NOTE5;
    protected $DS_NOTE6;
    protected $DS_NOTE7;
    protected $DS_NOTE8;
    protected $DS_FILENAME1;
    protected $DS_FILENAME2;
    protected $DS_FILENAME3;
    protected $DS_TOTAL_ORDER;
    protected $DS_NOTEID1;
    protected $DS_NOTEID2;
    protected $DS_NOTEID3;
    protected $DS_NOTEID4;
    protected $DS_NOTEID5;
    protected $DS_NOTEID6;
    protected $DS_NOTEID7;
    protected $DS_NOTEID8;
    protected $DS_CNPJ_NORTEL;
    protected $ID_FILI_SEQ;
    protected $ID_CONPAG;
    protected $DS_FRETE;
    protected $DS_CNPJ_TRANSP;
    protected $ID_TRANSP;
    protected $DT_INCLUSAO;
    protected $IC_CODIGO_RESPOSTA;
    protected $USER_ULTIMA_ALTERACAO;
    protected $DT_ULTIMA_ALTERACAO;
    protected $STATUS;
    protected $COD_CLIENTE;
    protected $DS_MOTIVO_REJEICAO;
    protected $ID_USER_SESSION;
    protected $USER_SESSION;
    protected $DS_OBS_GERAL;
    protected $IC_ALTEROU;
    protected $NIMBI_STATUS;
    protected $CREATED_BY;
    protected $UPDATED_BY;
    protected $UPDATED_DATE;
    protected $NIMBI_POR_COMMENT;
    protected $NIMBI_POR_EMAIL;
    protected $NIMBI_POR_TRANSACTION_ID;
    protected $NIMBI_POR_ID;
    protected $NIMBI_TITLE;
    protected $NIMBI_ID;
    protected $IC_INTEGRACAO;
    protected $DS_INTEGRACAO;
    protected $DT_INTEGRACAO;
    

    /**
     * retorna a finalidade traduzida
     *
     * @param [type] $finalidade
     * @return void
     */
    public function getFinalidade($finalidade)
    {
        switch ($finalidade) {
            case 'new':
                return 'Nova/Inclusão';
                break;
            case 'update':
                return 'Alteração';
                break;
            case 'delete':
                return 'Cancelamento';
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * Método Construtor que irá persistir as informações do Pedido recebendo de parâmetro o xml
     *
     * @param Order $order
     */
    public function __construct($order = null)
    {

        if( !is_null($order) ){

            $today = date('d/m/Y H:i:s', time());
                            
                $this->ID_ORDEM_CLI        = (string)$order->Request->OrderRequest->OrderRequestHeader['orderID'];
                $this->ID_ORDEM_CLI_SEQ    = '0'; /*todo*/ 
                $this->ID_ORDEM_FORNEC     = (string)$order->Header->From->Credential->Identity;
                $this->TS_ORDEM            = $today;
                $this->ID_CONTA            = '2';
                $this->DS_FINALIDADE       = $this->getFinalidade((string)$order->Request->OrderRequest->OrderRequestHeader['type']);
                $this->DS_TIPO_COMPRA      = ''; /*todo*/
                $this->DS_MOEDA            = (string)$order->Request->OrderRequest->OrderRequestHeader->Total->Money['currency'];
                $this->DS_TPID_CLI         = (string)$order->Request->OrderRequest->OrderRequestHeader->Extrinsic[4];
                $this->DS_NAME1_CLI        = (string)$order->Request->OrderRequest->OrderRequestHeader->ShipTo->Address->Name;
                $this->DS_END1_CLI         = (string)$order->Request->OrderRequest->OrderRequestHeader->ShipTo->Address->PostalAddress->Street;
                $this->DS_CIDADE_CLI       = (string)$order->Request->OrderRequest->OrderRequestHeader->ShipTo->Address->PostalAddress->City;
                $this->DS_REGIAO_CLI       = (string)$order->Request->OrderRequest->OrderRequestHeader->ShipTo->Address->PostalAddress->State;
                $this->DS_CEP_CLI          = (string)$order->Request->OrderRequest->OrderRequestHeader->ShipTo->Address->PostalAddress->PostalCode;
                $this->DS_NOTE1            = (string)$order->Request->OrderRequest->OrderRequestHeader->Extrinsic[10];
                $this->DS_TOTAL_ORDER      = (string)$order->Request->OrderRequest->OrderRequestHeader->Total->Money;
                $this->DS_CNPJ_NORTEL      = (string)$order->Request->OrderRequest->OrderRequestHeader->Extrinsic[8];
                $this->DT_INCLUSAO         = $today;
                $this->IC_CODIGO_RESPOSTA  = 'B';
                $this->NIMBI_STATUS        = (string)$order->Request->OrderRequest->OrderRequestHeader['type'];
                $this->UPDATED_DATE        = formatDate($order->Request->OrderRequest->OrderRequestHeader['orderDate']);
                $this->NIMBI_ID            = (int)$order->Request->OrderRequest->OrderRequestHeader->Extrinsic[9];

                foreach ($order->Request->OrderRequest->ItemOut as $item) {
                    $this->addItem($item);
                }

        }
        
    }


    /**
     * Método que retorna a lista de Itens
     *
     * @return array
     */
    public function getItens()
    {
        return $this->children;
    }

    /**
     * Método que adiciona um item
     *
     * @param SimpleXmlElement $item
     * @return void
     */
    public function addItem($item)
    {   
        $orderItem = new OrderItem($item);            
        array_push($this->children, $orderItem);
    }

    /**
     * Método que irá enviar as informações para o banco e retorna o status
     *
     * @return void
     */
    public function save()
    {
        
        $builder = new Builder;
        
        try {
            $builder->connect();
            
            $id = $builder->insert(
                '
                INSERT INTO '.$this->tableName.'
                ('.$this->getFields().')
                VALUES('.$this->getValues().')
                returning ' . $this->primaryKey . ' into :id
                ',
                $this->getBind()
            );        
            
            $builder->commit();                
            $builder->disconnect();
    
            if ( $id > 0 ) {
                $this->ID_PEDIDO_VALE = $id;
    
                foreach ($this->children as $item) {
                    $item->save($this);
                }
            } 
        }
        catch (Exception $ex) {
            
            $this->error = $ex->getMessage();
            return false;
        }

        return true;
        

    }
    
    
}
