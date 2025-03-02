<?php
session_start();

if (!isset($_SESSION['idUsu'])) {
    echo "Você precisa estar logado para ver o carrinho.";
    exit();
}

require_once('../model/DAO/CarrinhoDAO.php');

$idUsu = $_SESSION['idUsu'];

$carrinhoDAO = new CarrinhoDAO();

$produtosNoCarrinho = $carrinhoDAO->getItensCarrinho($idUsu);

$finalizada = isset($_GET['finalizada']) && $_GET['finalizada'] == 'sim';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        table {
            font-size: 1.2rem;
        }

        .preco {
            font-size: 1.4rem; 
            color: red;
            font-weight: bold;
        }

        img {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
        }

        .btn-remove {
            color: #fff;
            background-color: #dc3545;
        }

        .btn-remove:hover {
            background-color: #c82333;
        }

        td, th {
            vertical-align: middle !important;
            text-align: center;
        }

        .btn-actions {
            text-align: center;
        }

        .btn-finalizar {
            margin-top: 20px;
            background-color: #28a745;
            color: #fff;
        }

        .btn-finalizar:hover {
            background-color: #218838;
        }

        .container {
            margin-bottom: 50px; 
        }

        .preco-destaque {
            font-size: 1.6rem;
            font-weight: bold;
            color: green;
        }

        .preco-desconto {
            font-size: 1.2rem;
            text-decoration: line-through;
            color: red;
        }

        .mensagem-finalizada {
            font-size: 4rem; 
            font-weight: bold; 
            color: green;  
            text-align: center; 
            margin-top: 50px; 
        }

    </style>
</head>
<body>

<div class="container mt-5">
    <?php if (!$finalizada): ?>
        <h2>Itens no Carrinho</h2>

        <?php if (!empty($produtosNoCarrinho)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Total</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totalCompra = 0; ?>
                    <?php foreach ($produtosNoCarrinho as $item): ?>
                        <?php
                            $produto = $item; 
                            $quantidade = $item['quantidade'];
                            $precoTotal = $produto['precoProd'] * $quantidade;
                            $totalCompra += $precoTotal;
                        ?>
                        <tr>
                            <td>
                                <img src="../img/<?php echo htmlspecialchars($produto['categoriaProd']); ?>/<?php echo htmlspecialchars($produto['imagem']); ?>" 
                                     alt="<?php echo htmlspecialchars($produto['nomeProd']); ?>">
                            </td>
                            <td><?php echo htmlspecialchars($produto['nomeProd']); ?></td>
                            <td><?php echo $quantidade; ?></td>
                            <td>R$ <?php echo number_format($produto['precoProd'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($precoTotal, 2, ',', '.'); ?></td>
                            <td class="btn-actions">
                                <a href="../control/totalCarrinhoController.php?produtoId=<?php echo $produto['idProd']; ?>&acao=decrement" class="btn btn-danger btn-sm">-</a>
                                <a href="../control/totalCarrinhoController.php?produtoId=<?php echo $produto['idProd']; ?>&acao=increment" class="btn btn-success btn-sm">+</a>
                                <a href="../control/totalCarrinhoController.php?produtoId=<?php echo $produto['idProd']; ?>&acao=remover" class="btn btn-remove btn-sm">
                                    <i class="bi bi-trash"></i> 
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3>Total da Compra: R$ <?php echo number_format($totalCompra, 2, ',', '.'); ?></h3>
            <h4>Escolha a forma de pagamento</h4>
            <form id="form-pagamento">
                <div class="form-group">
                    <label for="pagamento">Forma de pagamento:</label>
                    <select class="form-control" id="pagamento" name="pagamento" onchange="calcularPagamento()">
                        <option value="avista">À vista (10% de desconto)</option>
                        <option value="parcelado_3x">Até 3x sem juros</option>
                        <option value="parcelado_4_6x">De 4 a 6x com 3% de juros</option>
                        <option value="parcelado_7_12x">De 7 a 12x com 5% de juros</option>
                    </select>
                </div>
            </form>

            <div id="detalhes-pagamento">
                <p>Preço original: <span class="preco-desconto">R$ <?php echo number_format($totalCompra, 2, ',', '.'); ?></span></p>
                <p>Preço final: <span id="preco-final" class="preco-destaque">R$ <?php echo number_format($totalCompra, 2, ',', '.'); ?></span></p>
            </div>

            <button type="button" class="btn btn-primary" onclick="calcularPagamento()">Recalcular Preço</button>

            <script>
                function calcularPagamento() {
                    var totalCompra = <?php echo $totalCompra; ?>;
                    var pagamento = document.getElementById('pagamento').value;
                    var precoFinal = totalCompra;

                    if (pagamento === 'avista') {
                        precoFinal = totalCompra * 0.90; // 10% de desconto
                    } else if (pagamento === 'parcelado_3x') {
                        precoFinal = totalCompra;
                    } else if (pagamento === 'parcelado_4_6x') {
                        precoFinal = totalCompra * 1.03; // 3% de juros
                    } else if (pagamento === 'parcelado_7_12x') {
                        precoFinal = totalCompra * 1.05; // 5% de juros
                    }

                    document.getElementById('preco-final').innerText = "R$ " + precoFinal.toFixed(2).replace(".", ",");
                }
            </script>

            <div class="text-right mt-4">
                <?php
                    if (isset($_SESSION['idUsu'])) {
                        echo '<a href="../control/totalCarrinhoController.php?acao=finalizar" class="btn btn-finalizar">Finalizar Compra</a>';
                    } else {
                        echo '<a href="login.php" class="btn btn-finalizar">Faça login para finalizar a compra</a>';
                    }
                ?>
                <br>
               
                <a href="http://localhost/projeto_final_dezembro/view/public/home.php" class="btn btn-primary mt-2">Voltar para a loja</a>
                <br>
               
                <a href="http://localhost/projeto_final_dezembro/view/notaFiscal.php" class="btn btn-secondary mt-2">Gerar Nota Fiscal</a>
            </div>

        <?php else: ?>
            <p>Seu carrinho está vazio.</p>
        <?php endif; ?>
    <?php else: ?>
        <p class="mensagem-finalizada">Obrigado por comprar na Good Bye! Sua compra foi finalizada com sucesso. 
            <br> Aguardamos você em breve para novas compras.</p>
        <div class="text-right mt-4">
            <a href="http://localhost/projeto_final_dezembro/logOff.php" class="btn btn-primary mt-2">Sair</a>
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</body>
</html>
