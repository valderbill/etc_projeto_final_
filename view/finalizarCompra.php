<?php
session_start();

if (!isset($_SESSION['idUsu'])) {
    echo "Você precisa estar logado para finalizar a compra.";
    exit();
}

require_once('../model/DAO/ProdutoDAO.php');
require_once('../model/DAO/VendaDAO.php');
require_once('../model/DAO/CarrinhoDAO.php');

$idUsu = $_SESSION['idUsu'];
$carrinhoDAO = new CarrinhoDAO();
$produtoDAO = new ProdutoDAO();
$vendaDAO = new VendaDAO();

$produtosNoCarrinho = $carrinhoDAO->getItensCarrinho($idUsu);

if (empty($produtosNoCarrinho)) {
    echo "Seu carrinho está vazio!";
    exit();
}

$totalCompra = 0;

foreach ($produtosNoCarrinho as $item) {
    $produto = $item;
    $quantidade = $item['quantidade'];
    $precoTotal = $produto['precoProd'] * $quantidade;
    $totalCompra += $precoTotal;

    if ($produto['qtdProd'] < $quantidade) {
        echo "Estoque insuficiente para o produto: " . $produto['nomeProd'];
        exit();
    }

    $produtoDAO->atualizarEstoque($produto['idProd'], $quantidade);

    $vendaDAO->registrarVenda([
        'idUsu' => $idUsu,
        'idProd' => $produto['idProd'],
        'quantidadeVendida' => $quantidade
    ]);

    $carrinhoDAO->removerDoCarrinho($idUsu, $produto['idProd']);
}

echo "<div class='container mt-5 text-center'>";
echo "<h2>Compra finalizada com sucesso!</h2>";
echo "<p>Total da compra: R$ " . number_format($totalCompra, 2, ',', '.') . "</p>";
echo "<h4>Obrigado por visitar nossa loja! Good Bye!</h4>";
echo "<div class='mt-4'>";
echo "<a href='http://localhost/projeto_final_dezembro/view/notaFiscal.php' class='btn btn-primary mr-3'>
        <i class='bi bi-file-earmark-pdf'></i> Ver Nota Fiscal
      </a>";
echo "<a href='http://localhost/projeto_final_dezembro/view/public/home.php' class='btn btn-secondary'>
        <i class='bi bi-house-door'></i> Voltar para a Página Inicial
      </a>";
echo "</div>";
echo "</div>";
?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
