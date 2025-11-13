<?php 
    class Proprietario{
        public function Create($email, $senha){
            try{
                $sql = "INSERT INTO Proprietario (email, senha) VALUES (:email, :senha)";
                $stmt = Conn::getConn()->prepare($sql);

                $hash = password_hash($senha, PASSWORD_DEFAULT);

                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':senha', $hash);

                $stmt->execute();
            }catch(PDOException $e){
                error_log("Erro na inserção: " . $e->getMessage());
            }
        }

        public function Read($email){
            try{
                $sql = "SELECT * FROM Proprietario WHERE email = :email";
                $stmt = Conn::getConn()->prepare($sql);

                $stmt->bindParam(':email', $email);

                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);
            }catch(PDOException $e){
                die("Erro na captura: " . $e->getMessage());
            }
        }

        public function Update($email, $senha){
            try{
                $pdo = Conn::getConn();
                $sql = "UPDATE Proprietario SET senha = :senha WHERE email = :email";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':senha', $senha);
                $stmt->bindParam(':email', $email);

                $stmt->execute();
            }catch(PDOException $e){
                die("Error na Atualização: " . $e->getMessage());
            }
        }

        public function Delete($id){
            try{
                $pdo = Conn::getConn();
                $sql = "DELETE FROM Proprietario WHERE id = :id";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':id', $id);

                $stmt->execute();
            }catch(PDOException $e){
                die("Erro na DELETAR: " . $e->getMessage());
            }
        }
    }
?>