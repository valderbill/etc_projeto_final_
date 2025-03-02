<?php
session_start();
require_once 'model/DAO/Conexao.php'; 

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="./view/estilo.css" rel="stylesheet"> 
    <title>Página de Índices</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./view/public/cozinha.php">Cozinha</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./view/public/cama.php">Cama, Mesa e Banho</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./view/public/ferramentas.php">Ferramentas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./view/public/games.php">Games</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./view/public/eletronicos.php">Eletrônicos</a>
                </li>
            </ul>

            <div class="d-flex align-items-center ml-auto">              
                <?php if (isset($_SESSION['userId'])) { ?>
                    <span class="navbar-text mr-3">Bem-vindo, <?php echo htmlspecialchars($userName); ?>!</span>
                <?php } ?>

                <a class="btn btn-outline-primary mr-2" href="view/mostraCarrinho.php">
                    <i class="bi bi-cart"></i> Carrinho
                </a>
                
                <?php if (!isset($_SESSION['userId'])) { ?>
                    <a class="btn btn-outline-primary mr-2" href="view/cadastrarCliente.php">Cadastre-se</a>
                    <a class="btn btn-outline-secondary mr-2" href="view/login.php">Entrar</a>
                <?php } else { ?>
                    <a class="btn btn-outline-secondary mr-2" href="view/logOff.php">Sair</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>

<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./img/cozinha/carrossel.jpg" class="d-block w-100" alt="Imagem 1">
    </div>
    <div class="carousel-item">
      <img src="./img/cozinha/carrossel4.jpg" class="d-block w-100" alt="Imagem 2">
    </div>
    <div class="carousel-item">
      <img src="./img/cozinha/carrossel2.jpg" class="d-block w-100" alt="Imagem 3">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Próximo</span>
  </button>
</div>

<footer class="bg-light text-center py-3">
    <p>Site Conclusão de Curso Escola Técnica de Ceilândia</p>
    <p>AUZENIR MARLENE GOUVEIA DA SILVA, RAYLSON SILVA ROCHA</p>
    <p>HELTON FONSECA COSTA, VALDELI DE JESUS SILVA</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
