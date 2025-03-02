<?php
require_once '../model/DAO/ProdutoDAO.php';
$produtoDAO = new ProdutoDAO();

$produtos = [];
$produtos = array_merge($produtos, $produtoDAO->getProdutosByCategoria('cozinha'));
$produtos = array_merge($produtos, $produtoDAO->getProdutosByCategoria('cama'));
$produtos = array_merge($produtos, $produtoDAO->getProdutosByCategoria('ferramentas'));
$produtos = array_merge($produtos, $produtoDAO->getProdutosByCategoria('eletronicos'));
$produtos = array_merge($produtos, $produtoDAO->getProdutosByCategoria('games'));

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table img {
            max-width: 150px; 
            max-height: 150px;
            object-fit: cover;
        }
        .table td, .table th {
            vertical-align: middle;
            text-align: center; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">      
        <a href="javascript:history.back()" class="btn btn-primary mb-3">Voltar</a>

        <h1 class="text-center">Lista de Produtos</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($produtos) > 0): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td>
                                <img src="../img/<?php echo htmlspecialchars($produto['categoriaProd']); ?>/<?php echo htmlspecialchars($produto['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nomeProd']); ?>">
                            </td>
                            <td><?php echo htmlspecialchars($produto['nomeProd']); ?></td>
                            <td>R$ <?php echo number_format($produto['precoProd'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($produto['qtdProd']); ?></td>
                            <td>
                                <a href="editarProduto.php?id=<?php echo $produto['idProd']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="excluirProduto.php?id=<?php echo $produto['idProd']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhum produto encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
