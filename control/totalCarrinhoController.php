<?php
require_once '../model/DAO/CarrinhoDAO.php';
require_once '../model/DAO/VendaDAO.php'; // Importando o VendaDAO
session_start();

$idUsu = $_SESSION['idUsu'];
$acao = $_GET['acao'];

$carrinhoDAO = new CarrinhoDAO();
$vendaDAO = new VendaDAO();

if ($acao == 'increment') {
    $carrinhoDAO->adicionarAoCarrinho($idUsu, $_GET['produtoId'], 1);  
} elseif ($acao == 'decrement') {
    $carrinhoDAO->adicionarAoCarrinho($idUsu, $_GET['produtoId'], -1); 
} elseif ($acao == 'remover') {
    $carrinhoDAO->removerDoCarrinho($idUsu, $_GET['produtoId']); 
}

// Finalizar a compra
if ($acao == 'finalizar') {
    // Obter todos os itens no carrinho
    $produtosNoCarrinho = $carrinhoDAO->getItensCarrinho($idUsu);

    // Registrar as vendas e limpar o carrinho
    foreach ($produtosNoCarrinho as $produto) {
        $venda = [
            'idUsu' => $idUsu,
            'idProd' => $produto['idProd'],
            'quantidadeVendida' => $produto['quantidade']
        ];
        // Registrar cada venda
        $vendaDAO->registrarVenda($venda);
    }

    // Limpar o carrinho após a venda
    $carrinhoDAO->limparCarrinho($idUsu);

    // Redireciona para a página mostraCarrinho.php com o parâmetro finalizada=sim
    header('Location: ../view/mostraCarrinho.php?finalizada=sim');
    exit();
}

header('Location: ../view/mostraCarrinho.php');
exit();
?>
