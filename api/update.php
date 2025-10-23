<?php
require "./config.php";
/** @var PDO $pdo */
$method = strtolower($_SERVER['REQUEST_METHOD']);

// o modelo do bady deve ser x-www-form-urlencoded ele nao reconhece JSON por padrao
if ($method === 'put') {

    // O php não possui filter_input por isso devemos pegar métodos diferentes de GET e POST dessa forma
    parse_str(file_get_contents('php://input'), $input);

    $id = filter_var($input['id'] ?? null);
    $title = filter_var($input['title'] ?? null);
    $body = filter_var($input['body'] ?? null);

    if($id && $title && $body){

        $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = $pdo->prepare("UPDATE notes SET title = :title, body = :body WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->bindValue(':title', $title);
            $sql->bindValue(':body', $body);
            $sql->execute();
            // Retornamos a anotação atualizada
            $array['result'] = [
                'id' => $id,
                'title' => $title,
                'body' => $body
            ];
        }else{
            $array['error'] = 'Não existe anotação com esse ID';
        }

    }else{
        $array['error'] = "Por favor preencha todos os campos";
    }

}else{
    $array['error'] = [ 'Method not allowed'];
}

require "./return.php";
