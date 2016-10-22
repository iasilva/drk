<?php

/**
 * Classe type [Model]
 * Model da tabela line_of_product, responsável pela alteração dos dados no banco de dados *
 * @version Alpha 0.1
 * @author Ivan Alves da Silva 
 * @name <b>ModelLineOfProduct</b> 
 * @copyright (c) 2016, Thirday DRK Technologia
 */
class ModelLineOfProduct {

    private $line_id;
    private $line_name;
    private $line_description;
    private $line_link;
    private $line_created_at;
    private $line_updated_at;

    /*     * ****************** ATRIBUTOS DE VERIFICAÇÃO******************* */

    const QTD_CAMPOS_TABELA = 3; //Apenas campos alteráveis
    const TABELA = "line_of_product";

    private $comprimentoUltimaListaRetornada; //Quantidade de itens retornado na última lista
    private $arrayDados; // Armazena os dados passados para salvar na tabela
    private $arrayDadosVerificado = false;
    private $err_msg;

    /*     * ******************MÉTODOS DE ENTRADA******************* */

    /**
     * Configura a classe com os dados.<br>
     * Necessário chamar método save() ou update() sem parâmetro após usar.
     * @param string $line_name
     * @param string $line_link
     * @param string $line_description    
     */
    protected function setLineOfProduct(string $line_name, string $line_description = "", string $line_link = "#") {
        $this->arrayDados["line_name"] = $line_name;
        $this->arrayDados["line_description"] = (!isset($line_description) || $line_description == "") ? null : (string) $line_description;
        $this->arrayDados["line_link"] = (!isset($line_link) || $line_link == "") ? "#" : (string) $line_link;
        $this->verificaArrayDadosLineOfProduct();
    }

    /**
     * Salva os dados do LineOfProduct no banco de dados.
     * Caso seja enviado um array com os dados ele salva direto, caso o array venha 
     * null ele procura os dados nos atributos.
     * <br>Se não enviar o array deve previamente ser utilizado o método setLineOfProduct<br>     *
     * @param array $dados - Array no padrão array(campo_bd=>valor) ou podem ser e
     * nviados apenas os dados desde que contenham cada coluna representada e na 
     * ordem correta:
     * <br><br><b> array(line_name,line_description,line_link);</b><br><br> 
     * @return bool Retorna True caso tudo ocorra da maneira correta e false caso não proceda a inserção dos dados na tabela
     */
    protected function save(array $dados = null) {
        //Caso tenha sido passado um array 
        if (isset($dados)):
            $this->arrayDados = $dados;
            $this->verificaArrayDadosLineOfProduct();
        endif;
        // Verifica inicialmente se foi passado a quantidade mínima de paâmetros no array
        if ($this->arrayDadosVerificado):
            //Trata o array e alimenta os atributos
            $this->trataArrayDados();
            $mysql = new Create();
            $this->arrayDados["line_created_at"] = date("Y-m-d H:i:s");
            $mysql->ExeCreate(self::TABELA, $this->arrayDados);
            return $mysql->getResult();
        else:
            throw new Exception("Array não passou na verificação! <br> Não foi possível concluir o salvamento na tabela " . self::TABELA, E_USER_ERROR);

        endif;
    }

    /*     * *******************************MÉTODOS DE CONSULTA*********************************************** */

    /**
     * <b>getLineOfProduct</b>
     * Método retorna um array com os dados de um determinado produto
     * @param int $line_id - Idendificador do produto no Banco de dados
     * @return array
     */
    protected function getLineOfProduct($line_id) {
        $read = new Read;
        $read->ExeRead(self::TABELA, "WHERE line_id=:line_id", "line_id=$line_id");
        $result = $read->getResult();
        $this->comprimentoUltimaListaRetornada = $read->getRowCount();
        $this->arrayDados = $result[0];
        $this->trataArrayDados();
        return $this;
    }

    /**
     * <b>listLineOfProduct</b>
     * Retorna uma matriz de LineOfProductes e suas características buscadas no banco de dados
     * @param String $cond - condição da lista <b>Ex. ('cat_id = :cat_id')</b>, parte da query de consulta
     * @param string $parse - string par=valor
     * @param String $orderBy - Ordem do retorno - sql
     * @param Int $limit  - Quantidade máxima de itens na matriz <b>Valor padrão = 30</b>
     */
    protected function listLineOfProduct($cond, $parse, $orderBy = "created_at DESC", $limit = 24, $offset = 0) {
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
    protected function listAllLinesOfProduct($orderBy, $limit = 30) {
        $read = new Read;
        $read->FullRead("SELECT * FROM " . self::TABELA . " ORDER BY {$orderBy} LIMIT {$limit}");
        $result = $read->getResult();
        $this->comprimentoUltimaListaRetornada = $read->getRowCount();
        return $result;
    }

    /**
     * <b>Consulta linha pelo nome</b>
     * Método retorna um array com os dados de um determinado produto
     * @param int $forn_id - Idendificador do produto no Banco de dados
     * @return array
     */
    protected function getLineByName($line_name) {
        $read = new Read;
        $read->ExeRead(self::TABELA, "WHERE line_name=:line_name", "line_name=$line_name");
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
     * Atualiza um LineOfProduct na tabela LineOfProducts
     * Antes deve setar um id.
     * @param array $dados - Dados [chave =>valor] Array no padrão array(campo_bd=>valor) 
     * ou podem ser enviados apenas os dados desde que contenham cada coluna representada 
     * e na ordem correta:
     * <br><br><b> array(line_name,line_description,line_link);</b><br><br> 
     * 
     * @return type
     */
    protected function update(array $dados = null) {
        //Caso tenha sido passado um array 
        if (isset($dados)):
            $this->arrayDados = $dados;
            $this->verificaArrayDadosLineOfProduct();
        endif;
        if (!isset($this->prod_id)):
            throw new Exception("Para atualizar, informe um line_id", E_USER_ERROR);
        endif;
        // Verifica inicialmente se foi passado a quantidade mínima de paâmetros no array
        if ($this->arrayDadosVerificado):
            //Trata o array e alimenta os atributos
            $this->trataArrayDados();
            $mysql = new Update();
            $this->arrayDados["line_updated_at"] = date("Y-m-d H:i:s");
            $mysql->ExeUpdate(self::TABELA, $this->arrayDados, "WHERE line_id=:line_id", "line_id={$this->line_id}");
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

        if (!isset($this->prod_id)):
            throw new Exception("Para atualizar, informe um line_id" . __CLASS__ . __LINE__, E_USER_ERROR);
        endif;

        $mysql = new Update();
        $this->arrayDados["line_updated_at"] = date("Y-m-d H:i:s");
        $mysql->ExeUpdate(self::TABELA, $dados, "WHERE line_id=:line_id", "line_id={$this->line_id}");
        return $mysql->getResult();
    }

    /*     * ****************************DELETE***************************** */

    protected function delete() {
        if (!isset($this->line_id)):
            throw new Exception("Para deletar, informe um line_id", E_USER_ERROR);
        endif;
        $mysql = new Delete();
        $mysql->ExeDelete(self::TABELA, "WHERE line_id=:line_id", "line_id={$this->line_id}");
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

    /*     * ********************SET SET SET SET********************* */

    protected function setLineId($line_id) {
        $this->line_id = $line_id;
        return $this;
    }

    /*     * ********************GET GET GET GET********************* */

    protected function getComprimentoUltimaListaRetornada() {
        return $this->comprimentoUltimaListaRetornada;
    }

    protected function getLine_id() {
        return $this->line_id;
    }

    protected function getLine_name() {
        return $this->line_name;
    }

    protected function getLine_description() {
        return $this->line_description;
    }

    protected function getLink_for_line() {
        return $this->link_for_line;
    }
    protected function getLine_link() {
        return $this->line_link;
    }
    protected function getLine_created_at() {
        return $this->line_created_at;
    }

    protected function getLine_updated_at() {
        return $this->line_updated_at;
    }

    
    
    /*     * **************************** Tratamento dos arrays****************************** */

    /**
     * Apenas verifica se o array enviado pode ou não ser considerado válido para inserção
     *
     */
    private function verificaArrayDadosLineOfProduct() {
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
        /* array(prod_description, prod_name, prod_price, line_id, cat_id, line_id, prod_stock, $line_weight=, $line_price_promo, $line_height,$line_length, $line_width); */
        if (isset($this->arrayDados[0])) :
            $this->line_name = (isset($this->arrayDados[0]) && is_string($this->arrayDados[0])) ? (string) $this->arrayDados[0] : die("Não podemos prosseguir sem o nome do LineOfProduct." . __FILE__ . "   " . __LINE__);
            $this->line_description = (isset($this->arrayDados[1]) && is_string($this->arrayDados[1])) ? (string) $this->arrayDados[1] : NULL;
            $this->line_link = (isset($this->arrayDados[2]) && is_string($this->arrayDados[2])) ? (string) $this->arrayDados[2] : NULL;

            //altera o array de dados para índice padrão
            $this->arrayDados = NULL;

            $this->arrayDados["line_name"] = $this->line_name;
            $this->arrayDados["line_description"] = $this->line_description;
            $this->arrayDados["line_link"] = $this->line_link;


        elseif (isset($this->arrayDados["line_created_at"])):
            $this->line_name = (isset($this->arrayDados["line_name"])) ? $this->arrayDados["line_name"] : die("Não podemos prosseguir sem o nome do LineOfProduct. Descrição inválida" . __FILE__ . "   " . __LINE__);
            $this->line_description = (isset($this->arrayDados["line_description"])) ? (string) $this->arrayDados["line_description"] : NULL;
            $this->line_link = (isset($this->arrayDados["line_link"])) ? (string) $this->arrayDados["line_link"] : NULL;
            $this->line_created_at = (isset($this->arrayDados["line_created_at"])) ? (string) $this->arrayDados["line_created_at"] : NULL;
            $this->line_updated_at = (isset($this->arrayDados["line_updated_at"])) ? (string) $this->arrayDados["line_updated_at"] : NULL;


        elseif (isset($this->arrayDados["line_description"]) || isset($this->arrayDados["line_name"])):
            $this->line_name = (isset($this->arrayDados["line_name"]) && is_string($this->arrayDados["line_name"])) ? $this->arrayDados["line_name"] : die("Não podemos prosseguir sem o nome do produto. Descrição inválida" . __FILE__ . "   " . __LINE__);
            $this->line_description = (isset($this->arrayDados["line_description"])) ? (string) $this->arrayDados["line_description"] : NULL;
            $this->line_link = (isset($this->arrayDados["line_link"])) ? (string) $this->arrayDados["line_link"] : NULL;

        endif;
    }

}
