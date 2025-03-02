<?php
session_start();
require_once '../../model/DAO/ProdutoDAO.php'; 

$produtoDAO = new ProdutoDAO();
$produtos = $produtoDAO->getProdutosByCategoria('eletronicos'); 

if (isset($_SESSION['idUsu'])) {
    $idUsu = $_SESSION['idUsu'];  

    try {
        require_once('C:/xampp/htdocs/projeto_final_dezembro/model/DAO/Conexao.php');  
        $conn = Conexao::getInstance();  // conexão com o banco de dados

        $query = "SELECT nomeUsu FROM usuario WHERE idUsu = :idUsu";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idUsu', $idUsu, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $userName = $stmt->fetch(PDO::FETCH_ASSOC)['nomeUsu'];
        } else {
            $userName = "Usuário Desconhecido";  
        }

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $produtoId) {
                $query = "SELECT idCarrinho FROM carrinho WHERE idUsu = :idUsu AND idProd = :idProd";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':idUsu', $idUsu, PDO::PARAM_INT);
                $stmt->bindParam(':idProd', $produtoId, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $query = "UPDATE carrinho SET quantidade = quantidade + 1 WHERE idUsu = :idUsu AND idProd = :idProd";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':idUsu', $idUsu, PDO::PARAM_INT);
                    $stmt->bindParam(':idProd', $produtoId, PDO::PARAM_INT);
                    $stmt->execute();
                } else {
                    $query = "INSERT INTO carrinho (idUsu, idProd, quantidade) VALUES (:idUsu, :idProd, 1)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':idUsu', $idUsu, PDO::PARAM_INT);
                    $stmt->bindParam(':idProd', $produtoId, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            unset($_SESSION['cart']);
        }

    } catch (PDOException $e) {
        $userName = "Erro na consulta ao banco de dados: " . $e->getMessage();
    }
} else {
    $userName = "Usuário";
}

if (isset($_GET['add_to_cart'])) {
    $produtoId = $_GET['add_to_cart'];
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    array_push($_SESSION['cart'], $produtoId);
    
    header('Location: eletronicos.php'); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eletronicos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">    
    <link href="../estilo.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cozinha.php">Cozinha</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cama.php">Cama, Mesa e Banho</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ferramentas.php">Ferramentas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="games.php">Games</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="eletronicos.php">Eletrônicos</a>
                </li>
            </ul>
            
            <div class="d-flex align-items-center ml-auto">
               <a class="btn btn-outline-primary mr-2" href="http://localhost/projeto_final_dezembro/view/mostraCarrinho.php">
                    <i class="bi bi-cart2"></i> Carrinho
                </a>
                <a class="btn btn-success ml-4" href="../../view/login.php?id=<?= $idUsu ?? ''; ?>">
                    <i class="bi bi-person-fill"></i> <?= htmlspecialchars($userName); ?>
                </a>       

                <?php if (isset($_SESSION['idUsu'])): ?>
                    <a class="btn btn-outline-secondary ml-2" href="http://localhost/projeto_final_dezembro/logOff.php">Sair</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5">    
    <div class="row justify-content-center">
        <?php if (count($produtos) > 0): ?>
            <?php foreach ($produtos as $produto): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="../img/eletronicos/<?php echo htmlspecialchars($produto['imagem']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produto['nomeProd']); ?>">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?php echo htmlspecialchars($produto['nomeProd']); ?></h5>
                            <div class="d-flex justify-content-center">
                                <a href="?add_to_cart=<?php echo $produto['idProd']; ?>" class="btn btn-primary">Adicionar no Carrinho</a>
                            </div>
                            <p class="preco">R$ <?php echo number_format($produto['precoProd'], 2, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Nenhum produto encontrado nesta categoria.</p>
        <?php endif; ?>
    </div>
</div>

<footer class="bg-light text-center py-3">
    <p>Site Conclusão de Curso Escola Técnica de Ceilândia</p>
    <p>AUZENIR MARLENE GOUVEIA DA SILVA, RAYLSON SILVA ROCHA</p>
    <p>HELTON FONSECA COSTA, VALDELI DE JESUS SILVA</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
