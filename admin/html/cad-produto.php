<?php
if (isset($_GET['product'])):
    try {
        $produto = $_GET['product'];
    } catch (Exception $exc) {
        drkMsg($exc->getMessage(), $exc->getCode());
    }
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $nome = ($produto->getProd_name()) ? $produto->getProd_name() : NULL;
    $descricao = ($produto->getProd_description()) ? $produto->getProd_description() : NULL;
    $preco = ($produto->getProd_price()) ? $produto->getProd_price() : NULL;
    $precoPromocional = ($produto->getProd_price_promo()) ? $produto->getProd_price_promo() : NULL;
    $peso = ($produto->getProd_weight()) ? $produto->getProd_weight() : NULL;
    $altura = ($produto->getProd_height()) ? $produto->getProd_height() : NULL;
    $comprimento = ($produto->getProd_length()) ? $produto->getProd_length() : NULL;
    $largura = ($produto->getProd_width()) ? $produto->getProd_width() : NULL;
    $estoque = ($produto->getProd_stock()) ? $produto->getProd_stock() : NULL;
    $categoria = ($produto->getCat_id()) ? $produto->getCat_id() : NULL;
    $linhaDeProdutoSelecionada = ($produto->getLine_id()) ? $produto->getLine_id() : NULL;
    $fornecedorDoProdutoAtual = ($produto->getForn_id()) ? $produto->getForn_id() : NULL;
endif;


if (isset($_POST['prod_name'])):
    $produtoNovo = new ControllerProduct;
    if ($produtoNovo->cadProduct()):
        drkMsg(" Produto cód: {$produtoNovo->getProd_id()} cadastrado com sucesso.", MSG_SUCCESS);
    else :
        echo "HOuve algum erro";
    endif;
endif;
?>

<section id="admin-cadastro" class="row">
    <header>
        <h1 class="color-secondary-1-2">Cadastrar produto</h1>
    </header>
    <form name="frm-admin-cadastro" method="post" action="<?php echo $action = (isset($produto)) ? "?in=prod&action=Up&id=$id" : NULL ?>">
        <div class="col-lg-6 col-md-6 col-sm-12">


            <div class="form-group col-sm-12">
                <label for="prod_name">Nome:</label>
                <input type="text" required="required" class="form-control input-sm" name="prod_name" id="prod_name"
                       value="<?php echo $valor = (isset($nome)) ? $nome : NULL ?>">
            </div>
            <div class="form-group col-sm-12">
                <label for="prod_description">Descrição:</label>
                <textarea class="form-control input-sm" rows="5" name="prod_description" required="required" id="prod_description">
                    <?php echo $valor = (isset($descricao)) ? $descricao : NULL ?>
                </textarea>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">

            <div class="form-group col-md-4 col-sm-4 col-xs-6">
                <label for="prod_price">Preço:</label>
                <input type="text" required="required" class="form-control input-sm" name="prod_price" id="prod_price"
                       value="<?php echo $valor = (isset($preco)) ? $preco : NULL ?>">
            </div>
            <div class="form-group col-md-4 col-sm-4 col-xs-6">
                <label for="prod_price_promo">Preço promocional:</label>
                <input type="text" class="form-control input-sm" name="prod_price_promo" id="prod_price_promo"
                       value="<?php echo $valor = (isset($precoPromocional)) ? $precoPromocional : NULL ?>"    >
            </div>
            <div class="form-group col-md-4 col-sm-4 col-xs-6">
                <label for="prod_weight">Peso: (g)</label>
                <input type="text" class="form-control input-sm" name="prod_weight" id="prod_weight"
                       value="<?php echo $valor = (isset($peso)) ? $peso : NULL ?>">
            </div>
            <div class="form-group col-md-4 col-sm-4 col-xs-6">
                <label for="prod_height">Altura: (cm)</label>
                <input type="text" class="form-control input-sm" name="prod_height" id="prod_height"
                       value="<?php echo $valor = (isset($altura)) ? $altura : NULL ?>">
            </div>
            <div class="form-group col-md-4 col-sm-4 col-xs-6">
                <label for="prod_length">Comprimento: (cm)</label>
                <input type="text" class="form-control input-sm" name="prod_length" id="prod_length"
                       value="<?php echo $valor = (isset($comprimento)) ? $comprimento : NULL ?>">
            </div>
            <div class="form-group col-md-4 col-sm-4 col-xs-6">
                <label for="prod_width">Largura: (cm)</label>
                <input type="text" class="form-control input-sm" name="prod_width" id="prod_width"
                       value="<?php echo $valor = (isset($largura)) ? $largura : NULL ?>">
            </div>
            <div class="form-group col-md-4 col-sm-4 col-xs-6">
                <label for="prod_stock">Estoque:</label>
                <input type="text" class="form-control input-sm" name="prod_stock" id="prod_stock"
                       value="<?php echo $valor = (isset($estoque)) ? $estoque : NULL ?>">
            </div>
            <div class="form-group col-md-4 col-sm-4 col-xs-6">
                <label for="cat_id"></label>
                <select class="form-control" required="required" name="cat_id" id="cat_id">
                    <option disabled="disabled" <?php echo $selected = (!isset($categoria)) ? "selected=\"\"" : ""; ?>>Categoria</option>
                    <?php
                    $categorias = new ControllerCategory;
                    if (isset($categoria)):
                        $categorias->setSelected($categoria);
                    endif;
                    $categorias->setOrderByResult("cat_name ASC");
                    if ($options = $categorias->getCategoriesOptions()):
                        echo $options;
                    endif;
                    ?>

                </select>

            </div>
            <div class="form-group col-md-4 col-sm-4 col-xs-6">
                <label for="line_id"></label>
                <select class="form-control" required="required" name="line_id" id="line_id">
                    <option disabled="disabled" <?php echo $selected = (!isset($linhaDeProdutoSelecionada)) ? "selected=\"\"" : ""; ?>>Linha de produto</option>
                    <?php
                    $linhaDeProduto = new ControllerLineOfProduct;
                    if (isset($linhaDeProdutoSelecionada)):
                        $linhaDeProduto->setSelected($linhaDeProdutoSelecionada);
                    endif;
                    $linhaDeProduto->setOrderByResult("line_name ASC");
                    if ($options = $linhaDeProduto->getLinesOptions()):
                        echo $options;
                    endif;
                    ?>
                </select>
            </div>
            <div class="form-group col-md-4 col-sm-4 col-xs-6">
                <label for="forn_id"></label>
                <select class="form-control" required="required"  name="forn_id" id="forn_id">
                    <option value="" selected="selected" disabled="disabled">Fornecedor</option>
                    <?php
                    $fornecedores = new ControllerFornecedor;
                    if (isset($fornecedorDoProdutoAtual)):
                        $fornecedores->setSelected($fornecedorDoProdutoAtual);
                    endif;
                    $fornecedores->setOrderByResult("forn_name ASC");
                    if ($options = $fornecedores->getFornecedoresOptions()):
                        echo $options;
                    endif;
                    ?>
                </select>
            </div>
            <div class="clearfix"></div>

            <div class="form-group">               
                <input class="btn btn-primary btn-lg" type='submit' name="prod_submit" id="prod_submit" value="<?php echo $value = (isset($produto)) ? "Atualizar" : "Cadastrar" ?>">
                <?php
                if (isset($produto)):
                    Form::setClass(array("btn-warning", "btn-lg"));
                    echo Form::createButton("link", "Cancelar", "./?action=up-prod");
                endif;
                ?>
            </div>
        </div>  

    </form>
</section>

<!--  line_id, cat_id, forn_id, created_at-->
<script src="../plugins/ckEditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace("prod_description");
</script>

