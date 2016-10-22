<?php

/**
 * Classe type [Model]
 * Model da tabela Product, responsável pela alteração dos dados no banco de dados *
 * @version Alpha 0.1
 * @author Ivan Alves da Silva 
 * @name <b>ModelProdruct</b>
 * @copyright (c) 2016, Thirday DRK Technologia
 */
class ModelProduct {
    /*     * ****************** ATRIBUTOS DO MODELO******************* */

    private $prod_id; //Id
    private $prod_description; //Descrição
    private $prod_name; //Nome
    private $prod_price; //Preço
    private $prod_price_promo; //Preço de promoção se houver
    private $prod_weight; //Peso
    private $prod_height; // Altura
    private $prod_length; //Comprimento
    private $prod_stock; //Quantidade em estoque
    private $prod_width; //Largura
    private $line_id; //Id da linha de produto ao qual está vinculado
    private $cat_id; //Id da Categoria ao qual o produto está vinculado
    private $forn_id; // Id do Fornecedor do Produto   
    private $prod_created_at; // Data de criação do produto
    private $prod_updated_at;

    /*     * ****************** ATRIBUTOS DE VERIFICAÇÃO******************* */

    const QTD_CAMPOS_TABELA = 12; //Apenas campos alteráveis
    const TABELA = "product";

    private $comprimentoUltimaListaRetornada; //Quantidade de itens retornado na última lista
    private $arrayDados;
    private $arrayDadosVerificado = false;
    private $err_msg;

    /*     * ******************MÉTODOS DE ENTRADA******************* */

    /**
     * Configura a classe com os dados.<br>
     * Necessário chamar método save() ou update() sem parâmetro após usar.
     * @param string $prod_description
     * @param string $prod_name
     * @param float $prod_price
     * @param int $line_id
     * @param int $cat_id
     * @param int $forn_id
     * @param float $prod_stock
     * @param float $prod_weight
     * @param float $prod_price_promo
     * @param float $prod_height
     * @param float $prod_length
     * @param float $prod_width
     */
    public function setProduct(string $prod_description, string $prod_name, float $prod_price, int $line_id, int $cat_id, int $forn_id, $prod_stock = "", $prod_weight = "", $prod_price_promo = "", $prod_height = "", $prod_length = "", $prod_width = "") {
        $this->arrayDados["prod_description"] = $prod_description;
        $this->arrayDados["prod_name"] = $prod_name;
        $this->arrayDados["prod_price"] = $prod_price;
        $this->arrayDados["line_id"] = $line_id;
        $this->arrayDados["cat_id"] = $cat_id;
        $this->arrayDados["forn_id"] = $forn_id;
        $this->arrayDados["prod_stock"] = (!isset($prod_stock) || $prod_stock == "") ? null : (int) $prod_stock;
        $this->arrayDados["prod_weight"] = (!isset($prod_weight) || $prod_weight == "") ? null : (float) $prod_weight;
        $this->arrayDados["prod_price_promo"] = (!isset($prod_price_promo) || $prod_price_promo == "") ? null : (float) $prod_price_promo;
        $this->arrayDados["prod_height"] = (!isset($prod_height) || $prod_height == "") ? null : (float) $prod_height;
        $this->arrayDados["prod_length"] = (!isset($prod_length) || $prod_length == "") ? null : (float) $prod_length;
        $this->arrayDados["prod_width"] = (!isset($prod_width) || $prod_width == "") ? null : (float) $prod_width;
        $this->verificaArrayDadosDoProduto();
    }

    /**
     * Salva os dados do produto no banco de dados.
     * Caso seja enviado um array com os dados ele salva direto, caso o array venha null ele procura os dados nos atributos.
     * <br>Se não enviar o array deve previamente ser utilizado o método setProduct<br>
     *
     * @param array $dados - Array no padrão array(campo_bd=>valor) ou podem ser enviados apenas os dados desde que contenham cada coluna representada e na ordem correta:
     * <br><br><b> array(prod_description, prod_name, prod_price, line_id, cat_id, forn_id, prod_stock, $prod_weight=, $prod_price_promo, $prod_height,$prod_length, $prod_width);</b><br><br> 
     * @return bool Retorna True caso tudo ocorra da maneira correta e false caso não proceda a inserção dos dados na tabela
     */
    protected function save(array $dados = null) {
        //Caso tenha sido passado um array 
        if (isset($dados)):
            $this->arrayDados = $dados;
            $this->verificaArrayDadosDoProduto();
        endif;
        // Verifica inicialmente se foi passado a quantidade mínima de paâmetros no array
        if ($this->arrayDadosVerificado):
            //Trata o array e alimenta os atributos
            $this->trataArrayDados();
            $mysql = new Create();
            $this->arrayDados["prod_created_at"] = date("Y-m-d H:i:s");
            $mysql->ExeCreate(self::TABELA, $this->arrayDados);
            return $mysql->getResult();
        else:
            drkMsg("Array não passou na verificação!", E_USER_ERROR);
        endif;
    }

    /*     * *******************************MÉTODOS DE CONSULTA*********************************************** */

    /**
     * <b>getProduct</b>
     * Método retorna um array com os dados de um determinado produto
     * @param int $prod_id - Idendificador do produto no Banco de dados
     * @return array
     */
    protected function getProduct($prod_id) {
        $read = new Read;
        $read->ExeRead(self::TABELA, "WHERE prod_id = :prod_id", "prod_id={$prod_id}");
        $result = $read->getResult();
        $this->comprimentoUltimaListaRetornada = $read->getRowCount();
        if (isset($result[0])):
            $this->arrayDados = $result[0];
            $this->trataArrayDados();
            return $this;
        else:
            throw new Exception("Não existe produto com o código $prod_id", E_USER_ERROR);
        endif;
    }

    /**
     * <b>listProducts</b>
     * Retorna uma matriz de produtos e suas características buscadas no banco de dados
     * @param String $cond - condição da lista <b>Ex. ('cat_id = 1')</b>, parte da query de consulta
     * @param String $orderBy - Ordem do retorno - sql
     * @param Int $limit  - Quantidade máxima de itens na matriz <b>Valor padrão = 30</b>
     */
    protected function listProducts($cond, $parse, $orderBy = "created_at DESC", $limit = 24, $offset = 0) {
        $read = new Read;
        $sql = $this->prepareCondicao($cond, $orderBy, $offset, $limit);
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
    protected function listAllProducts($orderBy, $limit = 30) {
        $read = new Read;
        $read->FullRead("SELECT * FROM product ORDER BY $orderBy LIMIT $limit");
        $result = $read->getResult();
        $this->comprimentoUltimaListaRetornada = $read->getRowCount();
        return $result;
    }

    /**
     * Retorna um array com com produtos pela categoria informada.<br><br>
     * Ao final configura o atributo <b>comprimentoUltimaListaRetornada</b> com a quantidade 
     * de linhas encontradas  
     * @param int $cat_id id da categoria
     * @param int $limit número de produtos retornados 
     */
    protected function listByCategory(int $cat_id, int $limit, int $offset) {
        $orderBy = "created_at DESC";
        $sql = $this->prepareCondicao("cat_id = :cat_id", $offset, $limit);
        $parse = $this->prepareParseString("cat_id=$cat_id", $orderBy, $offset, $limit);
        $read = new Read;
        $read->ExeRead(self::TABELA, $sql, $parse);
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
    protected function getProductByName($prod_name) {
        $read = new Read;
        $read->ExeRead(self::TABELA, "WHERE prod_name=:prod_name", "prod_name=$prod_name");
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
     * Atualiza um produto na tabela produtos
     * Antes deve setar um id.
     * @param array $dados - Dados [chave =>valor] Array no padrão array(campo_bd=>valor) ou podem ser enviados apenas os dados desde que contenham cada coluna representada e na ordem correta:
     * <br><br><b> array(prod_description, prod_name, prod_price, line_id, cat_id, forn_id, prod_stock, $prod_weight=, $prod_price_promo, $prod_height,$prod_length, $prod_width);</b><br><br> 
     * 
     * @return type
     */
    public function update(array $dados = null) {
        //Caso tenha sido passado um array 
        if (isset($dados)):
            $this->arrayDados = $dados;            
            $this->verificaArrayDadosDoProduto();

        endif;
        if (!isset($this->prod_id)):
            throw new Exception("Para atualizar, informe um prod_id", E_USER_ERROR);
        endif;
        // Verifica inicialmente se foi passado a quantidade mínima de paâmetros no array
        if ($this->arrayDadosVerificado):
            //Trata o array e alimenta os atributos
            $this->trataArrayDados();
            $mysql = new Update();
            $this->arrayDados["prod_updated_at"] = date("Y-m-d H:i:s");            
            $mysql->ExeUpdate(self::TABELA, $this->arrayDados, "WHERE prod_id=:prod_id", "prod_id={$this->prod_id}");
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
    public function updateSimple(array $dados) {

        if (!isset($this->prod_id)):
            throw new Exception("Para atualizar, informe um prod_id", E_USER_ERROR);
        endif;

        $mysql = new Update();
        $this->dados["prod_updated_at"] = date("Y-m-d H:i:s");
        $mysql->ExeUpdate(self::TABELA, $dados, "WHERE prod_id=:prod_id", "prod_id={$this->prod_id}");
        return $mysql->getResult();
    }

    /*     * ****************************DELETE***************************** */

    public function delete() {
        if (!isset($this->prod_id)):
            throw new Exception("Para deletar, informe um prod_id", E_USER_ERROR);
        endif;
        $mysql = new Delete();
        $mysql->ExeDelete(self::TABELA, "WHERE prod_id=:prod_id", "prod_id={$this->prod_id}");
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
    private function prepareCondicao($cond, $offset, $limit) {
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

    public function setProd_id($prod_id) {
        $this->prod_id = $prod_id;
        return $this;
    }

    /*     * ********************GET GET GET GET********************* */

    public function getComprimentoUltimaListaRetornada() {
        return $this->comprimentoUltimaListaRetornada;
    }

    public function getProd_id() {
        return $this->prod_id;
    }

    public function getProd_description() {
        return $this->prod_description;
    }

    public function getProd_name() {
        return $this->prod_name;
    }

    public function getProd_price() {
        return $this->prod_price;
    }

    public function getProd_price_promo() {
        return $this->prod_price_promo;
    }

    public function getProd_weight() {
        return $this->prod_weight;
    }

    public function getProd_height() {
        return $this->prod_height;
    }

    public function getProd_length() {
        return $this->prod_length;
    }

    public function getProd_stock() {
        return $this->prod_stock;
    }

    public function getProd_width() {
        return $this->prod_width;
    }

    public function getLine_id() {
        return $this->line_id;
    }

    public function getCat_id() {
        return $this->cat_id;
    }

    public function getForn_id() {
        return $this->forn_id;
    }

    public function getProd_created_at() {
        return $this->prod_created_at;
    }

    public function getProd_updated_at() {
        return $this->prod_updated_at;
    }

    public function getErr_msg() {
        return $this->err_msg;
    }

    /*     * **************************** Tratamento dos arrays****************************** */

    /**
     * Apenas verifica se o array enviado pode ou não ser considerado válido para inserção
     *
     */
    private function verificaArrayDadosDoProduto() {
        //Verifica inicialmente se possui 12 campos
        if (!$this->arrayDadosVerificado):
            $this->arrayDadosVerificado = (count($this->arrayDados) == self::QTD_CAMPOS_TABELA) ? TRUE : FALSE;
        endif;
    }

    /**
     * Método que faz a correta alocação dos dados do array passado para os atributos 
     */
    private function trataArrayDados() {
        /* array(prod_description, prod_name, prod_price, line_id, cat_id, forn_id, prod_stock, $prod_weight=, $prod_price_promo, $prod_height,$prod_length, $prod_width); */
        if (isset($this->arrayDados[0])) :
            $this->prod_description = (isset($this->arrayDados[0]) && is_string($this->arrayDados[0])) ? $this->arrayDados[0] : die("Não podemos prosseguir sem a descrição do produto." . __FILE__ . "   " . __LINE__);
            $this->prod_name = (isset($this->arrayDados[1]) && is_string($this->arrayDados[1])) ? $this->arrayDados[1] : die("Não podemos prosseguir sem o nome do produto. Nome inválido" . __FILE__ . "   " . __LINE__);
            $this->prod_price = (isset($this->arrayDados[2]) && (is_float($this->arrayDados[2]) || is_integer($this->arrayDados[2]))) ? (float) $this->arrayDados[2] : die("Não podemos prosseguir sem o preço do produto." . __FILE__ . "   " . __LINE__);
            $this->line_id = (isset($this->arrayDados[3]) && is_integer($this->arrayDados[3])) ? $this->arrayDados[3] : die("Não podemos prosseguir sem o id da linha do produto." . __FILE__ . "   " . __LINE__);
            $this->cat_id = (isset($this->arrayDados[4]) && is_integer($this->arrayDados[4])) ? $this->arrayDados[4] : die("Não podemos prosseguir sem o id da categoria do produto." . __FILE__ . "   " . __LINE__);
            $this->forn_id = (isset($this->arrayDados[5]) && is_integer($this->arrayDados[5])) ? $this->arrayDados[5] : die("Não podemos prosseguir sem o id do fornecedor." . __FILE__ . "   " . __LINE__);
            $this->prod_stock = (isset($this->arrayDados[6]) && is_integer($this->arrayDados[6])) ? $this->arrayDados[6] : NULL;
            $this->prod_weight = (isset($this->arrayDados[7]) && (is_float($this->arrayDados[7]) || is_integer($this->arrayDados[7]))) ? (float) $this->arrayDados[7] : NULL;
            $this->prod_price_promo = (isset($this->arrayDados[8]) && (is_float($this->arrayDados[8]) || is_integer($this->arrayDados[8]))) ? (float) $this->arrayDados[8] : NULL;
            $this->prod_height = (isset($this->arrayDados[9]) && (is_float($this->arrayDados[9]) || is_integer($this->arrayDados[9]))) ? (float) $this->arrayDados[9] : NULL;
            $this->prod_length = (isset($this->arrayDados[10]) && (is_float($this->arrayDados[10]) || is_integer($this->arrayDados[10]))) ? (float) $this->arrayDados[10] : NULL;
            $this->prod_width = (isset($this->arrayDados[11]) && (is_float($this->arrayDados[11]) || is_integer($this->arrayDados[11]))) ? (float) $this->arrayDados[11] : NULL;

            //altera o array de dados para índice padrão
            $this->arrayDados = NULL;

            $this->arrayDados["prod_description"] = $this->prod_description;
            $this->arrayDados["prod_name"] = $this->prod_name;
            $this->arrayDados["prod_price"] = $this->prod_price;
            $this->arrayDados["line_id"] = $this->line_id;
            $this->arrayDados["cat_id"] = $this->cat_id;
            $this->arrayDados["forn_id"] = $this->forn_id;
            $this->arrayDados["prod_stock"] = $this->prod_stock;
            $this->arrayDados["prod_weight"] = $this->prod_weight;
            $this->arrayDados["prod_price_promo"] = $this->prod_price_promo;
            $this->arrayDados["prod_height"] = $this->prod_height;
            $this->arrayDados["prod_length"] = $this->prod_length;
            $this->arrayDados["prod_width"] = $this->prod_width;

        elseif (isset($this->arrayDados["prod_created_at"])):
            $this->prod_description = (isset($this->arrayDados["prod_description"])) ? $this->arrayDados["prod_description"] : die("Não podemos prosseguir sem a descrição do produto." . __FILE__ . "   " . __LINE__);
            $this->prod_name = (isset($this->arrayDados["prod_name"])) ? $this->arrayDados["prod_name"] : die("Não podemos prosseguir sem o nome do produto. Descrição inválida" . __FILE__ . "   " . __LINE__);
            $this->prod_price = (isset($this->arrayDados["prod_price"])) ? (float) $this->arrayDados["prod_price"] : die("Não podemos prosseguir sem o preço do produto." . __FILE__ . "   " . __LINE__);
            $this->line_id = (isset($this->arrayDados["line_id"])) ? $this->arrayDados["line_id"] : die("Não podemos prosseguir sem o id da linha do produto." . __FILE__ . "   " . __LINE__);
            $this->cat_id = (isset($this->arrayDados["cat_id"])) ? $this->arrayDados["cat_id"] : die("Não podemos prosseguir sem o id da categoria do produto." . __FILE__ . "   " . __LINE__);
            $this->forn_id = (isset($this->arrayDados["forn_id"])) ? $this->arrayDados["forn_id"] : die("Não podemos prosseguir sem o id do fornecedor." . __FILE__ . "   " . __LINE__);
            $this->prod_stock = (isset($this->arrayDados["prod_stock"])) ? $this->arrayDados["prod_stock"] : NULL;
            $this->prod_weight = (isset($this->arrayDados["prod_weight"])) ? (float) $this->arrayDados["prod_weight"] : NULL;
            $this->prod_price_promo = (isset($this->arrayDados["prod_price_promo"])) ? (float) $this->arrayDados["prod_price_promo"] : NULL;
            $this->prod_height = (isset($this->arrayDados["prod_height"])) ? (float) $this->arrayDados["prod_height"] : NULL;
            $this->prod_length = (isset($this->arrayDados["prod_length"])) ? (float) $this->arrayDados["prod_length"] : NULL;
            $this->prod_width = (isset($this->arrayDados["prod_width"])) ? (float) $this->arrayDados["prod_width"] : NULL;
            $this->prod_created_at = (isset($this->arrayDados["prod_created_at"])) ? (string) $this->arrayDados["prod_created_at"] : NULL;
            $this->prod_updated_at = (isset($this->arrayDados["prod_updated_at"])) ? (string) $this->arrayDados["prod_updated_at"] : NULL;


        elseif (isset($this->arrayDados["prod_description"]) || isset($this->arrayDados["prod_name"])):
            $this->prod_description = (isset($this->arrayDados["prod_description"]) && is_string($this->arrayDados["prod_description"])) ? $this->arrayDados["prod_description"] : die("Não podemos prosseguir sem a descrição do produto." . __FILE__ . "   " . __LINE__);
            $this->prod_name = (isset($this->arrayDados["prod_name"]) && is_string($this->arrayDados["prod_name"])) ? $this->arrayDados["prod_name"] : die("Não podemos prosseguir sem o nome do produto. Descrição inválida" . __FILE__ . "   " . __LINE__);
            $this->prod_price = (isset($this->arrayDados["prod_price"]) && (is_float($this->arrayDados["prod_price"]) || is_integer($this->arrayDados["prod_price"]))) ? (float) $this->arrayDados["prod_price"] : die("Não podemos prosseguir sem o preço do produto." . __FILE__ . "   " . __LINE__);
            $this->line_id = (isset($this->arrayDados["line_id"]) && is_integer($this->arrayDados["line_id"])) ? $this->arrayDados["line_id"] : die("Não podemos prosseguir sem o id da linha do produto." . __FILE__ . "   " . __LINE__);
            $this->cat_id = (isset($this->arrayDados["cat_id"]) && is_integer($this->arrayDados["cat_id"])) ? $this->arrayDados["cat_id"] : die("Não podemos prosseguir sem o id da categoria do produto." . __FILE__ . "   " . __LINE__);
            $this->forn_id = (isset($this->arrayDados["forn_id"]) && is_integer($this->arrayDados["forn_id"])) ? $this->arrayDados["forn_id"] : die("Não podemos prosseguir sem o id do fornecedor." . __FILE__ . "   " . __LINE__);
            $this->prod_stock = (isset($this->arrayDados["prod_stock"]) && is_integer($this->arrayDados["prod_stock"])) ? $this->arrayDados["prod_stock"] : NULL;
            $this->prod_weight = (isset($this->arrayDados["prod_weight"]) && (is_float($this->arrayDados["prod_weight"]) || is_integer($this->arrayDados["prod_weight"]))) ? (float) $this->arrayDados["prod_weight"] : NULL;
            $this->prod_price_promo = (isset($this->arrayDados["prod_price_promo"]) && (is_float($this->arrayDados["prod_price_promo"]) || is_integer($this->arrayDados["prod_price_promo"]))) ? (float) $this->arrayDados["prod_price_promo"] : NULL;
            $this->prod_height = (isset($this->arrayDados["prod_height"]) && (is_float($this->arrayDados["prod_height"]) || is_integer($this->arrayDados["prod_height"]))) ? (float) $this->arrayDados["prod_height"] : NULL;
            $this->prod_length = (isset($this->arrayDados["prod_length"]) && (is_float($this->arrayDados["prod_length"]) || is_integer($this->arrayDados["prod_length"]))) ? (float) $this->arrayDados["prod_length"] : NULL;
            $this->prod_width = (isset($this->arrayDados["prod_width"]) && (is_float($this->arrayDados["prod_width"]) || is_integer($this->arrayDados["prod_width"]))) ? (float) $this->arrayDados["prod_width"] : NULL;

        endif;
    }

}
