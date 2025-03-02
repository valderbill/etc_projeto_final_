<?php
session_start(); 

if (isset($_SESSION['idUsu'])) {
    $idUsu = $_SESSION['idUsu'];  

    try {
        include('../../model/DAO/Conexao.php');  

        // Estabelece a conexão com o banco de dados
        $conn = Conexao::getInstance();

        // Recupera o nome do usuário
        $query = "SELECT nomeUsu FROM usuario WHERE idUsu = :idUsu";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idUsu', $idUsu, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $userName = $stmt->fetch(PDO::FETCH_ASSOC)['nomeUsu'];
        } else {
            $userName = "Usuário Desconhecido";  
        }

        // Consulta o estoque dos produtos
        $estoqueQuery = "SELECT nomeProd, qtdProd FROM produto";
        $estoqueStmt = $conn->prepare($estoqueQuery);
        $estoqueStmt->execute();
        $estoqueData = $estoqueStmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $userName = "Erro na consulta ao banco de dados: " . $e->getMessage();
    }
} else {
    $userName = "Usuário não logado.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="http://localhost/projeto_final_dezembro/view/estoque.css" rel="stylesheet"> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Página de Vendedor</title>
    <style>
        .nav-links {
            flex-grow: 1;
            justify-content: center;
            display: flex;
        }

        #opcoesCadastro {
            margin-right: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
        }

        .user-info a {
            display: flex;
            align-items: center;
            color: inherit;
            text-decoration: none;
        }

        .user-info span {
            margin-left: 10px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">    
        <!-- Centralizando os botões de navegação -->
        <div class="nav-links">
            <a class="btn btn-primary mr-4" href="http://localhost/projeto_final_dezembro/view/cadastrarProduto.php">Cadastrar Produto</a>
            <a class="btn btn-info mr-4" href="http://localhost/projeto_final_dezembro/view/listarProduto.php">Listar Produto</a>
        </div>        
        <!-- Exibindo o nome do usuário -->
        <div class="ml-auto user-info">
            <a class="btn btn-success mr-4" href="editarUsuario.php?id=<?= $idUsu; ?>">
                <i class="bi bi-person-fill"></i>
                <span><?= htmlspecialchars($userName); ?></span>
            </a>
        </div>
        <!-- Botão de sair -->
        <div class="ml-auto">
            <a class="btn btn-outline-secondary" href="http://localhost/projeto_final_dezembro/index.php">Sair</a>
        </div>
    </div>
</nav>

<div class="container mt-5">  
    <h2>Controle de Estoque</h2>
    <canvas id="estoqueChart" width="400" height="150"></canvas>
</div>

<script>
    const estoqueData = <?php echo json_encode($estoqueData); ?>;
    const produtosEstoque = estoqueData.map(item => item.nomeProd);
    const quantidadeEstoque = estoqueData.map(item => item.qtdProd);

    function getEstoqueColor(quantidade) {
        if (quantidade > 100) return 'rgba(54, 162, 235, 0.5)'; 
        if (quantidade > 50) return 'rgba(255, 206, 86, 0.5)';  
        if (quantidade < 15) return 'rgba(255, 0, 0, 0.5)'; 
        return 'rgba(255, 159, 64, 0.5)'; 
    }

    const ctxEstoque = document.getElementById('estoqueChart').getContext('2d');
    const estoqueChart = new Chart(ctxEstoque, {
        type: 'bar', 
        data: {
            labels: produtosEstoque,
            datasets: [{
                label: 'Quantidade em Estoque',
                data: quantidadeEstoque,
                backgroundColor: quantidadeEstoque.map(getEstoqueColor),
                borderColor: quantidadeEstoque.map(q => getEstoqueColor(q)),
                borderWidth: 1,
                barThickness: 20, 
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: { 
                    beginAtZero: true,
                    ticks: {
                        padding: 5 
                    }
                },
                y: {
                    ticks: {
                        padding: 5 
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top', 
                    labels: {
                        generateLabels: function(chart) {
                            return [
                                {
                                    text: 'Acima de 100 ',
                                    fillStyle: 'rgba(54, 162, 235, 0.5)', 
                                    strokeStyle: 'rgba(54, 162, 235, 0.5)',
                                    lineWidth: 1
                                },
                                {
                                    text: 'Acima de 50 ',
                                    fillStyle: 'rgba(255, 206, 86, 0.5)', 
                                    strokeStyle: 'rgba(255, 206, 86, 0.5)',
                                    lineWidth: 1
                                },
                                {
                                    text: 'Abaixo de 15',
                                    fillStyle: 'rgba(255, 0, 0, 0.5)', 
                                    strokeStyle: 'rgba(255, 0, 0, 0.5)',
                                    lineWidth: 1
                                }
                            ];
                        }
                    }
                }
            },
            layout: {
                padding: {
                    left: 10,  
                    right: 10, 
                    top: 10,   
                    bottom: 10 
                }
            },
            
            elements: {
                bar: {
                    borderWidth: 1,
                    categoryPercentage: 0.8, 
                    barPercentage: 0.9,
                }
            }
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
