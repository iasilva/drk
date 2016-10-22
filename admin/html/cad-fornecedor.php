<?php
$fornecedor=new ControllerFornecedor;

if(isset($_POST['forn_name'])):
    
    if($fornecedor->cadFornecedor()):
        drkMsg(" Fornecedor cód: {$fornecedor->getForn_id()} cadastrado com sucesso.", MSG_SUCCESS);
    endif;
endif;

?>
<section id="admin-cadastro" class="row">
    <header>
        <h1 class="color-secondary-1-2">Cadastrar fornecedor</h1>
    </header>
    <form name="frm-admin-cadastro" method="post">
        <div class="col-lg-3 col-md-3 col-sm-4">


            <div class="form-group col-sm-12">
                <label for="forn_name">Nome:</label>
                <input type="text" required="required" class="form-control input-sm" name="forn_name" id="forn_name" >
            </div>
            <div class="form-group col-sm-12">
                <label for="forn_doc">CPF/CNPJ:</label>
                <input type="text" class="form-control input-sm" name="forn_doc" id="forn_doc">
            </div>
            <div class="form-group col-sm-12">
                <label for="forn_tel">Tel:</label>
                <input type="tel" class="form-control input-sm" data-mask="(00) 0 0000 0000"  name="forn_tel" id="forn_tel">
            </div>
            
             <div class="form-group col-sm-6">
               
                 <input class="btn btn-primary" type='submit' name="forn_submit" id="forn_submit" value="Cadastrar">
            </div>
            
        </div>
        
    </form>
</section>




