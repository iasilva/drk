<?php
define("BASE_TITLE"," - Drika's, a loja online da mulher brasileira");
$title=array(
    "cad-forn"=>"Cadastro de fornecedor". BASE_TITLE,     
    "cad-prod"=>"Cadastro de produto". BASE_TITLE,
    "Up"=>"Atualizando". BASE_TITLE
);
 $action = filter_input(INPUT_GET, "action", FILTER_DEFAULT);
?>




<!DOCTYPE html>
<html lang="pt-br">    
    <head>
        <title><?php echo $title=(isset($title[$action]))? $title[$action]:"Página administrativa da Drika's online"?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Inserindo os links de CSS relacionados ao BOOTSTRAP-->
        <link href="../css/bootstrap/css/bootstrap.min.css" rel="stylesheet">  
        <!--CSS PRÓPRIO - PALETA DE CORES-->
        <link href="../css/paleta.css" rel="stylesheet">  
        <!--CSS PRÓPRIO - ESTILO -->
        <link href="../css/style.css" rel="stylesheet"> 
        <!--CSS PRÓPRIO - sidebar da página ADMIN -->
        <link href="../css/sidebar-admin.css" rel="stylesheet"> 

    </head>
    <body>