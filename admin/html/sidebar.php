<?php $action = explode('-', $action); ?>


<!--Menu lateral demonstração de categoria de produtos e outros itens-->
<aside class="col-lg-2 col-md-2 col-sm-3" >

    <!--SIDEBAR INTERNET ADMIN-->

    <nav class="navbar navbar-inverse sidebar" role="navigation" id="navbar-admin">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
                <span class="sr-only">Navegação Toggle</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">Drika's</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="<?php echo $class1 = (!isset($action[1]) || empty($action)) ? "active" : NULL; ?>"><a href="./">Home<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>

                <!--Perfil e mensagens-->
<!--				<li ><a href="#">Profile<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
                <li ><a href="#">Messages<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-envelope"></span></a></li>-->
                <!-- FIM Perfil e mensagens-->

                <li class="dropdown <?php echo $class2 = ( in_array("prod", $action)) ? "active" : NULL; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Produto <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-cog"></span></a>
                    <ul class="dropdown-menu forAnimate" role="menu">
                        <li><a href="?action=cad-prod">Cadastrar<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-plus-sign"></span></a></li>
                        <li><a href="?action=up-prod">Editar<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-edit"></span></a></li>

                    </ul>
                </li>
                <li class="dropdown <?php echo $class3 = ( in_array("forn", $action)) ? "active" : NULL; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fornecedor <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-cog"></span></a>
                    <ul class="dropdown-menu forAnimate" role="menu">
                        <li><a href="?action=cad-forn">Cadastrar<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-plus-sign"></span></a></li>
                        <li><a href="?action=up-forn">Editar<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-edit"></span></a></li>

                    </ul>
                </li>
                <li class="dropdown <?php echo $class4 = ( in_array("cat", $action)) ? "active" : NULL; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categoria<span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-cog"></span></a>
                    <ul class="dropdown-menu forAnimate" role="menu">
                        <li><a href="?action=cad-cat">Cadastrar<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-plus-sign"></span></a></li>
                        <li><a href="?action=up-cat">Editar<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-edit"></span></a></li>

                    </ul>
                </li>
                <li class="dropdown <?php echo $class5 = ( in_array("line", $action)) ? "active" : NULL; ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Linha de produtos<span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-cog"></span></a>
                    <ul class="dropdown-menu forAnimate" role="menu">
                        <li><a href="?action=cad-line">Cadastrar<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-plus-sign"></span></a></li>
                        <li><a href="?action=up-line">Editar<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-edit"></span></a></li>

                    </ul>
                </li>
            


            </ul>
        </div>

    </nav>



























































    <!--    <div class="list-group" id="menu-sidebar">
            <div class="list-group-item-heading head-sidebar-group" id="sidebar-product-group">
                <h3>Produto</h3>
            </div>
            <div class="list-group col-sm-11 col-sm-offset-1">
                <a href="./?action=cad-prod" class="list-group-item <?php echo $a = ($action == "cad-prod") ? 'active' : ''; ?>">Cadastrar</a>
                <a href="./?action=del-prod" class="list-group-item <?php echo $a = ($action == "del-prod") ? 'active' : ''; ?>">Deletar</a>
                <a href="./?action=up-prod" class="list-group-item <?php echo $a = ($action == "up-prod") ? 'active' : ''; ?>">Atualizar</a>
                <a href="./?action=list-prod" class="list-group-item <?php echo $a = ($action == "list-prod") ? 'active' : ''; ?>">Listar</a>
            </div>
            <div class="clearfix"></div>
            <div class="list-group-item-heading head-sidebar-group" id="sidebar-fornecedor-group">
                <h3>Fornecedor</h3>
            </div>
            <div class="list-group col-sm-11 col-sm-offset-1">
                <a href="./?action=cad-forn" class="list-group-item <?php echo $a = ($action == "cad-forn") ? 'active' : ''; ?>">Cadastrar</a>
                <a href="./?action=del-forn" class="list-group-item <?php echo $a = ($action == "del-forn") ? 'active' : ''; ?>">Deletar</a>
                <a href="./?action=up-forn" class="list-group-item <?php echo $a = ($action == "up-forn") ? 'active' : ''; ?>">Atualizar</a>
                <a href="./?action=list-forn" class="list-group-item <?php echo $a = ($action == "list-forn") ? 'active' : ''; ?>">Listar</a>
            </div>
            <div class="clearfix"></div>
            <div class="list-group-item-heading head-sidebar-group" id="sidebar-fornecedor-group">
                <h3>Categoria</h3>
            </div>
            <div class="list-group col-sm-11 col-sm-offset-1">
                <a href="./?action=cad-cat" class="list-group-item <?php echo $a = ($action == "cad-cat") ? 'active' : ''; ?>">Cadastrar</a>
                <a href="./?action=del-cat" class="list-group-item <?php echo $a = ($action == "del-cat") ? 'active' : ''; ?>">Deletar</a>
                <a href="./?action=up-cat" class="list-group-item <?php echo $a = ($action == "up-cat") ? 'active' : ''; ?>">Atualizar</a>
                <a href="./?action=list-cat" class="list-group-item <?php echo $a = ($action == "list-cat") ? 'active' : ''; ?>">Listar</a>
            </div>
            <div class="clearfix"></div>
            <div class="list-group-item-heading head-sidebar-group" id="sidebar-fornecedor-group">
                <h3>Linha</h3>
            </div>
            <div class="list-group col-sm-11 col-sm-offset-1">
                <a href="./?action=cad-line" class="list-group-item <?php echo $a = ($action == "cad-line") ? 'active' : ''; ?>">Cadastrar</a>
                <a href="./?action=del-line" class="list-group-item <?php echo $a = ($action == "del-line") ? 'active' : ''; ?>">Deletar</a>
                <a href="./?action=up-line" class="list-group-item <?php echo $a = ($action == "up-line") ? 'active' : ''; ?>">Atualizar</a>
                <a href="./?action=list-line" class="list-group-item <?php echo $a = ($action == "list-line") ? 'active' : ''; ?>">Listar</a>
            </div>-->




    <!--        
            
            <a href="./?action=cad-cat"" class="list-group-item <?php echo $a = ($action == "cad-cat") ? 'active' : ''; ?>">Cadastrar categoria</a>
            <a href="./?action=cad-feat"" class="list-group-item <?php echo $a = ($action == "cad-feat") ? 'active' : ''; ?>">Cadastrar característica</a>
            <a href="./?action=cad-img"" class="list-group-item <?php echo $a = ($action == "cad-img") ? 'active' : ''; ?>">Cadastrar imagem</a>  
            <a href="./?action=cad-forn"" class="list-group-item <?php echo $a = ($action == "cad-forn") ? 'active' : ''; ?>">Cadastrar fornecedor</a> 
            <a href="./?action=cad-line"" class="list-group-item <?php echo $a = ($action == "cad-line") ? 'active' : ''; ?>">Cadastrar linha de produto</a> 
            
            <div class="list-group col-sm-11 col-sm-offset-1">
                <a href="./?action=cad-img"" class="list-group-item <?php echo $a = ($action == "cad-img") ? 'active' : ''; ?>">Cadastrar imagem</a>  
                <a href="./?action=cad-forn"" class="list-group-item <?php echo $a = ($action == "cad-forn") ? 'active' : ''; ?>">Cadastrar fornecedor</a> 
                <a href="./?action=cad-line"" class="list-group-item <?php echo $a = ($action == "cad-line") ? 'active' : ''; ?>">Cadastrar linha de produto</a> 
            </div>-->


</aside>
<!--FIM do menu lateral-->
