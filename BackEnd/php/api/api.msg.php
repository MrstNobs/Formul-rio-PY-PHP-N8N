<?php 
    require './class/config.php';
    // if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    //     http_response_code(200);
    //     exit;
    // }
    require './class/conn.class.php';
    require './class/msg.class.php';

    require __DIR__ . '../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

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
            try{
                $url = $_ENV['URL_PY_ENV_MSG'];
                $dtN8N = array(
                    'email_dstny' => $email_dstny,
                    'nome_dstny'  => $nome_dstny,
                    'msg_dstny'   => $msg_dstny
                );
                $ch = curl_init($url);
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($dtN8N),
                    CURLOPT_HTTPHEADER => ['Content-Type: application/json']
                ]);                

                $resposta = curl_exec($ch);
                curl_close($ch);

            }catch(PDOException $e){
                echo json_encode(['success'=>false, 'message'=>'Erro ao enviar Requisição']);
            }
            echo json_encode(['success'=>true, 'message'=>'Mensagem Enviada!']);
            
        }catch(PDOException $e){
            echo json_encode(['error'=> $e->getMessage()]);
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        header('Content-Type: application/json');
        
        // $data = json_decode(file_get_contents('php://input'), true);

        // if(empty($data['email_prop'])){
        //     echo json_encode(['success'=>false, 'message'=>'Email do Proprietário não encotrado']);
        //     exit;
        // }

        // $email_prop = $data['email_prop'];

        $email_prop = $_GET['email_prop'];

        try{
            $Mensagem = new Mensagem();
            $UserMensagem = $Mensagem->Read($email_prop);

            // Estou pegando apenas as mensagem enviaada do Proprietario
            foreach($UserMensagem as $msg){
                $resultado[] = $msg['msg_dstny'];

                // echo json_encode($msg['email_dstny']);
                // echo " ";
            }

            echo json_encode($resultado);

        }catch(PDOException $e){
            echo json_encode(['error'=> $e->getMessage()]);
        }
    }
?>