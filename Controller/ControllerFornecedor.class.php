<?php

/**
 * <b>Description of ControllerFornecedor<b><br>
 *  Classe que controla as chamadas e exibições do fornecedor
 * @author Ivan Alves da Silva
 * @version Classe controler do fornecedor
 * @copyright (c) 2016, Thirday DRK Technologia
 * <b>Demandas</b>
 * <ol>Gerar array com o indice de selected quando necessário</ol>
 */
class ControllerFornecedor extends ModelFornecedor {

    private $forn_id; //Id   
    private $forn_name; //Nome
    private $forn_doc; //CPF ou CNPJ
    private $forn_tel; //Tel de contato 
    private $forn_created_at; // Data de registro do fornecedor
    private $forn_updated_at; //última atualização

    /**
     *
     * @var array - Armazena um array com todos os fornecedores 
     */
    private $allFornecedores;

    /**
     * @var array - Array transformado para envio a Classe Form
     */
    private $allFornecedoresForSelect;

    /**
     * @var int Limite a ser consultado 
     */
    private $limitResult = 30;
    private $selected;

    /**
     * @var string de orde do array resultante  
     */
    private $orderByResult = "forn_name";
    //Array com os índices sendo os atributos variáveis da classe
    private $fornecedor;

    /**
     * Método pega os dados de $_POST e faz o salvamento
     * @return boolean
     * @throws Exception lança uma excessão caso não consiga salvar
     */
    public function cadFornecedor() {
        try {
            $this->verificaPost();
            $this->criaArrayAtributosVariaveis();
            $this->verificaDadosObrigatorios();
            $this->verificaDuplicidade();
            if ($this->forn_id = parent::save($this->fornecedor)):
                return TRUE;
            else:
                throw new Exception("Houve algum erro ao tentar registrar o fornecedor", E_USER_ERROR);
            endif;
        } catch (Exception $e) {
            drkMsg($e->getMessage(), $e->getCode());
            return false;
        }
    }

    /**
     * Carrega o fornecedor solicitado
     * @param int $cat_id
     * @return \ControllerCategory Retorna um objeto carregado com o fornecedor solicitado
     */
    public function getFornecedor($forn_id) {
        try {
            parent::getFornecedor($forn_id);
        } catch (Exception $e) {
            drkMsg("Não conseguimos carregar o objeto com o id informado. ".__CLASS__, E_USER_WARNING);
            drkMsg($e->getMessage(), $e->getCode());
        }        
        $this->forn_id=  parent::getForn_id();
        $this->forn_name=  parent::getForn_name();
        $this->forn_doc=  parent::getForn_doc();
        $this->forn_tel=  parent::getForn_tel();
        $this->forn_created_at=  parent::getForn_created_at();
        $this->forn_updated_at=  parent::getForn_updated_at();
        return $this;
        
    
    }
    
    
    /**
     * Método gera uma string com <option></option> para selects com todos fornecedores cadastrados -  Limit 30
     * @return string com o html do select
     */
    public function getFornecedoresOptions() {
        $this->queryAllFornecedores();
        $this->geraArrayFornecedoreForSelect();
        if (isset($this->allFornecedoresForSelect)):
            return Form::geraOpcoesSelect($this->allFornecedoresForSelect);
        else:
            return FALSE;
        endif;
    }

    /*     * ******************MÉTODOS internos de consultas******************* */

    private function queryAllFornecedores() {
        $this->allFornecedores = parent::listAllFornecedores($this->orderByResult, $this->limitResult);
    }

    /**
     * Método pega o array com todos os resultados da query armazenados e gera
     * array preparado para o select na classe Form
     */
    private function geraArrayFornecedoreForSelect() {
        
        foreach ($this->allFornecedores as $value) {
            if ($this->selected === $value['forn_id']):
                $selected = "selected";
                $select[$value['forn_id']] = array("value" => $value['forn_name'], "selected" => $selected);
            else:
                $select[$value['forn_id']] = array("value" => $value['forn_name']);
            endif;           
        }
        if (isset($select)):
            $this->allFornecedoresForSelect = $select;
        else:
            $this->allFornecedoresForSelect = NULL;
        endif;
    }

    /*     * ******************MÉTODOS GETTER******************* */

    public function getAllFornecedores() {
        return $this->allFornecedores;
    }

    public function getForn_id() {
        return $this->forn_id;
    }

    public function getForn_name() {
        return $this->forn_name;
    }

    public function getForn_doc() {
        return $this->forn_doc;
    }

    public function getForn_tel() {
        return $this->forn_tel;
    }

    public function getForn_created_at() {
        return $this->forn_created_at;
    }

    public function getForn_updated_at() {
        return $this->forn_updated_at;
    }

    public function getLimitResult() {
        return $this->limitResult;
    }

    public function getOrderByResult() {
        return $this->orderByResult;
    }

    /*     * ************* MÉTODOS SETTER********** */

    public function setForn_id($forn_id) {
        $this->forn_id = $forn_id;
        return $this;
    }
    function setSelected($selected) {
        $this->selected = $selected;
        return $this;
    }

    
    public function setForn_name($forn_name) {
        $this->forn_name = $forn_name;
        return $this;
    }

    public function setForn_doc($forn_doc) {
        $this->forn_doc = $forn_doc;
        return $this;
    }

    public function setForn_tel($forn_tel) {
        $this->forn_tel = $forn_tel;
        return $this;
    }

    public function setLimitResult($limitResult) {
        $this->limitResult = $limitResult;
        return $this;
    }

    public function setOrderByResult($orderByResult) {
        $this->orderByResult = $orderByResult;
        return $this;
    }

    /**
     * Verifica a existência de dados enviados via POST e configura o objeto
     */
    private function verificaPost() {
        $name = filter_input(INPUT_POST, "forn_name", FILTER_DEFAULT);
        $this->forn_name = (isset($name) && !empty($name) && $name != "") ? ucwords(strtolower($name)) : NULL;
        $doc = filter_input(INPUT_POST, "forn_doc", FILTER_DEFAULT);
        $this->forn_doc = (isset($doc) && !empty($doc) && $doc != "") ? $doc : NULL;
        $tel = filter_input(INPUT_POST, "forn_tel", FILTER_DEFAULT);
        $this->forn_tel = (isset($tel) && !empty($tel) && $tel != "") ? $tel : NULL;
    }

    private function criaArrayAtributosVariaveis() {
        $this->fornecedor["forn_name"] = $this->forn_name;
        $this->fornecedor["forn_doc"] = $this->forn_doc;
        $this->fornecedor["forn_tel"] = $this->forn_tel;
    }

    private function verificaDadosObrigatorios() {
        $obrigatorios = array("forn_name");
        foreach ($obrigatorios as $value):
            if (!isset($this->fornecedor[$value]) || empty($this->fornecedor[$value]) || $this->fornecedor == ""):
                throw new Exception("{$value} é um campo obrigatório e não foi fornecido.", E_USER_ERROR);
            endif;
        endforeach;
    }
    /*
     * Método responsável por veríficar cada campo que não pode se repetir no BD
     * Caso encontre algum dado já existente ele lança uma excessão
     */
    private function verificaDuplicidade() {
        parent::getFornecedorByName(trim($this->forn_name));
        if(parent::getComprimentoUltimaListaRetornada()>=1): 
            throw new Exception("Já existe um fornecedor cadastrado com o nome <b> {$this->forn_name} </b> .", E_USER_ERROR);               

        endif;
    }

}
