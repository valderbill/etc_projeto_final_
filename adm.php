<?php
session_start();

if (!isset($_SESSION['idUsu'])) {
    header('Location: login.php');
    exit();
}

$idUsu = $_SESSION['idUsu'];

try {
    require_once('C:/xampp/htdocs/projeto_final_dezembro/model/DAO/Conexao.php');
    $conn = Conexao::getInstance();

    $query = "SELECT nomeUsu FROM usuario WHERE idUsu = :idUsu";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idUsu', $idUsu, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $userName = $stmt->fetch(PDO::FETCH_ASSOC)['nomeUsu'];
    } else {
        $userName = "Usuário Desconhecido";
    }

    $estoqueQuery = "SELECT nomeProd, qtdProd FROM produto";
    $estoqueStmt = $conn->prepare($estoqueQuery);
    $estoqueStmt->execute();
    $estoqueData = $estoqueStmt->fetchAll(PDO::FETCH_ASSOC);

    $vendasQuery = "SELECT p.nomeProd, v.quantidadeVendida, v.dataVenda, 
                    (v.quantidadeVendida * p.precoProd) AS valorVenda
                    FROM vendas v
                    JOIN produto p ON v.idProd = p.idProd
                    ORDER BY v.dataVenda DESC"; 
    $vendasStmt = $conn->prepare($vendasQuery);
    $vendasStmt->execute();
    $vendasData = $vendasStmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $userName = "Erro ao recuperar dados do banco de dados.";
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
    <title>Página de Produtos - Administrador</title>
    <style>
      
        body {
            padding-bottom: 50px; 
        }
       
        h2 {
            margin-bottom: 30px; 
        }

        .container.mt-5 {
            margin-top: 40px; 
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="nav-links">           
            <a class="btn btn-secondary mr-4" href="http://localhost/projeto_final_dezembro/view/cadastrarAdmFunc.php">Cadastrar Vendedor</a>
            <a class="btn btn-primary mr-4" href="http://localhost/projeto_final_dezembro/view/cadastrarProduto.php">Cadastrar Produto</a>
            <a class="btn btn-info mr-4" href="http://localhost/projeto_final_dezembro/view/listarProduto.php">Listar Produto</a>
            <a class="btn btn-warning" href="http://localhost/projeto_final_dezembro/view/listarUsuarios.php">Listar Usuário</a>
        </div>

        <div class="user-info">
            <a class="btn btn-success mr-4" href="http://localhost/projeto_final_dezembro/view/alterarFuncionario.php?id=<?= $idUsu; ?>">
                <i class="bi bi-person-fill"></i> <?= htmlspecialchars($userName); ?>
            </a>
        </div>

        <div class="ml-auto">
            <a class="btn btn-outline-secondary" href="http://localhost/projeto_final_dezembro/index.php">Sair</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Controle de Estoque</h2>
    <canvas id="estoqueChart" width="400" height="150"></canvas>

    <h2>Relatório de Vendas</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade Vendida</th>
                <th>Valor Total da Venda</th>
                <th>Data da Venda</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendasData as $venda): ?>
                <tr>
                    <td><?= htmlspecialchars($venda['nomeProd']); ?></td>
                    <td><?= $venda['quantidadeVendida']; ?></td>
                    <td>R$ <?= number_format($venda['valorVenda'], 2, ',', '.'); ?></td>
                    <td><?= date('d/m/Y H:i:s', strtotime($venda['dataVenda'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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

</body>
</html>
