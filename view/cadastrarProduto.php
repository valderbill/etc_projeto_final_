<?php
require_once '../model/DAO/ProdutoDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_FILES['imagemProd']) && $_FILES['imagemProd']['error'] === UPLOAD_ERR_OK) {
       
        $categoria = $_POST['categoriaProd'];
        $targetDir = "../img/$categoria/";
        
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetFile = $targetDir . basename($_FILES['imagemProd']['name']);
        
        if (move_uploaded_file($_FILES['imagemProd']['tmp_name'], $targetFile)) {
          
            $produto = [
                'nomeProd' => $_POST['nomeProd'],
                'precoProd' => $_POST['precoProd'],
                'qtdProd' => $_POST['qtdProd'],
                'categoriaProd' => $categoria,
                'imagem' => $_FILES['imagemProd']['name']
            ];

            $produtoDAO = new ProdutoDAO();
            if ($produtoDAO->cadastrarProduto($produto)) {
                header("Location: ../view/public/$categoria.php");
                exit;
            } else {
                echo "Falha ao cadastrar produto.";
            }
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    } else {
        echo "Erro no upload da imagem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">      
        <a href="javascript:history.back()" class="btn btn-primary mb-3">Voltar</a>

        <h1>Cadastrar Produto</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nomeProd">Nome do Produto</label>
                <input type="text" class="form-control" id="nomeProd" name="nomeProd" required>
            </div>
            <div class="form-group">
                <label for="precoProd">Preço</label>
                <input type="text" class="form-control" id="precoProd" name="precoProd" required>
            </div>
            <div class="form-group">
                <label for="qtdProd">Quantidade</label>
                <input type="number" class="form-control" id="qtdProd" name="qtdProd" required>
            </div>
            <div class="form-group">
                <label for="categoriaProd">Categoria</label>
                <select class="form-control" id="categoriaProd" name="categoriaProd" required>
                    <option value="">Selecione uma categoria</option>
                    <option value="cozinha">Cozinha</option>
                    <option value="cama">Cama, Mesa e Banho</option>
                    <option value="ferramentas">Ferramentas</option>
                    <option value="games">Games</option>
                    <option value="eletronicos">Eletrônicos</option>
                </select>
            </div>
            <div class="form-group">
                <label for="imagemProd">Imagem do Produto</label>
                <input type="file" class="form-control" id="imagemProd" name="imagemProd" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
        </form>
    </div>
</body>
</html>
