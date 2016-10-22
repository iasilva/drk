<?php
require_once '../_app/Config.inc.php';

$string="<strong>\"PARABÉNS! VOCÊ FOI & O SORTEADO!</strong><br>";

//for($i=0;$i<strlen($string);$i++):
//    printf("A letra na posição %u é a letra <b>%s</b> <br>",$i,$string{$i});
//    if($string{$i}==="o"):
//        echo "<strong>PARABÉNS! VOCÊ FOI O SORTEADO!</strong><br>";
//    endif;
//endfor;
//
echo htmlspecialchars($string);