<?php
session_start();
require_once '../model/DAO/UsuarioDAO.php';
require_once '../model/DTO/UsuarioDTO.php';
date_default_timezone_set('America/Bahia');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailUsu = $_POST['emailUsu'];

    if (!filter_var($emailUsu, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido.";
    } else {
      
        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->pesquisarUsuarioPorEmail($emailUsu);

        if ($usuario) {
           
            $codigoValidacao = rand(100000, 999999);

            $_SESSION['codigoValidacao'] = $codigoValidacao;
            $_SESSION['emailUsu'] = $emailUsu;

            $dataExpiracao = date('Y-m-d H:i:s', strtotime("+5 minutes"));
            $_SESSION['expiracao'] = $dataExpiracao;

            $usuarioDAO->saveCodigoExpiracao($usuario['idUsu'], $codigoValidacao, $dataExpiracao);

            header('Location: validar_codigo.php');
        } else {
            $erro = "E-mail não encontrado.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Código de Validação</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Digite o E-mail cadastrado</h2>
    <form method="POST">
        <div class="form-group">
            <label for="emailUsu">E-mail</label>
            <input type="email" class="form-control" id="emailUsu" name="emailUsu" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Enviar Código</button>
    </form>
    <div class="mt-3 text-center">
        <?php if (isset($erro)): ?>
            <p class="text-danger"><?php echo $erro; ?></p>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
