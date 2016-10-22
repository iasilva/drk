<?php

/**
 * <b>Description of ControllerProduct<b><br>
 *  Classe que controla as chamadas e ações ligadas ao produto
 * @author Ivan Alves da Silva
 * @version 0.2 alpha Classe controller de produtos
 * @copyright (c) 2016, Thirday DRK Technologia
 */
class ControllerProduct extends ModelProduct {

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
    private $cat_name; //Nome da categoria
    private $forn_name; //Nome do fornecedor
    private $line_name; //nome da linha

    const TABLE_NICK_NAME = "prod";

    /**
     *
     * @var array  com as ações válidas 
     * atributo utilizado pelo método <b>action</b>
     */
    private $validActions = array("GET", "POST", "Create", "Up", "Del", "Read", "View");

    /**
     *
     * @var array - Armazena um array com todos os produtos cadastrados 
     */
    private $allProducts;

    /**
     * @var int Limite a ser consultado 
     */
    private $limitResult = 30;

    /**
     * @var string de orde do array resultante  
     */
    private $orderByResult = "prod_name";
    //Array com os índices sendo os atributos variáveis da classe
    private $product;

    /**
     * Método pega os dados de $_POST e faz o salvamento
     * @return boolean
     * @throws Exception lança uma excessão caso não consiga salvar
     * 
     */
    public function cadProduct() {
        try {
            $this->verificaPost();
            $this->criaArrayAtributosVariaveis();
            $this->verificaDadosObrigatorios();
            $this->verificaDuplicidade();
            $this->trataCamposVaziosNoArray();
            if ($this->prod_id = parent::save($this->product)):
                return TRUE;
            else:
                throw new Exception("Houve algum erro ao tentar efetuar o registro.<br> " . __CLASS__ . __LINE__, E_USER_ERROR);
            endif;
        } catch (Exception $e) {
            drkMsg($e->getMessage(), $e->getCode());
            return false;
        }
    }

    /**
     * Lista os produtos para editar
     * @return string - HTML DA TABELA DE EXIBIÇÃO
     */
    public function listProductsForEdit() {
        $this->queryAllProducts();
        $this->preparaLinhasParaLista();
        $colunas = $this->preparaColunasParaLista();
        $tabela = new Table($colunas, $this->allProducts, "prod_");
        $lista = $tabela->getTableEdit();
        return $lista;
    }

    /*     * ******************MÉTODOS internos de consultas******************* */

    private function queryAllProducts() {
        $this->allProducts = parent::listAllProducts($this->orderByResult, $this->limitResult);
    }

    /*     * ******************MÉTODOS GETTER******************* */

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
        return $this->prod_id;
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

    public function getAllProducts() {
        return $this->allProducts;
    }

    public function getLimitResult() {
        return $this->limitResult;
    }

    public function getOrderByResult() {
        return $this->orderByResult;
    }

    /*     * ************* MÉTODOS SETTER********** */

    public function setProd_id($prod_id="") {
        if($prod_id!==""):
            $this->prod_id = $prod_id;
        else:
            $this->prod_id = (filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) !== NULL) ? filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) : NULL;
        endif;
        
        
        
    }

    public function setProd_description($prod_description) {
        $this->prod_description = $prod_description;
        return $this;
    }

    public function setProd_name($prod_name) {
        $this->prod_name = $prod_name;
        return $this;
    }

    public function setProd_price($prod_price) {
        $this->prod_price = $prod_price;
        return $this;
    }

    public function setProd_price_promo($prod_price_promo) {
        $this->prod_price_promo = $prod_price_promo;
        return $this;
    }

    public function setProd_weight($prod_weight) {
        $this->prod_weight = $prod_weight;
        return $this;
    }

    public function setProd_height($prod_height) {
        $this->prod_height = $prod_height;
        return $this;
    }

    public function setProd_length($prod_length) {
        $this->prod_length = $prod_length;
        return $this;
    }

    public function setProd_stock($prod_stock) {
        $this->prod_stock = $prod_stock;
        return $this;
    }

    public function setProd_width($prod_width) {
        $this->prod_width = $prod_width;
        return $this;
    }

    public function setLine_id($line_id) {
        $this->line_id = $line_id;
        return $this;
    }

    public function setCat_id($cat_id) {
        $this->cat_id = $cat_id;
        return $this;
    }

    public function setForn_id($forn_id) {
        $this->forn_id = $forn_id;
        return $this;
    }

    public function setLimitResult($limitResult) {
        $this->limitResult = $limitResult;
        return $this;
    }

    public function setOrderByResult($orderByResult) {
        $att = get_class_vars('ControllerProduct');
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
//        $this->prod_id = filter_input(INPUT_POST, "prod_id", FILTER_VALIDATE_INT);
        $this->prod_description = filter_input(INPUT_POST, "prod_description", FILTER_DEFAULT);
        $this->prod_name = filter_input(INPUT_POST, "prod_name", FILTER_DEFAULT);
        $this->prod_price = filter_input(INPUT_POST, "prod_price", FILTER_VALIDATE_FLOAT);
        $this->prod_price_promo = filter_input(INPUT_POST, "prod_price_promo", FILTER_VALIDATE_FLOAT);
        $this->prod_weight = filter_input(INPUT_POST, "prod_weight", FILTER_VALIDATE_FLOAT);
        $this->prod_height = filter_input(INPUT_POST, "prod_height", FILTER_VALIDATE_FLOAT);
        $this->prod_length = filter_input(INPUT_POST, "prod_length", FILTER_VALIDATE_FLOAT);
        $this->prod_stock = filter_input(INPUT_POST, "prod_stock", FILTER_VALIDATE_FLOAT);
        $this->prod_width = filter_input(INPUT_POST, "prod_width", FILTER_VALIDATE_FLOAT);
        $this->line_id = filter_input(INPUT_POST, "line_id", FILTER_VALIDATE_INT);
        $this->cat_id = filter_input(INPUT_POST, "cat_id", FILTER_VALIDATE_INT);
        $this->forn_id = filter_input(INPUT_POST, "forn_id", FILTER_VALIDATE_INT);
    }

    private function criaArrayAtributosVariaveis() {
        $this->product["prod_description"] = $this->prod_description;
        $this->product["prod_name"] = $this->prod_name;
        $this->product["prod_price"] = $this->prod_price;
        $this->product["prod_price_promo"] = $this->prod_price_promo;
        $this->product["prod_weight"] = $this->prod_weight;
        $this->product["prod_height"] = $this->prod_height;
        $this->product["prod_length"] = $this->prod_length;
        $this->product["prod_stock"] = $this->prod_stock;
        $this->product["prod_width"] = $this->prod_width;
        $this->product["line_id"] = $this->line_id;
        $this->product["cat_id"] = $this->cat_id;
        $this->product["forn_id"] = $this->forn_id;
    }

    /**
     * Substitui os campos vazios no array product por valores nulli
     */
    private function trataCamposVaziosNoArray() {
        foreach ($this->product as $key => $value):
            $this->product[$key] = (isset($value) && $value != "") ? $value : null;
        endforeach;
    }

    private function preparaLinhasParaLista() {
        $category = new ControllerCategory;
        $fornecedor = new ControllerFornecedor;
        $linha = new ControllerLineOfProduct;
        foreach ($this->allProducts as $key => $produto):
            unset($produto["prod_description"]);
            unset($produto["prod_weight"]);
            unset($produto["prod_height"]);
            unset($produto["prod_length"]);
            unset($produto["prod_width"]);
            $produto['cat_id'] = $category->getCategory($produto["cat_id"])->getCat_name();
            $produto['forn_id'] = $fornecedor->getFornecedor($produto['forn_id'])->getForn_name();
            $produto['line_id'] = $linha->getLineOfProduct($produto['line_id'])->getLine_name();
            $this->allProducts[$key] = $produto;
        endforeach;
    }

    private function preparaColunasParaLista() {
        return array("Cód:", "Nome", "Preço (R$)", "Promo (R$)", "Estoque", "Linha", "Categoria", "Fornecedor", "Criado", "Atualizado");
    }

    private function verificaDadosObrigatorios() {
        $obrigatorios = array("prod_name", "prod_description", "prod_price", "line_id", "cat_id", "forn_id");
        foreach ($obrigatorios as $value):
            if (!isset($this->product[$value]) || empty($this->product[$value]) || $this->product == ""):
                throw new Exception("{$value} é um campo obrigatório e não foi fornecido.", E_USER_ERROR);
            endif;
        endforeach;
    }

    /*
     * Método responsável por veríficar cada campo que não pode se repetir no BD
     * Caso encontre algum dado já existente ele lança uma excessão
     */

    private function verificaDuplicidade() {
        parent::getProductByName(trim($this->prod_name));
        if (parent::getComprimentoUltimaListaRetornada() >= 1):
            throw new Exception("Já existe um produto cadastrado com o nome <b> {$this->prod_name} </b> .", E_USER_ERROR);

        endif;
    }

    private function getNomeCategoria() {
        $cat = new ControllerCategory;
        $this->cat_name = $cat->getCategory(3)->getCat_name();
    }

    /*     * ******************0.3 version production******************* */

    /**
     * Primeiramente verifica se a intenção do sistema é falar com esse controller. 
     * Ele vai sempre verificar isso através da variável $_GET in.                 
     * Geralmente a variável <b>in</b> indicará o prefixo dos campos da tabela.    
     * @return BOL TRUE chama o método de action ou apenas retorna FALSE               
     */
    public function verify() {
        if ($this->isWithMe()):
            $this->action();
            return TRUE;
        else:
            return false;
        endif;
    }

    /**
     * Esse método deve ser chamado por verify().<br>                                            
     * Ele verifica se a tabela/entidade que se pretente trabalhar é mesmo essa.<br> 
     * Utiliza a constante <b>TABLE_NICK_NAME</b> para fazer a comparação      
     * @return bool -  Retorna true caso exista uma chamada para esse controller 
     * ou false caso não exista.                                                 
     */
    private function isWithMe() {
        if (filter_input(INPUT_GET, "in", FILTER_DEFAULT) !== NULL):
            if (filter_input(INPUT_GET, "in", FILTER_DEFAULT) === self::TABLE_NICK_NAME):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            return FALSE;
        endif;
    }

    /**
     * Verifica e determina a ação que deve ser executada pelo objeto. 
     * por padrão considera buscar o método no $_GET
     * 
     */
    public function action(string $action = "GET") {
        if ($this->actionValidate($action)):
            call_user_func(array($this, "action" . $action));
        endif;
    }

    /**
     * Verifica se a ação - action tentada é pré especificada no atributo 
     * $validActions.
     * @param string $action - Ação a ser executada, read, del,up etc..
     * @return boolean TRUE caso existaa ação pré específicada
     * @throws Exception - Caso o nome da ação passada não seja um nome válido 
     * o método lança uma excessão do tipo E_USER_ERROR
     */
    private function actionValidate($action) {
        if (in_array($action, $this->validActions)):
            return TRUE;
        else:
            throw new Exception("Ação não pode ser validada!", E_USER_ERROR);
        endif;
    }

    /**
     * Caso a ação seja enviada por GET, é feita a captura e envia de volta a 
     * action
     */
    private function actionGET() {
        $action = filter_input(INPUT_GET, "action", FILTER_DEFAULT);
        $this->action($action);
    }

    /**
     * Caso a ação seja enviada por POST, é feita a captura e envia de volta a 
     * action
     */
    private function actionPOST() {
        $action = filter_input(INPUT_POST, "action", FILTER_DEFAULT);
        $this->action($action);
    }

    /**
     * Responsável por desencadear as ações de atualização
     */
    private function actionUp() {
        $this->setProd_id();

        if ($this->prod_id === NULL):
            throw new Exception("Não foi possível identificar o produto.", E_USER_ERROR);
        else:
            $this->verificaPost();
            parent::getProduct($this->prod_id);
            $this->criaArrayAtributosVariaveis();
            $this->trataCamposVaziosNoArray();
            parent::setProd_id($this->prod_id);
            parent::update($this->product);            
        endif;
        drkMsg("Produto atualizado com sucesso!", E_USER_NOTICE);
        Form::setClass(array("btn-info","btn-lg"));
        echo Form::createButton("link","Ver produtos","./?action=up-prod" );
    }

    /**
     * Responsável por desencadear as ações de leitura no Banco de Dados
     */
    private function actionRead() {
        echo "function actionRead()";
    }

    /**
     * Responsável por desencadear as ações de exclusão no Banco de Dados
     */
    private function actionDel() {
        $this->setProd_id();
        parent::setProd_id($this->prod_id);
        parent::getProduct($this->prod_id);
        parent::delete();
        drkMsg("Produto excluído com sucesso!", E_USER_WARNING);
        Form::setClass(array("btn-danger","btn-lg"));
        echo Form::createButton("link","Ver produtos","./?action=up-prod" );
    }

    /**
     * Responsável por desencadear as ações de criação no Banco de Dados
     */
    private function actionCreate() {
        echo "function actionCreate()";
    }

    /**
     * Responsável por desencadear as ações de visualização
     */
    private function actionView() {
        $this->prod_id = (filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) !== NULL) ? filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT) : NULL;
        if ($this->prod_id === NULL):
            throw new Exception("Não foi possível identificar o produto.", E_USER_ERROR);
        else:
            $model = new ModelProduct;
            $produto = $model->getProduct($this->prod_id);
            $_GET['product'] = $produto;
            require_once 'html/cad-produto.php';              
        endif;
    }

}
