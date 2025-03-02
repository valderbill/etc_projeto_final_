<?php
require_once '../model/DAO/ProdutoDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto = [
        'nomeProd' => $_POST['nomeProd'],
        'precoProd' => $_POST['precoProd'],
        'qtdProd' => $_POST['qtdProd'],
        'categoriaProd' => $_POST['categoriaProd'],
        'imagem' => $_FILES['imagemProd']['name']
    ];

    $targetDir = "../img/" . $produto['categoriaProd'] . "/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); 
    }
    move_uploaded_file($_FILES["imagemProd"]["tmp_name"], $targetDir . basename($_FILES["imagemProd"]["name"]));

    $produtoDAO = new ProdutoDAO();
    if ($produtoDAO->cadastrarProduto($produto)) {
        header("Location: ../view/listarProduto.php"); 
        exit;
    } else {
        echo "Falha ao cadastrar produto.";
    }
}
?>
