<?php

require_once '../model/DAO/Conexao.php'; 

try {
    $conexao = Conexao::getInstance(); 
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Cadastrar Cliente</h1>

    <form action="../control/cadastrarUsuarioController.php" method="post" onsubmit="return validarSenha()">
        <div class="form-group">
            <label for="nomeUsu">Nome:</label>
            <input type="text" class="form-control" id="nomeUsu" name="nomeUsu" required>
        </div>
        <div class="form-group">
            <label for="cpfUsu">CPF:</label>
            <input type="text" class="form-control" id="cpfUsu" name="cpfUsu" required maxlength="14" placeholder="000.000.000-00">
        </div>
        <div class="form-group">
            <label for="dtNascimentoUsu">Data de Nascimento:</label>
            <input type="date" class="form-control" id="dtNascimentoUsu" name="dtNascimentoUsu" required>
        </div>
        <div class="form-group">
            <label for="telefoneWhatsApp">Telefone (WhatsApp):</label>
            <input type="text" class="form-control" id="telefoneWhatsApp" name="telefoneWhatsApp" required placeholder="(00) 00000-0000">
        </div>
        <div class="form-group">
            <label for="emailUsu">E-mail:</label>
            <input type="email" class="form-control" id="emailUsu" name="emailUsu" required>
        </div>
        <div class="form-group">
            <label for="senhaUsu">Senha:</label>
            <input type="password" class="form-control" id="senhaUsu" name="senhaUsu" required minlength="6" placeholder="Mínimo de 6 caracteres">
            <small id="passwordHelpBlock" class="form-text text-muted">
                A senha deve ter pelo menos 6 caracteres, incluindo letra maiúscula, minúscula e um caractere especial.
            </small>
        </div>

        <div class="form-group">
            <label for="cep">CEP:</label>
            <input type="text" class="form-control" id="cep" name="cep" required placeholder="00000-000" onblur="buscarCEP()">
        </div>
        <div class="form-group">
            <label for="logradouro">Logradouro:</label>
            <input type="text" class="form-control" id="logradouro" name="logradouro" required>
        </div>
        <div class="form-group">
            <label for="numero">Número:</label>
            <input type="number" class="form-control" id="numero" name="numero" required>
        </div>
        <div class="form-group">
            <label for="complemento">Complemento:</label>
            <input type="text" class="form-control" id="complemento" name="complemento">
        </div>
        <div class="form-group">
            <label for="bairro">Bairro:</label>
            <input type="text" class="form-control" id="bairro" name="bairro" required>
        </div>
        <div class="form-group">
            <label for="cidade">Cidade:</label>
            <input type="text" class="form-control" id="cidade" name="cidade" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <input type="text" class="form-control" id="estado" name="estado" required>
        </div>

        <input type="hidden" name="perfilUsu" value="Cliente">
        <input type="hidden" name="situacaoUsu" value="Ativo">

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js"></script>
<script>
    $(document).ready(function(){
        $('#cpfUsu').mask('000.000.000-00');
        $('#telefoneWhatsApp').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');
    });

    function buscarCEP() {
        const cep = $('#cep').val().replace(/\D/g, '');

        if (cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        $('#logradouro').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                    } else {
                        alert('CEP não encontrado.');
                    }
                })
                .catch(() => alert('Erro ao buscar o CEP.'));
        } else {
            alert('CEP inválido. Insira um CEP com 8 dígitos.');
        }
    }

    function validarSenha() {
        const senha = document.getElementById("senhaUsu").value;
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{6,}$/;

        if (!regex.test(senha)) {
            alert("A senha deve conter pelo menos 6 caracteres, incluindo uma letra maiúscula, uma letra minúscula e um caractere especial.");
            return false;
        }
        return true;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
