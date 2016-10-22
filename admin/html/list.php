<section id="admin-cadastro" class="row">
    <header>
        <h1 class="color-secondary-1-2">Editar...<small> <span class="glyphicon glyphicon-pencil"></span></small></h1>
    </header>

    <?php
    if (isset($_GET['orderby'])):
        $orderBy = filter_input(INPUT_GET, "orderby", FILTER_DEFAULT);
    endif;


    switch ($page) {
        case "prod":
            if (!isset($_GET['orderby'])):
                $orderBy="prod_id DESC";
            endif;
            $produtos = new ControllerProduct;
            $produtos->setOrderByResult($orderBy);
            echo $produtos->listProductsForEdit();

            break;
        case "forn":
            echo "Atualizar fornecedor";

            break;
        case "cat":
            echo "Atualizar categoria";

            break;
        case "line":
            if (!isset($_GET['orderby'])):
                $orderBy="line_id DESC";
            endif;
            $tabelaDeLinhas=new ControllerLineOfProduct;
            $tabelaDeLinhas->setOrderByResult($orderBy);
            echo $tabelaDeLinhas->listLinesOfProductsForEdit();
            

            break;

        default:
            break;
    }



