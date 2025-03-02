<?php

require_once '../model/DAO/ProdutoDAO.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $produtoID = $_GET['id'];     
    $produtoDAO = new ProdutoDAO();  
    
    if ($produtoDAO->excluirProduto($produtoID)) {
      
        header('Location: http://localhost/projeto_final_dezembro/view/listarProduto.php'); 
        exit;
    } else {
       
        echo "Erro ao excluir o produto!";
    }
} else {
   
    header('Location: http://localhost/projeto_final_dezembro/view/listarProduto.php'); 
    exit;
}
?>
