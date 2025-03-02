<?php
require_once '../model/DAO/ProdutoDAO.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $produtoID = $_GET['id'];
   
    $produtoDAO = new ProdutoDAO();    
    $produto = $produtoDAO->getProdutoById($produtoID);

    if (!$produto) {
        header('Location: http://localhost/projeto_final_dezembro/view/listarProduto.php');
        exit;
    }
} else {
   
    header('Location: http://localhost/projeto_final_dezembro/view/listarProduto.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $nomeProd = $_POST['nomeProd'];
    $precoProd = $_POST['precoProd'];
    $qtdProd = $_POST['qtdProd'];
    $categoriaProd = $_POST['categoriaProd'];
    $imagem = $_POST['imagem']; 

    $produtoAtualizado = [
        'idProd' => $produtoID,
        'nomeProd' => $nomeProd,
        'precoProd' => $precoProd,
        'qtdProd' => $qtdProd,
        'categoriaProd' => $categoriaProd,
        'imagem' => $imagem 
    ];

    if ($produtoDAO->atualizarProduto($produtoAtualizado)) {
     
        header('Location: http://localhost/projeto_final_dezembro/view/listarProduto.php');
        exit;
    } else {
        $erro = "Erro ao atualizar o produto!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Produto</h1>

        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form action="editarProduto.php?id=<?php echo $produto['idProd']; ?>" method="POST">
            <div class="form-group">
                <label for="nomeProd">Nome do Produto</label>
                <input type="text" class="form-control" id="nomeProd" name="nomeProd" value="<?php echo htmlspecialchars($produto['nomeProd']); ?>" required>
            </div>
            <div class="form-group">
                <label for="precoProd">Preço</label>
                <input type="number" class="form-control" id="precoProd" name="precoProd" value="<?php echo htmlspecialchars($produto['precoProd']); ?>" required>
            </div>
            <div class="form-group">
                <label for="qtdProd">Quantidade</label>
                <input type="number" class="form-control" id="qtdProd" name="qtdProd" value="<?php echo htmlspecialchars($produto['qtdProd']); ?>" required>
            </div>
            <div class="form-group">
                <label for="categoriaProd">Categoria</label>
                <select class="form-control" id="categoriaProd" name="categoriaProd" required>
                    <option value="cozinha" <?php echo ($produto['categoriaProd'] == 'cozinha') ? 'selected' : ''; ?>>Cozinha</option>
                    <option value="cama" <?php echo ($produto['categoriaProd'] == 'cama') ? 'selected' : ''; ?>>Cama</option>
                    <option value="eletronicos" <?php echo ($produto['categoriaProd'] == 'eletronicos') ? 'selected' : ''; ?>>Eletrônicos</option>
                    <option value="ferramentas" <?php echo ($produto['categoriaProd'] == 'ferramentas') ? 'selected' : ''; ?>>Ferramentas</option>
                    <option value="games" <?php echo ($produto['categoriaProd'] == 'games') ? 'selected' : ''; ?>>Games</option>
                </select>
            </div>
            <div class="form-group">
                <label for="imagem">Imagem (URL ou Caminho)</label>
                <input type="text" class="form-control" id="imagem" name="imagem" value="<?php echo htmlspecialchars($produto['imagem']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Produto</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
