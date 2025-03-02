<?php
session_start();
require_once '../model/DAO/UsuarioDAO.php';
date_default_timezone_set('America/Bahia');

if (!isset($_SESSION['codigoValidacao'])) {
    $_SESSION['msg'] = 'Código de validação inválido ou expirado.';
    header('Location: enviar_codigo.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaSenha = strip_tags($_POST['novaSenha']);

    $codigoValidacao = $_SESSION['codigoValidacao'];
    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->validarCodigoDeValidacao($codigoValidacao);

    if ($usuario) {
        $expiracao = $usuario['expiracaoCodigoUsu'];
        $dataAtual = date('Y-m-d H:i:s');

        if ($dataAtual > $expiracao) {
            $_SESSION['msg'] = 'Código expirado. Solicite um novo código.';
            header('Location: enviar_codigo.php');
            exit();
        }

        $senhaHash = md5($novaSenha);

        $idUsuario = $usuario['idUsu'];
        $senhaRedefinida = $usuarioDAO->redefinirSenha($idUsuario, $senhaHash);

        if ($senhaRedefinida) {
            unset($_SESSION['codigoValidacao']); 
            $_SESSION['msg'] = 'Senha redefinida com sucesso!';
            header('Location: http://localhost/projeto_final_dezembro/view/login.php'); 
            exit();
        } else {
            $_SESSION['msg'] = 'Erro ao redefinir a senha. Tente novamente.';
            header('Location: redefinir_senha.php');
            exit();
        }
    } else {
        $_SESSION['msg'] = 'Código inválido ou expirado.';
        header('Location: validar_codigo.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Redefinir Senha</h2>
    <form method="POST">
        <div class="form-group">
            <label for="novaSenha">Nova Senha</label>
            <input type="password" class="form-control" id="novaSenha" name="novaSenha" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Redefinir Senha</button>
    </form>

    <div class="mt-3 text-center">
        <?php if (isset($_SESSION['msg'])): ?>
            <p class="text-danger"><?php echo $_SESSION['msg']; ?></p>
        <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
