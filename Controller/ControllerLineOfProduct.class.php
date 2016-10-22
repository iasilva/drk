<?php

/**
 * <b>Description of ControllerLineOfProduct<b><br>
 *  Classe que controla as chamadas e exibições das LINHAS DE produto
 * @author Ivan Alves da Silva
 * @version Classe controler das Linhas de produtos
 * @copyright (c) 2016, Thirday DRK Technologia
 * <b>Demandas</b>
 * <ol>Gerar array com o indice de selected quando necessário</ol>
 */
class ControllerLineOfProduct extends ModelLineOfProduct {

    private $line_id; //Id   
    private $line_name; //Nome
    private $line_description; //CPF ou CNPJ
    private $line_link; //Tel de contato 
    private $line_created_at; // Data de registro do fornecedor
    private $line_updated_at; //última atualização

    /**
     *
     * @var array - Armazena um array com todos as linhas de produtos cadastradas 
     */
    private $allLines;

    /**
     * @var array - Array transformado para envio a Classe Form
     */
    private $allLinesForSelect;

    /**
     * @var int Limite a ser consultado 
     */
    private $limitResult = 30;
    private $selected;

    /**
     * @var string de orde do array resultante  
     */
    private $orderByResult = "line_name";
    //Array com os índices sendo os atributos variáveis da classe
    private $line;

    /**
     * Método pega os dados de $_POST e faz o salvamento
     * @return boolean
     * @throws Exception lança uma excessão caso não consiga salvar
     */
    public function cadLine() {
        try {
            $this->verificaPost();
            $this->criaArrayAtributosVariaveis();
            $this->verificaDadosObrigatorios();
            $this->verificaDuplicidade();
            if ($this->line_id = parent::save($this->line)):
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
     * Lista as linhas de produto para editar
     * @return string - HTML DA TABELA DE EXIBIÇÃO
     */
    public function listLinesOfProductsForEdit() {
        $this->queryAllLines();
        $this->preparaLinhasParaLista();
        $colunas = $this->preparaColunasParaLista();
        $tabela = new Table($colunas, $this->allLines, "line_");
        $lista = $tabela->getTableEdit();
        return $lista;
    }

    /**
     * Carrega a linha de produto solicitada
     * @param int $line_id
     * @return \ControllerCategory Retorna um objeto carregado com a categoria solicitada
     */
    public function getLineOfProduct($line_id) {
        try {
            parent::getLineOfProduct($line_id);
        } catch (Exception $e) {
            drkMsg("Não conseguimos carregar o objeto com o id informado. " . __CLASS__, E_USER_WARNING);
            drkMsg($e->getMessage(), $e->getCode());
        }
        $this->line_id = parent::getLine_id();
        $this->line_name = parent::getLine_name();
        $this->line_link = parent::getLine_link();
        $this->line_description = parent::getLine_description();
        $this->line_created_at = parent::getLine_created_at();
        $this->line_updated_at = parent::getLine_updated_at();
        return $this;
    }

    /**
     * Método gera uma string com <option></option> para selects com todos fornecedores cadastrados -  Limit 30
     * @return string com o html do select
     */
    public function getLinesOptions() {
        $this->queryAllLines();
        $this->geraArrayFornecedoreForSelect();
        if (isset($this->allLinesForSelect)):            
            return Form::geraOpcoesSelect($this->allLinesForSelect);
        else:
            return FALSE;
        endif;
    }

    /*     * ******************MÉTODOS internos de consultas******************* */

    private function queryAllLines() {
        $this->allLines = parent::listAllLinesOfProduct($this->orderByResult, $this->limitResult);
    }

    /**
     * Método pega o array com todos os resultados da query armazenados e gera
     * array preparado para o select na classe Form
     */
    private function geraArrayFornecedoreForSelect() {

        foreach ($this->allLines as $value):
            if ($this->selected === $value['line_id']):
                $selected = "selected";
                $select[$value['line_id']] = array("value" => $value['line_name'], "selected" => $selected);
            else:
                $select[$value['line_id']] = array("value" => $value['line_name']);
            endif;
        endforeach;
        if (isset($select)):
            $this->allLinesForSelect = $select;
        else:
            $this->allLinesForSelect = NULL;
        endif;
    }

    /*     * ******************MÉTODOS GETTER******************* */

    public function getLine_id() {
        return $this->line_id;
    }

    public function getLine_name() {
        return $this->line_name;
    }

    public function getLine_description() {
        return $this->line_description;
    }

    public function getLine_link() {
        return $this->line_link;
    }

    public function getLine_created_at() {
        return $this->line_created_at;
    }

    public function getLine_updated_at() {
        return $this->line_updated_at;
    }

    public function getLimitResult() {
        return $this->limitResult;
    }

    public function getOrderByResult() {
        return $this->orderByResult;
    }

    /*     * ************* MÉTODOS SETTER********** */

    function setSelected($selected) {
        $this->selected = $selected;
        return $this;
    }

    public function setForn_id($line_id) {
        $this->line_id = $line_id;
        return $this;
    }

    public function setForn_name($line_name) {
        $this->line_name = $line_name;
        return $this;
    }

    public function setForn_doc($line_description) {
        $this->line_description = $line_description;
        return $this;
    }

    public function setForn_tel($line_link) {
        $this->line_link = $line_link;
        return $this;
    }

    public function setLimitResult($limitResult) {
        $this->limitResult = $limitResult;
        return $this;
    }

    public function setOrderByResult($orderByResult) {
        $att = get_class_vars('ControllerLineOfProduct');
        $existe = FALSE;
        foreach ($att as $key => $value):
            if ($key == $orderByResult):
                $existe = TRUE;
            endif;
        endforeach;
        if ($existe):
            $this->orderByResult = $orderByResult;
        endif;
    }

    /**
     * Verifica a existência de dados enviados via POST e configura o objeto
     */
    private function verificaPost() {
        $name = filter_input(INPUT_POST, "line_name", FILTER_DEFAULT);
        $this->line_name = (isset($name) && !empty($name) && $name != "") ? $name : NULL;
        $description = filter_input(INPUT_POST, "line_description", FILTER_DEFAULT);
        $this->line_description = (isset($description) && !empty($description) && $description != "") ? $description : NULL;
        $link = filter_input(INPUT_POST, "line_link", FILTER_DEFAULT);
        $this->line_link = (isset($link) && !empty($link) && $link != "") ? $link : NULL;
    }

    private function criaArrayAtributosVariaveis() {
        $this->line["line_name"] = $this->line_name;
        $this->line["line_description"] = $this->line_description;
        $this->line["line_link"] = $this->line_link;
    }

    private function verificaDadosObrigatorios() {
        $obrigatorios = array("line_name");
        foreach ($obrigatorios as $value):
            if (!isset($this->line[$value]) || empty($this->line[$value]) || $this->line == ""):
                throw new Exception("{$value} é um campo obrigatório e não foi fornecido.", E_USER_ERROR);
            endif;
        endforeach;
    }

    /*
     * Método responsável por veríficar cada campo que não pode se repetir no BD
     * Caso encontre algum dado já existente ele lança uma excessão
     */

    private function verificaDuplicidade() {
        parent::getLineByName(trim($this->line_name));
        if (parent::getComprimentoUltimaListaRetornada() >= 1):
            throw new Exception("Já existe uma linha de produtos cadastrada com o nome <b> {$this->line_name} </b> .", E_USER_ERROR);

        endif;
    }

    private function preparaLinhasParaLista() {
        foreach ($this->allLines as $key => $linha):
            unset($linha["line_link"]);
            $this->allLines[$key] = $linha;
        endforeach;
    }

    private function preparaColunasParaLista() {
        return array("Cód:", "Nome", "Descrição", "Criado", "Atualizado");
    }

}
