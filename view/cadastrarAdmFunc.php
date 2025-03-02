<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Tela de Cadastro</title>
</head>
<body>
    <div class="container mt-5">      
        <a href="javascript:history.back()" class="btn btn-primary mb-3">Voltar</a>

        <h1 class="mb-4">Cadastrar Vendedor</h1>
        <form id="formCadastro" method="post" onsubmit="return enviarFormulario()">
            <div class="mb-3">
                <label for="nomeUsu" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nomeUsu" name="nomeUsu" required>
            </div>
            <div class="mb-3">
                <label for="emailUsu" class="form-label">E-mail:</label>
                <input type="email" class="form-control" id="emailUsu" name="emailUsu" required>
            </div>
            <div class="mb-3">
                <label for="senhaUsu" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senhaUsu" name="senhaUsu" required>
                <small id="senhaHelp" class="form-text text-muted">A senha deve ter pelo menos 6 caracteres, incluindo uma letra maiúscula, uma letra minúscula e um caractere especial.</small>
            </div>
            <div class="mb-3">
                <label for="perfilUsu" class="form-label">Perfil:</label>
                <select class="form-select" id="perfilUsu" name="perfilUsu" required>
                    <option value="Administrador">Administrador</option>
                    <option value="Vendedor">Vendedor</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="situacaoUsu" class="form-label">Situação:</label>
                <select class="form-select" id="situacaoUsu" name="situacaoUsu" required>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        
        <div id="message" class="mt-4" style="display:none;"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function validarSenha() {
            const senha = document.getElementById("senhaUsu").value;
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_\-+=<>?])[A-Za-z\d!@#$%^&*()_\-+=<>?]{6,}$/;

            if (!regex.test(senha)) {
                alert("A senha deve ter pelo menos 6 caracteres, incluindo uma letra maiúscula, uma letra minúscula e um caractere especial.");
                return false;
            }
            return true;
        }

        function enviarFormulario() {
            // Validar senha antes de enviar
            if (!validarSenha()) {
                return false;
            }

            // Criar o objeto FormData para enviar os dados do formulário
            var formData = new FormData(document.getElementById("formCadastro"));

            // Usar o Fetch API para enviar o formulário via AJAX
            fetch('../control/cadastrarUsuarioController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Aqui verificamos se o cadastro foi bem-sucedido
                if (data === "success") {
                    // Limpar o formulário
                    document.getElementById("formCadastro").reset();

                    // Mostrar uma mensagem de sucesso
                    const messageDiv = document.getElementById("message");
                    messageDiv.style.display = 'block';
                    messageDiv.className = 'alert alert-success';
                    messageDiv.innerHTML = 'Cadastro realizado com sucesso!';
                } else {
                    // Caso haja erro, podemos mostrar uma mensagem de erro
                    const messageDiv = document.getElementById("message");
                    messageDiv.style.display = 'block';
                    messageDiv.className = 'alert alert-danger';
                    messageDiv.innerHTML = 'Erro ao cadastrar. Tente novamente.';
                }
            })
            .catch(error => {
                // Caso ocorra algum erro na requisição, podemos adicionar tratamento de erro aqui
                const messageDiv = document.getElementById("message");
                messageDiv.style.display = 'block';
                messageDiv.className = 'alert alert-danger';
                messageDiv.innerHTML = 'Erro ao cadastrar. Tente novamente.';
            });

            // Previne o envio tradicional do formulário
            return false;
        }
    </script>
</body>
</html>
