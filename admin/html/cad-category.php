<?php
$category= new ControllerCategory;

if (isset($_POST['cat_name'])):

    if ($category->cadCategory()):
        drkMsg(" Linha cód: {$category->getCat_id()} cadastrado com sucesso.", MSG_SUCCESS);
    endif;
endif;
?>
<section id="admin-cadastro" class="row">
<header>
    <h1 class="color-secondary-1-2">Cadastrar categoria</h1>
</header>

    <form name="frm-cad-category" method="post">
        <div class="col-lg-6 col-md-6 col-sm-10">


            <div class="form-group col-sm-6">
                <label for="cat_name">Nome:</label>
                <input type="text" class="form-control input-sm" name="cat_name" id="cat_name">
            </div>
            <div class="form-group col-sm-6">
                <label for="cat_parent">Categoria pai:</label>
                <select class="form-control" name="cat_parent" id="cat_parent">
                    <option selected="" value="0">Principal</option>
                    <?php
                    $categorias = new ControllerCategory;
                    $categorias->setOrderByResult("cat_name ASC");
                    if ($options = $categorias->getCategoriesOptions()):
                        echo $options;
                    endif;
                    ?>
                </select>
            </div>
            <div class="form-group col-sm-12">
                <label for="cat_description">Descrição:</label>
                <textarea class="form-control input-sm" rows="5" name="cat_description" id="cat_description">
                </textarea>
            </div>

            <div class="form-group col-sm-3">

                <input type="submit" class="btn btn-default" name="cat_submit" id="cat_submit" value="Cadastrar">
            </div>

        </div>

    </form>
</section>




<script src="../plugins/ckEditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace("cat_description");
</script>
