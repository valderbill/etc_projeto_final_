<?php
session_start();

if (!isset($_SESSION['idUsu'])) {
    echo "Você precisa estar logado para finalizar a compra.";
    exit();
}

require_once('../model/DAO/Conexao.php');
require_once('../model/DAO/VendaDAO.php');
require_once('../model/DAO/ProdutoDAO.php');
require_once('../model/DAO/CarrinhoDAO.php');

$idUsu = $_SESSION['idUsu'];

$conn = Conexao::getInstance();

$carrinhoDAO = new CarrinhoDAO();
$vendaDAO = new VendaDAO();
$produtoDAO = new ProdutoDAO();

$produtosNoCarrinho = $carrinhoDAO->getItensCarrinho($idUsu);

$conn->beginTransaction();

try {
   
    foreach ($produtosNoCarrinho as $item) {
        $produtoId = $item['idProd'];
        $quantidadeCompra = $item['quantidade'];
        $precoProduto = $item['precoProd'];

        $produtoDAO->atualizarEstoque($produtoId, $quantidadeCompra);

        $vendaDAO->registrarVenda($idUsu, $produtoId, $quantidadeCompra, $precoProduto);

        $carrinhoDAO->removerItemCarrinho($idUsu, $produtoId);
    }

    $conn->commit();

    header('Location: notaFiscal.php');
    exit();
} catch (Exception $e) {
   
    $conn->rollBack();
    echo "Erro ao finalizar a compra: " . $e->getMessage();
}
?>
