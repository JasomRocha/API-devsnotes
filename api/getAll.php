<?php
require "./config.php";

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'get') {
    $sql = $pdo->query("SELECT * FROM `notes`");
    if($sql->rowCount() > 0){
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach($data as $d){
            $array['result'][] = [
                'id' => $d['id'],
                'title' => $d['title'],
            ];
        }
    }
}else{
    $array['error'] = [ 'Method not allowed'];
}

require "./return.php";