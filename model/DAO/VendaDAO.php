<?php
require_once 'Conexao.php';

class VendaDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function registrarVenda($venda) {
        try {
            $sql = "INSERT INTO vendas (idUsu, idProd, quantidadeVendida, dataVenda) 
                    VALUES (:idUsu, :idProd, :quantidadeVendida, NOW())";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idUsu', $venda['idUsu'], PDO::PARAM_INT);
            $stmt->bindParam(':idProd', $venda['idProd'], PDO::PARAM_INT);
            $stmt->bindParam(':quantidadeVendida', $venda['quantidadeVendida'], PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao registrar venda: " . $e->getMessage();
            return false;
        }
    }
}
?>
