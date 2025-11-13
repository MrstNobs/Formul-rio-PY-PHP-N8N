<?php 
    require 'conn.class.php';
    require 'msg.class.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        
        if(empty($data['email_prop']) || empty($data['email_dstny']) || empty($data['nome_dstny']) || empty($data['msg_dstny'])){
            echo json_encode(['success'=>false, 'message'=>'Preencha todos os campos!']);
            exit;
        }

        $email_prop = $data['email_prop'];
        $email_dstny = $data['email_dstny'];
        $nome_dstny = $data['nome_dstny'];
        $msg_dstny = $data['msg_dstny'];

        try{
            $user = new Mensagem();
            $user->Create($email_prop, $email_dstny, $nome_dstny, $msg_dstny);

            echo json_encode(['success'=>true, 'message'=>'Mensagem Enviada!']);
        }catch(PDOException $e){
            echo json_encode(['error'=> $e->getMessage()]);
        }
    }
?>