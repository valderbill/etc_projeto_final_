<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Entrar no Sistema</title>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Entrar no Sistema</h2>
    <form action="../control/loginController.php" method="POST">
        <div class="form-group">
            <label for="emailUsu">E-mail</label>
            <input type="email" class="form-control" id="emailUsu" name="emailUsu" required>
        </div>
        <div class="form-group">
            <label for="senhaUsu">Senha</label>
            <input type="password" class="form-control" id="senhaUsu" name="senhaUsu" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
    </form>

    <div class="mt-3 text-center">
        <?php if (isset($_SESSION['msg'])): ?>
            <p class="text-danger"><?php echo $_SESSION['msg']; ?></p>
            <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>
    </div>

    <div class="mt-3 text-center">
        <p>Não tem cadastro? <a href="http://localhost/projeto_final_dezembro/view/cadastrarCliente.php">Cadastre-se aqui</a></p>
    </div>

    <div class="mt-3 text-center">
        <p><a href="http://localhost/projeto_final_dezembro/senha/enviar_codigo.php">Esqueci a senha</a></p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
