<?php 
    require './class/config.php';
    if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
        http_response_code(200);
        exit;
    }
    require './class/conn.class.php';
    require './class/prop.class.php';


    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $action = $data['action'] ?? '';

        if($action === 'cadastro'){
            if(empty($data['email_cadastro']) || empty($data['senha_cadastro'])){
                echo json_encode(['success'=>false, 'message'=>'Preencha Todos os campos!']);
                exit;
            } else{
                $email_cadastro = $data['email_cadastro'];
                $senha_cadastro = $data['senha_cadastro'];

                try{
                    $user = new Proprietario();
                    $user->Create($email_cadastro, $senha_cadastro);

                    echo json_encode(['success'=>true, 'message'=>'Cadastro criado com Sucesso!']);
                }catch(PDOException $e){
                    echo json_encode(['error'=> $e->getMessage()]);
                }
            }
        } elseif($action === 'login'){
            if(empty($data['email_login']) || empty($data['senha_login'])){
                echo json_encode(['success'=>false, 'message'=>'Preencha todos os campos!']);
                // echo "Todos os campos, amigo";
                exit;
            } else{
                $email_login = $data['email_login'];
                $senha_login = $data['senha_login'];

                try{
                    $user = new Proprietario();
                    $DadoGetUser = $user->Read($email_login);

                    if($DadoGetUser && password_verify($senha_login, $DadoGetUser['senha'])){
                        echo json_encode(['success'=>true, 'message'=>'Usuario Verificado', 'email_hidden'=> $DadoGetUser['email']]);
                    } else{
                        echo json_encode(['success'=>false, 'message'=>'Senha ou Usuario Incorretos!']);
                        // echo "Incorretos Senha ou Email";
                    }
                }catch(PDOException $e){
                    echo json_encode(['error'=> $e->getMessage()]);
                }
            }
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'PUT'){
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        if(empty($data['email_update']) || empty(['senha_update'])){
            echo json_encode(['success'=>false, 'message'=>'Preencha todos os campos!']);
            exit;
        }

        $email_update = $data['email_update'];
        $senha_update = $data['senha_update'];

        try{
            $user = new Proprietario();
            $DadosUpdate = $user->Update($email_update, $senha_update);

            echo json_encode(['success'=>true, 'message'=>'Atualização com Sucesso']);
        }catch(PDOException $e){
            echo json_encode(['error'=> $e->getMessage()]);
        }
    }

?>