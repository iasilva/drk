<?php

/**
 * Classe type [Model]
 * Model da tabela category, responsável pela alteração dos dados no banco de dados *
 * @version Alpha 0.1
 * @author Ivan Alves da Silva 
 * @name <b>ModelCategory</b> 
 * @copyright (c) 2016, Thirday DRK Technologia
 */
class ModelCategory {

    private $cat_id;
    private $cat_name;
    private $cat_description;
    private $cat_parent=0;
    private $cat_created_at;
    private $cat_updated_at;
    

    /*     * ****************** ATRIBUTOS DE VERIFICAÇÃO******************* */

    const QTD_CAMPOS_TABELA = 3; //Apenas campos alteráveis
    const TABELA = "category";

    private $comprimentoUltimaListaRetornada; //Quantidade de itens retornado na última lista
    private $arrayDados; // Armazena os dados passados para salvar na tabela
    private $arrayDadosVerificado = false;
    private $err_msg;

    /*     * ******************MÉTODOS DE ENTRADA******************* */

    /**
     * Configura a classe com os dados.<br>
     * Necessário chamar método save() ou update() sem parâmetro após usar.
     * @param string $cat_name
     * @param string $cat_parent - Categoria pai, padrão 0 
     * @param string $cat_description    
     */
    protected function setCategory(string $cat_name,$cat_parent=0 ,string $cat_description = "") {
        $this->arrayDados["cat_name"] = $cat_name;
        $this->arrayDados["cat_parent"] = (int) $cat_parent;
        $this->arrayDados["cat_description"] = (!isset($cat_description) || $cat_description == "") ? null : (string) $cat_description;       
        $this->verificaArrayDadosCategory();
    }

    /**
     * Salva os dados do Category no banco de dados.
     * Caso seja enviado um array com os dados ele salva direto, caso o array venha 
     * null ele procura os dados nos atributos.
     * <br>Se não enviar o array deve previamente ser utilizado o método setCategory<br>     *
     * @param array $dados - Array no padrão array(campo_bd=>valor) ou podem ser e
     * nviados apenas os dados desde que contenham cada coluna representada e na 
     * ordem correta:
     * <br><br><b> array(cat_name,cat_parent,cat_description);</b><br><br> 
     * @return bool Retorna True caso tudo ocorra da maneira correta e false caso não proceda a inserção dos dados na tabela
     */
    protected function save(array $dados = null) {
        //Caso tenha sido passado um array 
        if (isset($dados)):
            $this->arrayDados = $dados;
            $this->verificaArrayDadosCategory();
        endif;
        // Verifica inicialmente se foi passado a quantidade mínima de paâmetros no array
        if ($this->arrayDadosVerificado):
            //Trata o array e alimenta os atributos
            $this->trataArrayDados();
            $mysql = new Create();
            $this->arrayDados["cat_created_at"] = date("Y-m-d H:i:s");
            $mysql->ExeCreate(self::TABELA, $this->arrayDados);
            return $mysql->getResult();
        else:
            throw new Exception("Array não passou na verificação! <br> Não foi possível concluir o salvamento na tabela " . self::TABELA, E_USER_ERROR);

        endif;
    }

    /*     * *******************************MÉTODOS DE CONSULTA*********************************************** */

    /**
     * <b>getCategory</b>
     * Método retorna um array com os dados de um determinado produto
     * @param int $cat_id - Idendificador do produto no Banco de dados
     * @return array
     */
    protected function getCategory($cat_id) {
        $read = new Read;
        $read->ExeRead(self::TABELA, "WHERE cat_id=:cat_id", "cat_id=$cat_id");
        $result = $read->getResult();
        $this->comprimentoUltimaListaRetornada = $read->getRowCount();
        $this->arrayDados = $result[0];
        $this->trataArrayDados();
        return $this;
    }

    /**
     * <b>listCategory</b>
     * Retorna uma matriz de Categoryes e suas características buscadas no banco de dados
     * @param String $cond - condição da lista <b>Ex. ('cat_id = :cat_id')</b>, parte da query de consulta
     * @param string $parse - string par=valor
     * @param String $orderBy - Ordem do retorno - sql
     * @param Int $limit  - Quantidade máxima de itens na matriz <b>Valor padrão = 30</b>
     */
    protected function listCategory($cond, $parse, $orderBy = "created_at DESC", $limit = 24, $offset = 0) {
        $read = new Read;
        $sql = $this->prepareCondicao($cond, $offset);
        $parsePreparada = $this->prepareParseString($parse, $orderBy, $offset, $limit);
        $read->ExeRead(self::TABELA, $sql, $parsePreparada);
        $result = $read->getResult();
        $this->comprimentoUltimaListaRetornada = $read->getRowCount();
        return $result;
    }

    /**
     * 
     * @param string $orderBy - nome do campo da ordenação dos resultados
     * @param int $limit - Limit da consulta, default =30
     * @return array
     */
    protected function listAllCategories($orderBy, $limit = 30) {
        $read = new Read;
        $read->FullRead("SELECT * FROM " . self::TABELA . " ORDER BY {$orderBy} LIMIT {$limit}");
        $result = $read->getResult();
        $this->comprimentoUltimaListaRetornada = $read->getRowCount();
        return $result;
    }
     /**
     * <b>Consulta categoria pelo nome</b>
     * Método retorna um array com os dados de uma determinada categoria
     * @param string $cat_name - Idendificador do produto no Banco de dados
     * @return array
     */
    protected function getCategoryByName($cat_name) {
        $read = new Read;
        $read->ExeRead(self::TABELA, "WHERE cat_name=:cat_name", "cat_name=$cat_name");
        $result = $read->getResult();
        $this->comprimentoUltimaListaRetornada = $read->getRowCount();
        if ($this->comprimentoUltimaListaRetornada >= 1):
            $this->arrayDados = $result[0];
            $this->trataArrayDados();
            return $this;
        endif;
    }

    /*     * ****************************UPDADE***************************** */

    /**
     * Atualiza um Category na tabela Category
     * Antes deve setar um id.
     * @param array $dados - Dados [chave =>valor] Array no padrão array(campo_bd=>valor) 
     * ou podem ser enviados apenas os dados desde que contenham cada coluna representada 
     * e na ordem correta:
     * <br><br><b> array(cat_name,cat_parent,cat_description);</b><br><br> 
     * 
     * @return array resultado
     */
    protected function update(array $dados = null) {
        //Caso tenha sido passado um array 
        if (isset($dados)):
            $this->arrayDados = $dados;
            $this->verificaArrayDadosCategory();
        endif;
        if (!isset($this->prod_id)):
            throw new Exception("Para atualizar, informe um id da categoria", E_USER_ERROR);
        endif;
        // Verifica inicialmente se foi passado a quantidade mínima de paâmetros no array
        if ($this->arrayDadosVerificado):
            //Trata o array e alimenta os atributos
            $this->trataArrayDados();
            $mysql = new Update();
            $this->arrayDados["cat_updated_at"] = date("Y-m-d H:i:s");
            $mysql->ExeUpdate(self::TABELA, $this->arrayDados, "WHERE cat_id=:cat_id", "cat_id={$this->cat_id}");
            return $mysql->getResult();
        else:
            throw new Exception("Array não passou na verificação! para atualizar" . __CLASS__ . __LINE__, E_USER_ERROR);

        endif;
    }

    /**
     * Atualiza os campos passados por array
     * @param array $dados - dados no formato chave=>valor apenas dos campos a serem atualizados
     * @return int com a quantidade de linhas afetadas
     * @throws Exception
     */
    protected function updateSimple(array $dados) {

        if (!isset($this->cat_id)):
            throw new Exception("Para atualizar, informe um cat_id" . __CLASS__ . __LINE__, E_USER_ERROR);
        endif;

        $mysql = new Update();
        $this->arrayDados["cat_updated_at"] = date("Y-m-d H:i:s");
        $mysql->ExeUpdate(self::TABELA, $dados, "WHERE cat_id=:cat_id", "cat_id={$this->cat_id}");
        return $mysql->getResult();
    }

    /*     * ****************************DELETE***************************** */

    protected function delete() {
        if (!isset($this->cat_id)):
            throw new Exception("Para deletar, informe um cat_id", E_USER_ERROR);
        endif;
        $mysql = new Delete();
        $mysql->ExeDelete(self::TABELA, "WHERE cat_id=:cat_id", "cat_id={$this->cat_id}");
        return $mysql->getResult();
    }

    /*     * *************************Tratamentos pré consulta********************** */

    /**
     * Prepara o SQL da consulta
     * @param string $cond
     * @param int $offset
     * @return string
     */
    private function prepareCondicao($cond, $offset) {
        $sql = " WHERE {$cond}";
        $sql.=" ORDER BY :orderby";
        $sql.=" LIMIT :limit";
        if (is_int($offset) && $offset > 0):
            $sql.=" OFFSET :offset";
        endif;
        return $sql;
    }

    /**
     * Prepara a String Parse para o PDO substituir
     * @param type $parse
     * @param type $orderBy
     * @param type $offset
     * @param type $limit
     * @return string
     */
    private function prepareParseString($parse, $orderBy, $offset, $limit) {
        $parseFull = $parse;
        $parseFull.="&orderby=" . $orderBy;
        $parseFull.="&limit=" . $limit;
        if (is_int($offset) && $offset > 0):
            $parseFull.="&offset=" . $offset;
        endif;
        return $parseFull;
    }

    /**********************SET SET SET SET********************* */

    protected function setCatId($cat_id) {
        $this->cat_id = $cat_id;
        return $this;
    }

    /*     * ********************GET GET GET GET********************* */

    protected function getComprimentoUltimaListaRetornada() {
        return $this->comprimentoUltimaListaRetornada;
    }

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

    
    /*     * **************************** Tratamento dos arrays****************************** */

    /**
     * Apenas verifica se o array enviado pode ou não ser considerado válido para inserção
     *
     */
    private function verificaArrayDadosCategory() {
        //Verifica inicialmente se possui a quantidade de campos pré determinados
        if (!$this->arrayDadosVerificado):
            $this->arrayDadosVerificado = (count($this->arrayDados) == 
                    self::QTD_CAMPOS_TABELA) ? TRUE : FALSE;
        endif;
    }

    /**
     * Método que faz a correta alocação dos dados do array passado para os atributos 
     */
    private function trataArrayDados() {
        /* array(prod_description, prod_name, prod_price, cat_id, cat_id, cat_id, prod_stock, $cat_weight=, $cat_price_promo, $cat_height,$cat_length, $cat_width); */
        if (isset($this->arrayDados[0])) :
            $this->cat_name = (isset($this->arrayDados[0]) && is_string($this->arrayDados[0])) ? (string) $this->arrayDados[0] : die("Não podemos prosseguir sem o nome do Category." . __FILE__ . "   " . __LINE__);
            $this->cat_parent = (isset($this->arrayDados[1]) && (is_int($this->arrayDados[1]) || is_float($this->arrayDados[1]))) ? (int) $this->arrayDados[1] : NULL;
            $this->cat_description = (isset($this->arrayDados[2]) && is_string($this->arrayDados[2])) ? (string) $this->arrayDados[2] : NULL;

            //altera o array de dados para índice padrão
            $this->arrayDados = NULL;

            $this->arrayDados["cat_name"] = $this->cat_name;
            $this->arrayDados["cat_parent"] = $this->cat_parent;
            $this->arrayDados["cat_description"] = $this->cat_description;


        elseif (isset($this->arrayDados["cat_created_at"])):
            $this->cat_name = (isset($this->arrayDados["cat_name"])) ? $this->arrayDados["cat_name"] : die("Não podemos prosseguir sem o nome do Category. Descrição inválida" . __FILE__ . "   " . __LINE__);
            $this->cat_parent = (isset($this->arrayDados["cat_parent"])) ? (int) $this->arrayDados["cat_parent"] : NULL;
            $this->cat_description = (isset($this->arrayDados["cat_description"])) ? (string) $this->arrayDados["cat_description"] : NULL;
            $this->cat_created_at = (isset($this->arrayDados["cat_created_at"])) ? (string) $this->arrayDados["cat_created_at"] : NULL;
            $this->cat_updated_at = (isset($this->arrayDados["cat_updated_at"])) ? (string) $this->arrayDados["cat_updated_at"] : NULL;


        elseif (isset($this->arrayDados["cat_description"]) || isset($this->arrayDados["cat_name"])):
            $this->cat_name = (isset($this->arrayDados["cat_name"]) && is_string($this->arrayDados["cat_name"])) ? $this->arrayDados["cat_name"] : die("Não podemos prosseguir sem o nome do produto. Descrição inválida" . __FILE__ . "   " . __LINE__);
            $this->cat_parent = (isset($this->arrayDados["cat_parent"]) && (is_float($this->arrayDados["cat_parent"]) || is_integer($this->arrayDados["cat_parent"]))) ? (int) $this->arrayDados["cat_parent"] : NULL;
            $this->cat_description = (isset($this->arrayDados["cat_description"])) ? (string) $this->arrayDados["cat_description"] : NULL;
            endif;
    }

}
