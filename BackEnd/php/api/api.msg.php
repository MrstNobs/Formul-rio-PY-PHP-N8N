<?php 
    require './class/config.php';

    if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
        http_response_code(200);
        exit;
    }
    
    require './class/conn.class.php';
    require './class/msg.class.php';

    use Dotenv\Dotenv;

    $dotenv_dir = __DIR__;

    require __DIR__ . '/vendor/autoload.php';

    try{
        $dotenv = Dotenv::createImmutable($dotenv_dir);
        $dotenv->load();
        $url = $_ENV['URL_PY_ENV_MSG'];
    }catch(\Throwable $e){
        header('Content-Type: application/json', true, 500);
        echo json_encode(['success'=>false, 'message'=>'Erro na configuração do ambiente (Dotenv falhou)']);
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        
        if(empty($data['email_prop']) || empty($data['email_dstny']) || empty($data['nome_dstny']) || empty($data['msg_dstny'])){
            http_response_code(400); //Bad Request
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
            
            $dtN8N = array(
                'email' => $email_dstny,
                'nome'  => $nome_dstny,
                'mensagem'   => $msg_dstny
            );

            if(empty($url)){
                http_response_code(503); // Service Unavaible
                echo json_encode(['success'=>false, 'message'=>'URL da API de Webhook não configurada no .env']);
                exit;
            }

            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($dtN8N),
                CURLOPT_HTTPHEADER => ['Content-Type: application/json']
            ]);                

            $resposta = curl_exec($ch);
            $curl_error = curl_error($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($curl_error){
                http_response_code(502); // Bad GateWay
                echo json_encode(['success'=>false, 'message'=>'Erro na comunicação cURL'.$curl_error]);
                exit;
            }

            if($http_code < 200 || $http_code >= 300){
                http_response_code(502); // Bad Gateway
                echo json_encode(['success'=>false, 'message'=>'Erro ao enviar para o serviço externo. Status HTPP : '.$http_code]);
                exit;
            }

            http_response_code(200);
            echo json_encode(['success'=>true, 'message'=>'Mensagem Enviada!']);
            
        }catch(PDOException $e){
            http_response_code(500);
            echo json_encode(['error'=> $e->getMessage()]);
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        header('Content-Type: application/json');

        $email_prop = $_GET['email_prop'];

        try{
            $Mensagem = new Mensagem();
            $UserMensagem = $Mensagem->Read($email_prop);

            // Estou pegando apenas as mensagem enviaada do Proprietario
            $resultado = [];
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