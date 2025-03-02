<?php
require_once 'Conexao.php';

class ProdutoDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function cadastrarProduto($produto) {
        try {
            $sql = "INSERT INTO produto (nomeProd, precoProd, qtdProd, categoriaProd, imagem) 
                    VALUES (:nomeProd, :precoProd, :qtdProd, :categoriaProd, :imagem)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nomeProd', $produto['nomeProd']);
            $stmt->bindParam(':precoProd', $produto['precoProd']);
            $stmt->bindParam(':qtdProd', $produto['qtdProd']);
            $stmt->bindParam(':categoriaProd', $produto['categoriaProd']);
            $stmt->bindParam(':imagem', $produto['imagem']);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar produto: " . $e->getMessage();
            return false;
        }
    }

    public function getProdutosByCategoria($categoria) {
        try {
            $sql = "SELECT * FROM produto WHERE categoriaProd = :categoriaProd";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':categoriaProd', $categoria);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar produtos: " . $e->getMessage();
            return [];
        }
    }

    public function getProdutoById($idProd) {
        try {
            $sql = "SELECT * FROM produto WHERE idProd = :idProd";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idProd', $idProd, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar produto: " . $e->getMessage();
            return false;
        }
    }

    public function atualizarProduto($produto) {
        try {
            $sql = "UPDATE produto SET 
                    nomeProd = :nomeProd, 
                    precoProd = :precoProd, 
                    qtdProd = :qtdProd, 
                    categoriaProd = :categoriaProd, 
                    imagem = :imagem
                    WHERE idProd = :idProd";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idProd', $produto['idProd'], PDO::PARAM_INT);
            $stmt->bindParam(':nomeProd', $produto['nomeProd']);
            $stmt->bindParam(':precoProd', $produto['precoProd']);
            $stmt->bindParam(':qtdProd', $produto['qtdProd']);
            $stmt->bindParam(':categoriaProd', $produto['categoriaProd']);
            $stmt->bindParam(':imagem', $produto['imagem']);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao atualizar produto: " . $e->getMessage();
            return false;
        }
    }

    public function excluirProduto($idProd) {
        try {
            $sql = "DELETE FROM produto WHERE idProd = :idProd";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idProd', $idProd, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao excluir produto com ID $idProd: " . $e->getMessage();
            return false;
        }
    }

    public function atualizarEstoque($produtoId, $quantidadeVendida) {
        try {
            $sql = "UPDATE produto SET qtdProd = qtdProd - :quantidadeVendida WHERE idProd = :produtoId";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':quantidadeVendida', $quantidadeVendida, PDO::PARAM_INT);
            $stmt->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao atualizar estoque: " . $e->getMessage();
            return false;
        }
    }
}
?>
