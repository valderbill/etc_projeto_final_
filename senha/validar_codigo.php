<?php
session_start();

if (!isset($_SESSION['codigoValidacao'])) {
    header('Location: enviar_codigo.php');
    exit();
}

$codigoValidacao = $_SESSION['codigoValidacao'];
$expiracao = $_SESSION['expiracao'];

date_default_timezone_set('America/Bahia');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Validação</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Código de Validação</h2>
    <div class="text-center">
        <p>O código gerado para redefinir sua senha é:</p>
        <h3><?php echo $codigoValidacao; ?></h3>
        <p>Este código expira em 5 minutos -> <?php echo $expiracao; ?></p>
    </div>

    <div class="text-center mt-3">
        <a href="redefinir_senha.php" class="btn btn-primary">Redefinir Senha</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
