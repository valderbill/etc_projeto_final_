<?php
require_once 'Conexao.php';

class CarrinhoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::getInstance(); // conexão com o banco
    }

    public function adicionarAoCarrinho($idUsu, $idProd, $quantidade) {
     
        $query = "SELECT idCarrinho, quantidade FROM carrinho WHERE idUsu = :idUsu AND idProd = :idProd";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUsu', $idUsu, PDO::PARAM_INT);
        $stmt->bindParam(':idProd', $idProd, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
           
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $novaQuantidade = $row['quantidade'] + $quantidade;
            
            if ($novaQuantidade > 0) {
               
                $updateQuery = "UPDATE carrinho SET quantidade = :quantidade WHERE idCarrinho = :idCarrinho";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bindParam(':quantidade', $novaQuantidade, PDO::PARAM_INT);
                $updateStmt->bindParam(':idCarrinho', $row['idCarrinho'], PDO::PARAM_INT);
                $updateStmt->execute();
            } else {
               
                $deleteQuery = "DELETE FROM carrinho WHERE idCarrinho = :idCarrinho";
                $deleteStmt = $this->conn->prepare($deleteQuery);
                $deleteStmt->bindParam(':idCarrinho', $row['idCarrinho'], PDO::PARAM_INT);
                $deleteStmt->execute();
            }
        } else {
        
            $queryInsert = "INSERT INTO carrinho (idUsu, idProd, quantidade) VALUES (:idUsu, :idProd, :quantidade)";
            $stmtInsert = $this->conn->prepare($queryInsert);
            $stmtInsert->bindParam(':idUsu', $idUsu, PDO::PARAM_INT);
            $stmtInsert->bindParam(':idProd', $idProd, PDO::PARAM_INT);
            $stmtInsert->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
            $stmtInsert->execute();
        }
    }

    public function getItensCarrinho($idUsu) {
 
        $query = "SELECT p.idProd, p.nomeProd, p.precoProd, p.qtdProd, p.imagem, p.categoriaProd, c.quantidade
                  FROM carrinho c
                  JOIN produto p ON c.idProd = p.idProd
                  WHERE c.idUsu = :idUsu";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUsu', $idUsu, PDO::PARAM_INT);
        $stmt->execute();

        $itensCarrinho = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          
            $itensCarrinho[] = $row;
        }

        return $itensCarrinho;
    }

    public function removerDoCarrinho($idUsu, $idProd) {
    
        $query = "DELETE FROM carrinho WHERE idUsu = :idUsu AND idProd = :idProd";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUsu', $idUsu, PDO::PARAM_INT);
        $stmt->bindParam(':idProd', $idProd, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function limparCarrinho($idUsu) {
   
        $query = "DELETE FROM carrinho WHERE idUsu = :idUsu";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUsu', $idUsu, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>
