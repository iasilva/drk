<!DOCTYPE html>
<html lang="pt-br">    
    <head>
        <title>Página de detalhe do produto!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Inserindo os links de CSS relacionados ao BOOTSTRAP-->
        <link href="../css/bootstrap/css/bootstrap.min.css" rel="stylesheet">  

        <!--CSS PRÓPRIO - PALETA DE CORES-->
        <link href="../css/paleta.css" rel="stylesheet">  

        <!--CSS PRÓPRIO - ESTILO -->
        <link href="../css/style.css" rel="stylesheet">  

    </head>
    <body>

        <!--Container do header so site - Menú e Navegação-->
        <div class="container-fluid" id="header-container">
            <!--Menu TOP--> 
            <div class="row"><!--Inicia a linha 01 do header-->
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12"><!--Inicia a coluna do menu na linha 01 do header-->

                    <img alt="Logomarca da Drikas" src="../images/logoFor_horiz.png" class="pull-left" id="header-logomarca">


                    <ul class="list-inline list-unstyled color-secondary-1-1" id="header-list-menu"><!--Inicia a lista do menu na linha 01 do header-->
                        <li><a href="#">Home</a></li>
                        <li><a href="http://blog.drikas.com" target="_blank"a> Blog</a></li>
                        <li> <a href="#">Meus pedidos</a></li>
                        <li> <a href="#">Como comprar</a></li>
                        <li><a href="rastreio.php">Informações de entrega</a></li>
                        <li><a href="#"> Fale conosco</a></li>                        
                    </ul>  
                </div><!--Finaliza a coluna 01 do header container do header-->
            </div><!--Finaliza a linha 01 do header-->
        </div><!--Finaliza o container do header-->


        <!--Secao  - container de conteúdo-->
        <section class="container-fluid">
            <div class="row"<!--Linha 01 da seção de conteúdo-->

                 <!--Menu lateral demonstração de categoria de produtos e outros itens-->
                 <aside class="col-lg-2 col-md-2 col-sm-3" >
                    <div class="list-group" id="menu-sidebar">
                        <a href="#" class="list-group-item">Esmaltes <span class="badge">683</span></a>
                        <a href="#" class="list-group-item">Joinhas <span class="badge">978</span></a>
                        <a href="#" class="list-group-item">Pedrinhas <span class="badge">46</span></a>
                        <a href="#" class="list-group-item">Películas <span class="badge">2116</span></a>                        
                    </div>

                </aside>
                <!--FIM do menu lateral-->


                <section class="col-lg-10 col-md-10 col-sm-9 col-xs-12" id="produto-detalhe"> <!--EFETIVAMENTE ONDE FICAM OS detalhes do produto-->

                    <!--Detalhe linha header-->
                    <div class="row" id="detalhe-linha-header">

                        <div id="miniaturas-imagens" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">                           


                            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-4 col-xs-4 ">
                                <img src="../images/produto.jpg">
                            </div>
                            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-4  col-xs-4 ">
                                <img src="../images/produto.jpg">
                            </div>
                            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-4  col-xs-4 ">
                                <img src="../images/produto.jpg">
                            </div>
                        </div>


                        <!--Imagem destaque-->
                        <div id="imagem-destaque" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <header class="page-header">
                                <h3 class="text-center">LaFemme - Esmalte para unhas CARIMBO - Vermelho  </h3>
                            </header>
                            <img src="../images/produto.jpg">
                        </div>


                        <!--Botões e informações complementares-->
                        <div id="complemento-produto" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <header class="page-header">
                                <h4>Escolha o que fazer</h4>
                            </header>

                            <div class="btn btn-add-cart">
                                Adicionar ao carrinho
                            </div>
                            <div class="btn btn-warning">
                                Adicionar a lista de desejos
                            </div>

                            <p class="color-secondary-2-3">Produto vendido por <span class="preco"><b>R$ 4,99</b></span></p>
                            <div class="btn btn-default">
                                Finalizar pedido
                            </div>

                        </div>
                    </div>
                    <!--FIM DETALHE-->




                    <section class="row" id="descricao-produto-detalhe">

                        <article class="col-lg-4 col-lg-offset-0 col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                            <header>
                                <h4>Descrição</h4>
                            </header>
                            <p>
                                <small>
                                    Esmaltes de longa duração, qualidade na aplicação, boa textura e ótimo acabamento. 
                                </small>
                            </p>
                            <a href="#">Veja a opinião de uma profissional.</a>


                        </article>
                        
                        <article class="col-lg-4 col-lg-offset-0 col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                            <header>
                                <h4>Informações sobre a linha de produto</h4>
                            </header>
                            <p> 
                                <small>
                                    A linha carimbo da LaFemme foi especialmente desenvolvido para aplicação de películas, e estilização com carimbos.  
                                </small>
                            </p>
                            <p>
                                <small>
                                    Porém, a qualidade do produto o tornou um produto de uso universal.
                                </small>
                            </p>
                        </article>
                        <article class="col-lg-4 col-lg-offset-0 col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                            <header>
                                <h4>Sugestão de uso</h4>
                            </header>
                            <p>
                                <small>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small>
                            </p>
                            <p>
                                <small>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small>
                            </p>

                        </article>




                    </section>












                </section><!-- FIM DA SEÇÃO CONTENT-->





            </div> <!--FIM DA Linha 01 da seção de conteúdo-->   
        </section> <!-- FIM Do container master -->
    </body>
</html>
<script src="../js/jquery.js"></script>
<script src="../css/bootstrap/js/bootstrap.min.js"></script>
<script src="../plugins/jQueryMasc/mask.js"></script>
