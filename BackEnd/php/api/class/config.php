<?php 
    use Dotenv\Dotenv;

    $vendor_path = dirname(__DIR__) . '/vendor/autoload.php';
    $dotenv_dir = __DIR__;

    if(file_exists($vendor_path)){
        require $vendor_path;
        if(class_exists('Dotenv\Dotenv')){
            try{
                $dotenv = Dotenv::createImmutable($dotenv_dir);
                $dotenv->safeLoad();
            }catch(\Throwable $e){
                error_log('Falha no carregametno do Dotenv em config.php: ' . $e->getMessage());
            }
        } 
    } else { 
        error_log('Erro no caminho do autoload.php');
    }

    $allow_origin = $_ENV['URL_FRONT'] ?? 'http://localhost:5173';

    header("Access-Control-Allow-Origin: $allow_origin");
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
?>
