<?php
require "./config.php";
/** @var PDO $pdo */
$method = strtolower($_SERVER['REQUEST_METHOD']);

// o modelo do bady deve ser x-www-form-urlencoded ele nao reconhece JSON por padrao
if ($method === 'delete') {

    // O php não possui filter_input por isso devemos pegar métodos diferentes de GET e POST dessa forma
    parse_str(file_get_contents('php://input'), $input);

    $id = filter_var($input['id'] ?? null);

    if($id){
        $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = $pdo->prepare("DELETE FROM notes WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            // Retornamos a anotação atualizada
            $array['result'] = [
                'id' => $id,
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
