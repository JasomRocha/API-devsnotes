<?php
require "./config.php";

$method = strtolower($_SERVER['REQUEST_METHOD']);

// o modelo do bady deve ser x-www-form-urlencoded ele nao reconhece JSON por padrao
if ($method === 'put') {


}else{
    $array['error'] = [ 'Method not allowed'];
}

require "./return.php";

