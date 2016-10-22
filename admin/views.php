<?php
require_once '../_app/Config.inc.php';
$cat=new ControllerCategory;
return $cat->getCategory(3)->getCat_name();

?>