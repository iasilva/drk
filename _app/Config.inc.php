<?php
define('HOME', 'http://localhost/drk/public/');

date_default_timezone_set('America/Sao_Paulo');

// CONFIGRAÇÕES DO SITE ####################
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '123456');
define('DBSA', 'drk');

// AUTO LOAD DE CLASSES ####################
function __autoload($Class) {

    $cDir = ['Conn', '../Helpers', 'Models','../Controller'];
    $iDir = null;

    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . "\\{$dirName}\\{$Class}.class.php") && !is_dir(__DIR__ . "\\{$dirName}\\{$Class}.class.php")):
            include_once (__DIR__ . "\\{$dirName}\\{$Class}.class.php");
            $iDir = true;
        endif;
    endforeach;

    if (!$iDir):
        drkMsg("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
        die;
    endif;
}

// TRATAMENTO DE ERROS #####################
//CSS constantes :: Mensagens de Erro
define('MSG_SUCCESS', 'alert-success');
define('MSG_INFOR', 'alert-info');
define('MSG_ALERT', 'alert-warning');
define('MSG_ERROR', 'alert-danger');





//WSErro :: Exibe erros lançados :: Front
function drkMsg($ErrMsg, $ErrNo, $ErrDie = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? MSG_INFOR : ($ErrNo == E_USER_WARNING ? MSG_ALERT : ($ErrNo == E_USER_ERROR ? MSG_ERROR : $ErrNo)));
    echo "<div class='row'style='margin:24px;'>";
    
    echo "<div class=\"alert {$CssClass}\" style=\"max-width:450px;\">{$ErrMsg}</div>";
    echo"</div>";
    if ($ErrDie):
        die;
    endif;
}

//PHPErro :: personaliza o gatilho do PHP
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? MSG_INFOR : ($ErrNo == E_USER_WARNING ? MSG_ALERT : ($ErrNo == E_USER_ERROR ? MSG_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">";
    echo "<b>Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class=\"ajax_close\"></span></p>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

set_error_handler('PHPErro');
