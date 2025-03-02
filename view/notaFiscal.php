<?php
session_start();

if (!isset($_SESSION['idUsu'])) {
    header("Location: login.php");
    exit();
}

require_once('../model/DAO/UsuarioDAO.php');
require_once('../model/DAO/CarrinhoDAO.php');
require_once('../model/DTO/UsuarioDTO.php');
require_once('../vendor/autoload.php');

// Obtenção dos dados do carrinho e do usuário
$carrinhoDAO = new CarrinhoDAO();
$idUsu = $_SESSION['idUsu'];
$produtosNoCarrinho = $carrinhoDAO->getItensCarrinho($idUsu);

$usuarioDAO = new UsuarioDAO();
$usuarioData = $usuarioDAO->pesquisarUsuarioPorId($idUsu); 

$usuarioDTO = new UsuarioDTO();
$usuarioDTO->setIdUsu($usuarioData['idUsu']);
$usuarioDTO->setNomeUsu($usuarioData['nomeUsu']);
$usuarioDTO->setCpfUsu($usuarioData['cpfUsu']);
$usuarioDTO->setEmailUsu($usuarioData['emailUsu']);
$usuarioDTO->setTelefoneWhatsApp($usuarioData['telefoneWhatsApp']);
$usuarioDTO->setLogradouro($usuarioData['logradouro']);
$usuarioDTO->setBairro($usuarioData['bairro']);
$usuarioDTO->setCidade($usuarioData['cidade']);
$usuarioDTO->setEstado($usuarioData['estado']);

// Lógica para calcular o total da compra e aplicar desconto ou juros
$totalCompraOriginal = 0;
foreach ($produtosNoCarrinho as $item) {
    $totalCompraOriginal += $item['precoProd'] * $item['quantidade'];
}

// Verificação da forma de pagamento
$pagamento = isset($_GET['pagamento']) ? $_GET['pagamento'] : 'avista';
$totalCompraFinal = $totalCompraOriginal;

if ($pagamento == 'avista') {
    // 10% de desconto para pagamento à vista
    $totalCompraFinal *= 0.90;
} elseif ($pagamento == 'parcelado_3x') {
    // Até 3x sem juros
    $totalCompraFinal = $totalCompraOriginal;
} elseif ($pagamento == 'parcelado_4_6x') {
    // De 4 a 6x com 3% de juros
    $totalCompraFinal *= 1.03;
} elseif ($pagamento == 'parcelado_7_12x') {
    // De 7 a 12x com 5% de juros
    $totalCompraFinal *= 1.05;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Fiscal</title>   
    <link rel="stylesheet" href="nota.css">

    <style>
        /* Estilo para o tamanho da fonte do Valor Total dos Produtos */
        .total {
            font-size: 12px; /* Tamanho da fonte reduzido */
        }
    </style>
</head>
<body>

<div class="container nota-fiscal">
   
    <div class="header">
        <!-- Imagem no canto esquerdo -->
        <img src="../img/nota.jpg" alt="Escola Tecnica de Ceilândia">
        
        <!-- Título "Good Bye Ecommerce" centralizado -->
        <div class="company-info">
            <p class="company-name">Good Bye Ecommerce</p>
            <p class="company-address">Endereço: St. N, Área Especial QNN 14 - Ceilândia, Brasília - DF</p>
        </div>
        
        <!-- Título "Nota Fiscal" no canto direito -->
        <h3 class="nota-fiscal-title">Nota Fiscal</h3>
    </div>

    <div class="container-info">
        <h3>Dados do Cliente</h3>
        <table>
            <tr>
                <th>Nome</th>
                <td><?php echo htmlspecialchars($usuarioDTO->getNomeUsu()); ?></td>
            </tr>
            <tr>
                <th>CPF</th>
                <td><?php echo htmlspecialchars($usuarioDTO->getCpfUsu()); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($usuarioDTO->getEmailUsu()); ?></td>
            </tr>
            <tr>
                <th>Telefone</th>
                <td><?php echo htmlspecialchars($usuarioDTO->getTelefoneWhatsApp()); ?></td>
            </tr>
            <tr>
                <th>Endereço</th>
                <td><?php echo htmlspecialchars($usuarioDTO->getLogradouro()) . ", " . htmlspecialchars($usuarioDTO->getBairro()) . " - " . htmlspecialchars($usuarioDTO->getCidade()) . " / " . htmlspecialchars($usuarioDTO->getEstado()); ?></td>
            </tr>
        </table>
    </div>

    <h3>Produtos Comprados</h3>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($produtosNoCarrinho as $item) {
                $precoTotal = $item['precoProd'] * $item['quantidade'];
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item['nomeProd']); ?></td>
                <td><?php echo $item['quantidade']; ?></td>
                <td>R$ <?php echo number_format($item['precoProd'], 2, ',', '.'); ?></td>
                <td>R$ <?php echo number_format($precoTotal, 2, ',', '.'); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Alterando o tamanho da fonte para o valor total -->
    <h3 class="total">R$ <?php echo number_format($totalCompraOriginal, 2, ',', '.'); ?></h3>
    <h3 class="total">Valor a pagar: R$ <?php echo number_format($totalCompraFinal, 2, ',', '.'); ?></h3>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
