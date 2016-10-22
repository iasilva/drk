<?php
$linhaDeProduto = new ControllerLineOfProduct;

if (isset($_POST['line_name'])):

    if ($linhaDeProduto->cadLine()):
        drkMsg(" Linha cód: {$linhaDeProduto->getLine_id()} cadastrado com sucesso.", MSG_SUCCESS);
    endif;
endif;
?>
<section id="admin-cadastro" class="row">
<header>
    <h1 class="color-secondary-1-2">Cadastrar Linha de produto</h1>
</header>

    <form name="frm-cad-linha" method="post">
        <div class="col-lg-6 col-md-6 col-sm-10">


            <div class="form-group col-sm-6">
                <label for="line_name">Nome:</label>
                <input type="text" class="form-control input-sm" name="line_name" id="line_name">
            </div>
            <div class="form-group col-sm-6">
                <label for="line_link">Link:</label>
                <input type="text" class="form-control input-sm" name="line_link" id="line_link">
            </div>
            <div class="form-group col-sm-12">
                <label for="line_description">Descrição:</label>
                <textarea class="form-control input-sm" rows="5" name="line_description" id="line_description">
                </textarea>
            </div>

            <div class="form-group col-sm-3">

                <input type="submit" class="btn btn-default" name="line_submit" id="line_submit" value="Cadastrar">
            </div>

        </div>

    </form>
</section>




<script src="../plugins/ckEditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace("line_description");
</script>
