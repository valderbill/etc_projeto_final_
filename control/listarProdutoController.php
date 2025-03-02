<?php
require_once '../model/DAO/ProdutoDAO.php';

$produtoDAO = new ProdutoDAO();
$todos = $produtoDAO->listarProduto(); 
?>
