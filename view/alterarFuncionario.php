<?php

include_once "../model/DAO/UsuarioDAO.php";

// Verificando se o parâmetro 'idUsu' foi passado via URL
if (isset($_GET['idUsu'])) {
    $idUsu = $_GET['idUsu'];

    // Criando um objeto do DAO para interagir com o banco de dados
    $usuarioDAO = new UsuarioDAO();

    // Buscando os dados do usuário pelo ID
    $funcionario = $usuarioDAO->pesquisarUsuarioPorId($idUsu);

    // Verificando se o funcionário foi encontrado
    if ($funcionario):
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Funcionário</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Funcionário</h1>
        
        <!-- Formulário para editar os dados do funcionário -->
        <form action="../control/alterarUsuarioController.php" method="POST">
          
            <!-- Campo oculto para passar o ID do usuário -->
            <input type="hidden" name="idUsu" value="<?= htmlspecialchars($funcionario['idUsu']) ?>">

            <div class="mb-3">
                <label for="nomeUsu" class="form-label">Nome:</label>
                <input type="text" id="nomeUsu" name="nomeUsu" class="form-control" value="<?= htmlspecialchars($funcionario['nomeUsu']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="emailUsu" class="form-label">Email:</label>
                <input type="email" id="emailUsu" name="emailUsu" class="form-control" value="<?= htmlspecialchars($funcionario['emailUsu']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="senhaUsu" class="form-label">Senha:</label>
                <input type="password" id="senhaUsu" name="senhaUsu" class="form-control" placeholder="Digite sua Senha ou Nova Senha">
            </div>

            <div class="mb-3">
                <label for="perfilUsu" class="form-label">Perfil:</label>
                <select id="perfilUsu" name="perfilUsu" class="form-select" required>
                    <option value="Administrador" <?= $funcionario['perfilUsu'] === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                    <option value="Vendedor" <?= $funcionario['perfilUsu'] === 'Vendedor' ? 'selected' : '' ?>>Vendedor</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="situacaoUsu" class="form-label">Situação:</label>
                <select id="situacaoUsu" name="situacaoUsu" class="form-select" required>
                    <option value="Ativo" <?= $funcionario['situacaoUsu'] === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                    <option value="Inativo" <?= $funcionario['situacaoUsu'] === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php else: ?>   
    <div class="alert alert-danger" role="alert">
        Funcionário não encontrado.
    </div>
<?php endif; ?>

<?php
} else {
    // Caso o parâmetro 'idUsu' não tenha sido passado
    echo "ID do funcionário não fornecido.";
}
?>
