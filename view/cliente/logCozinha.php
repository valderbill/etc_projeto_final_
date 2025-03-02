<?php
session_start();
require_once '../../model/DAO/Conexao.php'; 

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    
    $conn = Conexao::getInstance();

    $query = "SELECT nomeUsu FROM usuario WHERE idUsu = :idUsu";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idUsu', $userId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $userName = $stmt->fetch(PDO::FETCH_ASSOC)['nomeUsu'];
    } else {
        $userName = "Usuário Desconhecido";
    }
} else {
    $userName = "Usuário";
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="view/cliente/styles.css" rel="stylesheet"> 
    <title>Página de Índices</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="mx-auto">
            <div class="nav-links d-flex justify-content-center">
                <a class="nav-item nav-link" href="index.php">Home</a>
                <a class="nav-item nav-link" href="../../view//public/cozinha.php">Cozinha</a>
                <a class="nav-item nav-link" href="./view/public/cama.php">Cama, Mesa e Banho</a>
                <a class="nav-item nav-link" href="./view/public/ferramentas.php">Ferramentas</a>
                <a class="nav-item nav-link" href="./view/public/games.php">Games</a>
                <a class="nav-item nav-link" href="./view/public/eletronicos.php">Eletrônicos</a>
            </div>
        </div>
        
        <div class="ml-auto d-flex align-items-center">
            <?php if (isset($_SESSION['userId'])) { ?>
                <span class="navbar-text mr-3">Bem-vindo, <?php echo htmlspecialchars($userName); ?>!</span>
            <?php } ?>
            <a class="btn btn-outline-primary mr-2" href="view/cadastrarCliente.php">Cadastre-se</a>
            <a class="btn btn-outline-secondary mr-2" href="view/login.php">Entrar</a>
            <a class="btn btn-outline-primary" href="#"><i class="fas fa-shopping-cart"></i> Carrinho</a>
        </div>
    </div>
</nav>