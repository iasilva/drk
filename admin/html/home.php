

<?php
if (!isset($_GET['action'])):
?>
<section id="admin-cadastro" class="row">
    <header>
         <h1>
            Bem vindo a página administrativa da DRIKA'S.
        </h1> 
    </header>
    
    
    <div class="col-lg-8">
         
        <div class="alert alert-warning alert-dismissable">
            Essa loja virtual ainda está na versão alph@. Isso significa que muitos erros podem ocorrer.
        </div>
        <div class="alert alert-info alert-dismissable">
            A boa notícia é que estamos implementando mudanças e corrigindo os erros diariamente.
        </div>
    </div>
</section>
<?php
endif;
$prod=new ControllerProduct;
try{
    $prod->verify();
} catch (Exception $e) {
    drkMsg($e->getMessage(), $e->getCode());
}

?>