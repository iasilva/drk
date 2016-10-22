<!DOCTYPE html>
<html lang="pt-br">    
    <head>
        <title>Template inicial do site!</title>
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
                        <li><a href="#"> Blog</a></li>
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
            <div class="row"><!--Linha 01 da seção de conteúdo-->

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


                <section class="col-lg-10 col-md-10 col-sm-9 col-xs-12" id="content"> <!--EFETIVAMENTE ONDE FICAM OS ITENS DE CONTEÚDO-->

                    <article class="produto pull-left">
                        <img src="../images/produto.jpg" alt="Imagem do produto">
                        <p>Esmalte laFemme Carimbo</p>
                        <p class="cor-predominante">Cor predominante:<span style="color: #333;"> Vermelho</span> <span class="preco">R$ 4,99</span></p>
                        <a href="detalhe.php"><div class="btn btn-xs btn-danger">Detalhar</div></a>
                    </article>  
                    <article class="produto pull-left">
                        <img src="../images/produto.jpg" alt="Imagem do produto">
                        <p>Esmalte laFemme Carimbo</p>
                        <p class="cor-predominante">Cor predominante:<span style="color: #333;"> Vermelho</span> <span class="preco">R$ 4,99</span></p>
                        <div class="btn btn-xs btn-danger">Detalhar</div>
                    </article>  
                    <article class="produto pull-left">
                        <img src="../images/produto.jpg" alt="Imagem do produto">
                        <p>Esmalte laFemme Carimbo</p>
                        <p class="cor-predominante">Cor predominante:<span style="color: #333;"> Vermelho</span> <span class="preco">R$ 4,99</span></p>
                        <div class="btn btn-xs btn-danger">Detalhar</div>
                    </article>  
                    <article class="produto pull-left">
                        <img src="../images/produto.jpg" alt="Imagem do produto">
                        <p>Esmalte laFemme Carimbo</p>
                        <p class="cor-predominante">Cor predominante:<span style="color: #333;"> Vermelho</span> <span class="preco">R$ 4,99</span></p>
                        <div class="btn btn-xs btn-danger">Detalhar</div>
                    </article>  
                    <article class="produto pull-left">
                        <img src="../images/produto.jpg" alt="Imagem do produto">
                        <p>Esmalte laFemme Carimbo</p>
                        <p class="cor-predominante">Cor predominante:<span style="color: #333;"> Vermelho</span> <span class="preco">R$ 4,99</span></p>
                        <div class="btn btn-xs btn-danger">Detalhar</div>
                    </article>  
                    <article class="produto pull-left">
                        <img src="../images/produto.jpg" alt="Imagem do produto">
                        <p>Esmalte laFemme Carimbo</p>
                        <p class="cor-predominante">Cor predominante:<span style="color: #333;"> Vermelho</span> <span class="preco">R$ 4,99</span></p>
                        <div class="btn btn-xs btn-danger">Detalhar</div>
                    </article>  
                    <article class="produto pull-left">
                        <img src="../images/produto.jpg" alt="Imagem do produto">
                        <p>Esmalte laFemme Carimbo</p>
                        <p class="cor-predominante">Cor predominante:<span style="color: #333;"> Vermelho</span> <span class="preco">R$ 4,99</span></p>
                        <div class="btn btn-xs btn-danger">Detalhar</div>
                    </article>  
                    <article class="produto pull-left">
                        <img src="../images/produto.jpg" alt="Imagem do produto">
                        <p>Esmalte laFemme Carimbo</p>
                        <p class="cor-predominante">Cor predominante:<span style="color: #333;"> Vermelho</span> <span class="preco">R$ 4,99</span></p>
                        <div class="btn btn-xs btn-danger">Detalhar</div>
                    </article>  
                    <article class="produto pull-left">
                        <img src="../images/produto.jpg" alt="Imagem do produto">
                        <p>Esmalte laFemme Carimbo</p>
                        <p class="cor-predominante">Cor predominante:<span style="color: #333;"> Vermelho</span> <span class="preco">R$ 4,99</span></p>
                        <div class="btn btn-xs btn-danger">Detalhar</div>
                    </article>  
                    <article class="produto pull-left">
                        <img src="../images/produto.jpg" alt="Imagem do produto">
                        <p>Esmalte laFemme Carimbo</p>
                        <p class="cor-predominante">Cor predominante:<span style="color: #333;"> Vermelho</span> <span class="preco">R$ 4,99</span></p>
                        <div class="btn btn-xs btn-danger">Detalhar</div>
                    </article>  
                    <article class="produto pull-left">
                        <img src="../images/produto.jpg" alt="Imagem do produto">
                        <p>Esmalte laFemme Carimbo</p>
                        <p class="cor-predominante">Cor predominante:<span style="color: #333;"> Vermelho</span> <span class="preco">R$ 4,99</span></p>
                        <div class="btn btn-xs btn-danger">Detalhar</div>
                    </article>  
                    
                    
                   







                    <!--                    
                     <div class="row">
                                         
                                              Box para abarcar o article dp produto
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-8 col-xs-offset-2">
                                                    <article class="produto">
                                                        
                                                    </article>                       
                                                </div>
                                        
                    
                  </div>-->
            </div>

        </section>




    </div> <!--FIM DA Linha 01 da seção de conteúdo-->   
</section>












</body>
</html>
<script src="../js/jquery.js"></script>
<script src="../css/bootstrap/js/bootstrap.min.js"></script>
<script src="../plugins/jQueryMasc/mask.js"></script>
