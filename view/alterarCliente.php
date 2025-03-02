<?php
include_once "../model/DAO/UsuarioDAO.php";

if (isset($_GET['idUsu'])) {
    $idUsu = $_GET['idUsu'];
    $usuarioDAO = new UsuarioDAO();
    $cliente = $usuarioDAO->pesquisarUsuarioPorId($idUsu);

    if ($cliente):
?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h2>Editar Dados do Usuário</h2>

    <form action="../control/alterarUsuarioController.php" method="POST">
        <input type="hidden" name="idUsu" value="<?= $cliente['idUsu'] ?>">
        
        <input type="hidden" name="perfilUsu" value="<?= htmlspecialchars($cliente['perfilUsu']); ?>">

        <div class="form-group">
            <label for="nomeUsu">Nome:</label>
            <input type="text" class="form-control" id="nomeUsu" name="nomeUsu" value="<?= htmlspecialchars($cliente['nomeUsu']); ?>" required>
        </div>

        <div class="form-group">
            <label for="emailUsu">Email:</label>
            <input type="email" class="form-control" id="emailUsu" name="emailUsu" value="<?= htmlspecialchars($cliente['emailUsu']); ?>" required>
        </div>

        <div class="form-group">
            <label for="senhaUsu">Senha:</label>
            <input type="password" class="form-control" id="senhaUsu" name="senhaUsu">
        </div>

        <div class="form-group">
            <label for="cpfUsu">CPF:</label>
            <input type="text" class="form-control" id="cpfUsu" name="cpfUsu" value="<?= htmlspecialchars($cliente['cpfUsu']); ?>" required>
        </div>

        <div class="form-group">
            <label for="cep">CEP:</label>
            <input type="text" class="form-control" id="cep" name="cep" value="<?= htmlspecialchars($cliente['cep']); ?>" required>
        </div>

        <div class="form-group">
            <label for="logradouro">Logradouro:</label>
            <input type="text" class="form-control" id="logradouro" name="logradouro" value="<?= htmlspecialchars($cliente['logradouro']); ?>" required>
        </div>

        <div class="form-group">
            <label for="bairro">Bairro:</label>
            <input type="text" class="form-control" id="bairro" name="bairro" value="<?= htmlspecialchars($cliente['bairro']); ?>" required>
        </div>

        <div class="form-group">
            <label for="cidade">Cidade:</label>
            <input type="text" class="form-control" id="cidade" name="cidade" value="<?= htmlspecialchars($cliente['cidade']); ?>" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado:</label>
            <input type="text" class="form-control" id="estado" name="estado" value="<?= htmlspecialchars($cliente['estado']); ?>" required>
        </div>

        <div class="form-group">
            <label for="telefoneWhatsApp">Telefone WhatsApp:</label>
            <input type="text" class="form-control" id="telefoneWhatsApp" name="telefoneWhatsApp" value="<?= htmlspecialchars($cliente['telefoneWhatsApp']); ?>" required>
        </div>

        <div class="form-group">
            <label for="dtNascimento">Data de Nascimento:</label>
            <input type="date" class="form-control" id="dtNascimento" name="dtNascimento" value="<?= htmlspecialchars($cliente['dtNascimentoUsu']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function(){
        $('#cpfUsu').mask('000.000.000-00');
        $('#telefoneWhatsApp').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');

        $('#cep').on('blur', function() {
            var cep = $(this).val().replace('-', '');
            if (cep.length == 8) {
                $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
                    if (!data.erro) {
                        $('#logradouro').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                    } else {
                        alert('CEP não encontrado.');
                    }
                });
            }
        });
    });
</script>

<?php else: ?>
    <div class="container mt-4">
        <p class="alert alert-warning">Cliente não encontrado.</p>
    </div>
<?php endif; } else { echo "ID do cliente não fornecido."; } ?>
