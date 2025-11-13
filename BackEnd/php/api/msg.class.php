<?php 
    class Mensagem{
        public function Create($email_prop, $email_dstny, $nome_dstny, $msg_dstny){
            try{
                $pdo = Conn::getConn();
                $sql = "INSERT INTO Mensagens (email_prop, email_dstny, nome_dstny, msg_dstny) 
                        VALUES (:email_prop, :email_dstny, :nome_dstny, :msg_dstny)"
                ;
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':email_prop', $email_prop);
                $stmt->bindParam(':email_dstny', $email_dstny);
                $stmt->bindParam(':nome_dstny', $nome_dstny);
                $stmt->bindParam(':msg_dstny', $msg_dstny);

                $stmt->execute();
            }catch(PDOException $e){
                die("Erro na Inserçao: " . $e->getMessage());
            }
        }

        public function Read($email_prop){
            try{
                $pdo = Conn::getConn();
                $sql = "SELECT * FROM Mensagens WHERE email_prop = :email_prop";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':email_prop', $email_prop);

                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }catch(PDOException $e){
                die("Erro na Captura: " . $e->getMessage());
            }
        }

        public function Update($id, $msg_dstny){
            try{
                $pdo = Conn::getConn();
                $sql = "UPDATE Mensagens SET msg_dstny = :msg_dstny WHERE id = :id";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':msg_dstny', $msg_dstny);
                $stmt->bindParam(':id', $id);

                $stmt->execute();
            }catch(PDOException $e){
                die("Erro na Atualizacao: " . $e->getMessage());
            }
        }

        public function Delete($id){
            try{
                $pdo = Conn::getConn();
                $sql = "DELETE FROM Mensagens WHERE id = :id";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':id', $id);

                $stmt->execute();
            }catch(PDOException $e) {
                die("Erro na Del: " . $e->getMessage());
            }
        }
    }
?>