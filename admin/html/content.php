<?php require_once './html/head.php'; ?>

<?php require_once './html/header.php'; ?>
<!--Secao  - container de conteúdo-->
<section class="container-fluid">
    <div class="row"><!--Linha 01 da seção de conteúdo-->

        <?php require_once './html/sidebar.php'; ?>

        <section class="col-lg-10 col-md-10 col-sm-9 col-xs-12" id="content"> <!--EFETIVAMENTE ONDE FICAM OS ITENS DE CONTEÚDO-->


            <?php
            $page = (isset($action[1])) ? $action[1] : 'home';
            $act = (isset($action[0])) ? $action[0] : 'home';
            switch ($page) {
                case "prod":
                    switch ($act) :
                        case "cad":
                            require_once './html/cad-produto.php';
                            break;
                        default:
                            require_once './html/list.php';
                            break;
                    endswitch;
                    break;
                case "forn":
                    switch ($act) :
                        case "cad":
                            require_once './html/cad-fornecedor.php';
                            break;
                        default:
                            require_once './html/list.php';

                            break;
                    endswitch;
                    break;
                case "line":
                    switch ($act) :
                        case "cad":
                            require_once './html/cad-line.php';
                            break;
                        default:
                            require_once './html/list.php';

                            break;
                    endswitch;
                    break;
                case "cat":
                    switch ($act) :
                        case "cad":
                            require_once './html/cad-category.php';
                            break;
                        default:
                            require_once './html/list.php';
                            break;
                    endswitch;
                    break;

                default:
                    require_once './html/home.php';
                    break;
            }
            ?>














    </div> <!--FIM DA Linha 01 da seção de conteúdo-->   
</section>


<?php require_once './html/footer.php'; ?>