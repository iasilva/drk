<?php

/**
 * Classe type [Model]
 * Model da tabela Product, responsável pela alteração dos dados no banco de dados *
 * @version Alpha 0.1
 * @author Ivan Alves da Silva 
 * @name <b>ModelFornecedor</b>
 * @copyright (c) 2016, Thirday DRK Technologia
 */
class ModelFornecedor {
    /*     * ****************** ATRIBUTOS DO MODELO******************* */

    private $forn_id; //Id   
    private $forn_name; //Nome
    private $forn_doc; //CPF ou CNPJ
    private $forn_tel; //Tel de contato 
    private $forn_created_at; // Data de registro do fornecedor
    private $forn_updated_at; //última atualização

    /*     * ****************** ATRIBUTOS DE VERIFICAÇÃO******************* */

    const QTD_CAMPOS_TABELA = 3; //Apenas campos alteráveis
    const TABELA = "fornecedor";

    private $comprimentoUltimaListaRetornada; //Quantidade de itens retornado na última lista
    private $arrayDados; // Armazena os dados passados para salvar na tabela
    private $arrayDadosVerificado = false;
    private $err_msg;

    /*     * ******************MÉTODOS DE ENTRADA******************* */

    /**
     * Configura a classe com os dados.<br>
     * Necessário chamar método save() ou update() sem parâmetro após usar.
     * @param string $forn_name
     * @param string $forn_doc
     * @param string $forn_tel    
     */
    protected function setFornecedor(string $forn_name, string $forn_tel = "", string $forn_doc = "") {
        $this->arrayDados["forn_name"] = $forn_name;
        $this->arrayDados["forn_tel"] = (!isset($forn_tel) || $forn_tel == "") ? null : (string) $forn_tel;
        $this->arrayDados["forn_doc"] = (!isset($forn_doc) || $forn_doc == "") ? null : (string) $forn_doc;
        $this->verificaArrayDadosDoFornecedor();
    }

    /**
     * Salva os dados do fornecedor no banco de dados.
     * Caso seja enviado um array com os dados ele salva direto, caso o array venha 
     * null ele procura os dados nos atributos.
     * <br>Se não enviar o array deve previamente ser utilizado o método setFornecedor<br>     *
     * @param array $dados - Array no padrão array(campo_bd=>valor) ou podem ser e
     * nviados apenas os dados desde que contenham cada coluna representada e na 
     * ordem correta:
     * <br><br><b> array(forn_name,forn_tel,forn_doc);</b><br><br> 
     * @return bool Retorna True caso tudo ocorra da maneira correta e false caso não proceda a inserção dos dados na tabela
     */
    protected function save(array $dados = null) {
        //Caso tenha sido passado um array 
        if (isset($dados)):
            $this->arrayDados = $dados;
            $this->verificaArrayDadosDoFornecedor();
        endif;
        // Verifica inicialmente se foi passado a quantidade mínima de paâmetros no array
        if ($this->arrayDadosVerificado):
            //Trata o array e alimenta os atributos
            $this->trataArrayDados();
            $mysql = new Create();
            $this->arrayDados["forn_created_at"] = date("Y-m-d H:i:s");
            $mysql->ExeCreate(self::TABELA, $this->arrayDados);
            return $mysql->getResult();
        else:
            drkMsg("Array não passou na verificação!", E_USER_ERROR);
        endif;
    }

    /*     * *******************************MÉTODOS DE CONSULTA*********************************************** */

    /**
     * <b>getFornecedor</b>
     * Método retorna um array com os dados de um determinado produto
     * @param int $forn_id - Idendificador do produto no Banco de dados
     * @return array
     */
    protected function getFornecedor($forn_id) {
        $read = new Read;
        $read->ExeRead(self::TABELA, "WHERE forn_id=:forn_id", "forn_id=$forn_id");
        $result = $read->getResult();
        $this->comprimentoUltimaListaRetornada = $read->getRowCount();
        $this->arrayDados = $result[0];
        $this->trataArrayDados();
        return $this;
    }

    /**
     * <b>Consulta fornecedor pelo nome</b>
     * Método retorna um array com os dados de um determinado produto
     * @param int $forn_id - Idendificador do produto no Banco de dados
     * @return array
     */
    protected function getFornecedorByName($forn_name) {
        $read = new Read;
        $read->ExeRead(self::TABELA, "WHERE forn_name=:forn_name", "forn_name=$forn_name");
        $result = $read->getResult();
        $this->comprimentoUltimaListaRetornada = $read->getRowCount();
        if ($this->comprimentoUltimaListaRetornada >= 1):
            $this->arrayDados = $result[0];
            $this->trataArrayDados();
            return $this;
        endif;
    }

    /**
     * <b>listFornecedores</b>
     * Retorna uma matriz de fornecedores e suas características buscadas no banco de dados
     * @param String $cond - condição da lista <b>Ex. ('cat_id = :cat_id')</b>, parte da query de consulta
     * @param string $parse - string par=valor
     * @param String $orderBy - Ordem do retorno - sql
     * @param Int $limit  - Quantidade máxima de itens na matriz <b>Valor padrão = 30</b>
     */
    protected function listFornecedores($cond, $parse, $orderBy = "created_at DESC", $limit = 24, $offset = 0) {
        $read = new Read;
        $sql = $this->prepareCondicao($cond, $offset);
        $parse = $this->prepareParseString($parse, $orderBy, $offset, $limit);
        $read->ExeRead(self::TABELA, $sql, $parse);
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
    protected function listAllFornecedores($orderBy, $limit = 30) {
        $read = new Read;
        $read->FullRead("SELECT * FROM fornecedor ORDER BY $orderBy LIMIT $limit");
        $result = $read->getResult();
        $this->comprimentoUltimaListaRetornada = $read->getRowCount();
        return $result;
    }

    /*     * ****************************UPDADE***************************** */

    /**
     * Atualiza um fornecedor na tabela fornecedores
     * Antes deve setar um id.
     * @param array $dados - Dados [chave =>valor] Array no padrão array(campo_bd=>valor) 
     * ou podem ser enviados apenas os dados desde que contenham cada coluna representada 
     * e na ordem correta:
     * <br><br><b> array(forn_name,forn_tel,forn_doc);</b><br><br> 
     * 
     * @return type
     */
    protected function update(array $dados = null) {
        //Caso tenha sido passado um array 
        if (isset($dados)):
            $this->arrayDados = $dados;
            $this->verificaArrayDadosDoFornecedor();
        endif;
        if (!isset($this->prod_id)):
            throw new Exception("Para atualizar, informe um forn_id", E_USER_ERROR);
        endif;
        // Verifica inicialmente se foi passado a quantidade mínima de paâmetros no array
        if ($this->arrayDadosVerificado):
            //Trata o array e alimenta os atributos
            $this->trataArrayDados();
            $mysql = new Update();
            $this->arrayDados["forn_updated_at"] = date("Y-m-d H:i:s");
            $mysql->ExeUpdate(self::TABELA, $this->arrayDados, "WHERE forn_id=:forn_id", "forn_id={$this->forn_id}");
            return $mysql->getResult();
        else:
            drkMsg("Array não passou na verificação!", E_USER_ERROR);
        endif;
    }

    /**
     * Atualiza os campos passados por array
     * @param array $dados - dados no formato chave=>valor apenas dos campos a serem atualizados
     * @return int com a quantidade de linhas afetadas
     * @throws Exception
     */
    protected function updateSimple(array $dados) {

        if (!isset($this->prod_id)):
            throw new Exception("Para atualizar, informe um forn_id", E_USER_ERROR);
        endif;

        $mysql = new Update();
        $this->arrayDados["forn_updated_at"] = date("Y-m-d H:i:s");
        $mysql->ExeUpdate(self::TABELA, $dados, "WHERE forn_id=:forn_id", "forn_id={$this->forn_id}");
        return $mysql->getResult();
    }

    /*     * ****************************DELETE***************************** */

    protected function delete() {
        if (!isset($this->forn_id)):
            throw new Exception("Para deletar, informe um forn_id", E_USER_ERROR);
        endif;
        $mysql = new Delete();
        $mysql->ExeDelete(self::TABELA, "WHERE forn_id=:forn_id", "forn_id={$this->forn_id}");
        return $mysql->getResult();
    }

    /*     * *************************Tratamentos pré consulta********************** */

    /**
     * Prepara o SQL da consulta
     * @param string $cond
     * @param int $orderBy
     * @param int $offset
     * @param int $limit
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

    /*     * ********************SET SET SET SET********************* */

    protected function setForn_id($forn_id) {
        $this->forn_id = $forn_id;
        return $this;
    }

    /*     * ********************GET GET GET GET********************* */

    protected function getComprimentoUltimaListaRetornada() {
        return $this->comprimentoUltimaListaRetornada;
    }

    protected function getForn_id() {
        return $this->forn_id;
    }

    protected function getForn_name() {
        return $this->forn_name;
    }

    protected function getForn_doc() {
        return $this->forn_doc;
    }

    protected function getForn_tel() {
        return $this->forn_tel;
    }

    protected function getForn_created_at() {
        return $this->forn_created_at;
    }

    protected function getForn_updated_at() {
        return $this->forn_updated_at;
    }

    protected function getErr_msg() {
        return $this->err_msg;
    }

    /*     * **************************** Tratamento dos arrays****************************** */

    /**
     * Apenas verifica se o array enviado pode ou não ser considerado válido para inserção
     *
     */
    private function verificaArrayDadosDoFornecedor() {
        //Verifica inicialmente se possui 12 campos
        if (!$this->arrayDadosVerificado):
            $this->arrayDadosVerificado = (count($this->arrayDados) == self::QTD_CAMPOS_TABELA) ? TRUE : FALSE;
        endif;
    }

    /**
     * Método que faz a correta alocação dos dados do array passado para os atributos 
     */
    private function trataArrayDados() {
        /* array(prod_description, prod_name, prod_price, line_id, cat_id, forn_id, prod_stock, $forn_weight=, $forn_price_promo, $forn_height,$forn_length, $forn_width); */
        if (isset($this->arrayDados[0])) :
            $this->forn_name = (isset($this->arrayDados[0]) && is_string($this->arrayDados[0])) ? (string) trim($this->arrayDados[0]) : die("Não podemos prosseguir sem o nome do fornecedor." . __FILE__ . "   " . __LINE__);
            $this->forn_tel = (isset($this->arrayDados[1]) && is_string($this->arrayDados[1])) ? (string) trim($this->arrayDados[1]) : NULL;
            $this->forn_doc = (isset($this->arrayDados[2]) && is_string($this->arrayDados[2])) ? (string) trim($this->arrayDados[2]) : NULL;

            //altera o array de dados para índice padrão
            $this->arrayDados = NULL;

            $this->arrayDados["forn_name"] = $this->forn_name;
            $this->arrayDados["forn_tel"] = $this->forn_tel;
            $this->arrayDados["line_doc"] = $this->forn_doc;


        elseif (isset($this->arrayDados["forn_created_at"])):
            $this->forn_name = (isset($this->arrayDados["forn_name"])) ? $this->arrayDados["forn_name"] : die("Não podemos prosseguir sem o nome do fornecedor. Descrição inválida" . __FILE__ . "   " . __LINE__);
            $this->forn_tel = (isset($this->arrayDados["forn_tel"])) ? (string) $this->arrayDados["forn_tel"] : NULL;
            $this->forn_doc = (isset($this->arrayDados["forn_doc"])) ? (string) $this->arrayDados["forn_doc"] : NULL;
            $this->forn_created_at = (isset($this->arrayDados["forn_created_at"])) ? (string) $this->arrayDados["forn_created_at"] : NULL;
            $this->forn_updated_at = (isset($this->arrayDados["forn_updated_at"])) ? (string) $this->arrayDados["forn_updated_at"] : NULL;


        elseif (isset($this->arrayDados["forn_description"]) || isset($this->arrayDados["forn_name"])):
            $this->forn_name = (isset($this->arrayDados["forn_name"]) && is_string($this->arrayDados["forn_name"])) ? (string) trim($this->arrayDados["forn_name"]) : die("Não podemos prosseguir sem o nome do produto. Descrição inválida" . __FILE__ . "   " . __LINE__);
            $this->forn_tel = (isset($this->arrayDados["forn_tel"]) && ((is_string($this->arrayDados["forn_name"])) || is_float($this->arrayDados["forn_tel"]) || is_integer($this->arrayDados["forn_tel"]))) ? (string) trim($this->arrayDados["forn_tel"]) : NULL;
            $this->forn_doc = (isset($this->arrayDados["forn_doc"]) && ((is_string($this->arrayDados["forn_name"])) || is_float($this->arrayDados["forn_doc"]) || is_integer($this->arrayDados["forn_doc"]))) ? (string) trim($this->arrayDados["forn_doc"]) : NULL;

        endif;
    }

}
