<?php

/**
 * <b>Description of ControllerCategory<b><br>
 *  Classe que controla as chamadas e exibições das LINHAS DE produto
 * @author Ivan Alves da Silva
 * @version Classe controler das Linhas de produtos
 * @copyright (c) 2016, Thirday DRK Technologia
 * <b>Demandas</b>
 * <ol>Gerar array com o indice de selected quando necessário</ol>
 */
class ControllerCategory extends ModelCategory {

    private $cat_id;
    private $cat_name;
    private $cat_description;
    private $cat_parent = 0;
    private $cat_created_at;
    private $cat_updated_at;
  
    /**
     *
     * @var array - Armazena um array com todos as linhas de produtos cadastradas 
     */
    private $allCategories;

    /**
     * @var array - Array transformado para envio a Classe Form
     */
    private $allCategoriesForSelect;

    /**
     * @var int Limite a ser consultado 
     */
    private $limitResult = 30;

    /**
     * @var string de orde do array resultante  
     */
    private $orderByResult = "cat_name";
    
    private $selected=NULL;
    
    //Array com os índices sendo os atributos variáveis da classe
    private $category;

    /**
     * Método pega os dados de $_POST e faz o salvamento
     * @return boolean
     * @throws Exception lança uma excessão caso não consiga salvar
     */
    public function cadCategory() {
        try {
            $this->verificaPost();
            $this->criaArrayAtributosVariaveis();
            $this->verificaDadosObrigatorios();
            $this->verificaDuplicidade();
            if ($this->cat_id = parent::save($this->category)):
                return TRUE;
            else:
                throw new Exception("Houve algum erro ao tentar efetuar o registro.<br> ".__CLASS__.__LINE__, E_USER_ERROR);
            endif;
        } catch (Exception $e) {
            drkMsg($e->getMessage(), $e->getCode());
            return false;
        }
    }
    /**
     * Carrega a categoria solicitada
     * @param int $cat_id
     * @return \ControllerCategory Retorna um objeto carregado com a categoria solicitada
     */
    public function getCategory($cat_id) {
        try {
            parent::getCategory($cat_id);
        } catch (Exception $e) {
            drkMsg("Não conseguimos carregar o objeto com o id informado. ".__CLASS__, E_USER_WARNING);
            drkMsg($e->getMessage(), $e->getCode());
        }        
        $this->cat_id=  parent::getCat_id();
        $this->cat_name=  parent::getCat_name();
        $this->cat_description=  parent::getCat_description();
        $this->cat_parent=  parent::getCat_parent();
        $this->cat_created_at=  parent::getCat_created_at();
        $this->cat_updated_at=  parent::getCat_updated_at();
        return $this;
        
    }

    /**
     * Método gera uma string com <option></option> para selects com todos fornecedores cadastrados -  Limit 30
     * @return string com o html do select
     */
    public function getCategoriesOptions() {
        $this->queryAllCategories();
        $this->geraArrayCategoryForSelect();
        if (isset($this->allCategoriesForSelect)):
            return Form::geraOpcoesSelect($this->allCategoriesForSelect);
        else:
            return FALSE;
        endif;
    }

    /*     * ******************MÉTODOS internos de consultas******************* */

    private function queryAllCategories() {
        $this->allCategories = parent::listAllCategories($this->orderByResult, $this->limitResult);
    }

    /**
     * Método pega o array com todos os resultados da query armazenados e gera
     * array preparado para o select na classe Form
     */
    private function geraArrayCategoryForSelect() {
        
        
        foreach ($this->allCategories as $value) {
            if ($this->selected===$value['cat_id']):
                $selected="selected";                
            $select[$value['cat_id']] = array("value" => $value['cat_name'],"selected"=>$selected);
           else:
            $select[$value['cat_id']] = array("value" => $value['cat_name']);
               
            endif;
        }
        if (isset($select)):
            $this->allCategoriesForSelect = $select;
        else:
            $this->allCategoriesForSelect = NULL;
        endif;
    }

    /*     * ******************MÉTODOS GETTER******************* */

    public function getCat_id() {
        return $this->cat_id;
    }

    public function getCat_name() {
        return $this->cat_name;
    }

    public function getCat_description() {
        return $this->cat_description;
    }

    public function getCat_parent() {
        return $this->cat_parent;
    }

    public function getCat_created_at() {
        return $this->cat_created_at;
    }

    public function getCat_updated_at() {
        return $this->cat_updated_at;
    }

    public function getAllCategories() {
        return $this->allCategories;
    }

    public function getLimitResult() {
        return $this->limitResult;
    }

    
    /*     * ************* MÉTODOS SETTER********** */

    public function setCat_id($cat_id) {
        $this->cat_id = $cat_id;
        return $this;
    }
    function setSelected($selected) {
        $this->selected = $selected;
        return $this;
    }

    
    public function setCat_name($cat_name) {
        $this->cat_name = $cat_name;
        return $this;
    }

    public function setCat_description($cat_description) {
        $this->cat_description = $cat_description;
        return $this;
    }

    public function setCat_parent($cat_parent) {
        $this->cat_parent = $cat_parent;
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
        $name = filter_input(INPUT_POST, "cat_name", FILTER_DEFAULT);
        $this->cat_name = (isset($name) && !empty($name) && $name != "") ? $name : NULL;       
        $this->cat_parent = filter_input(INPUT_POST, "cat_parent", FILTER_VALIDATE_INT);      
        $description = filter_input(INPUT_POST, "cat_description", FILTER_DEFAULT);
        $this->cat_description = (isset($description) && !empty($description) && $description != "") ? $description : NULL;
    }

    private function criaArrayAtributosVariaveis() {
        $this->category["cat_name"] = $this->cat_name;
        $this->category["cat_parent"] = $this->cat_parent;
        $this->category["cat_description"] = $this->cat_description;
    }

    private function verificaDadosObrigatorios() {
        $obrigatorios = array("cat_name");
        foreach ($obrigatorios as $value):
            if (!isset($this->category[$value]) || empty($this->category[$value]) || $this->category == ""):
                throw new Exception("{$value} é um campo obrigatório e não foi fornecido.", E_USER_ERROR);
            endif;
        endforeach;
    }

    /*
     * Método responsável por veríficar cada campo que não pode se repetir no BD
     * Caso encontre algum dado já existente ele lança uma excessão
     */

    private function verificaDuplicidade() {
        parent::getCategoryByName(trim($this->cat_name));
        if (parent::getComprimentoUltimaListaRetornada() >= 1):
            throw new Exception("Já existe uma categoria cadastrada com o nome <b> {$this->cat_name} </b> .", E_USER_ERROR);

        endif;
    }

}
