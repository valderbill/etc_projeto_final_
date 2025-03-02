<?php
include_once "../model/DAO/UsuarioDAO.php";
include_once "../model/DTO/UsuarioDTO.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $idUsu = $_POST['idUsu'];  // Garantir que o 'idUsu' é enviado via POST
    $nomeUsu = $_POST['nomeUsu'];
    $emailUsu = $_POST['emailUsu'];
    $senhaUsu = $_POST['senhaUsu'] ?? null;
    $perfilUsu = $_POST['perfilUsu'] ?? null;
    $cpfUsu = $_POST['cpfUsu'] ?? null;
    $cep = $_POST['cep'] ?? null;
    $logradouro = $_POST['logradouro'] ?? null;
    $bairro = $_POST['bairro'] ?? null;
    $cidade = $_POST['cidade'] ?? null;
    $estado = $_POST['estado'] ?? null;
    $telefoneWhatsApp = $_POST['telefoneWhatsApp'] ?? null;
    $dtNascimentoUsu = $_POST['dtNascimentoUsu'] ?? null;

    // Criando o objeto UsuarioDTO e atribuindo os valores
    $usuarioDTO = new UsuarioDTO();
    $usuarioDTO->setIdUsu($idUsu);
    $usuarioDTO->setNomeUsu($nomeUsu);
    $usuarioDTO->setEmailUsu($emailUsu);

    // Caso a senha tenha sido preenchida, criptografamos e atribuimos
    if (!empty($senhaUsu)) {
        $senhaCriptografada = md5($senhaUsu);
        $usuarioDTO->setSenhaUsu($senhaCriptografada);
    } else {
        // Buscando o usuário atual para manter a senha se não houver alteração
        $usuarioDAO = new UsuarioDAO();
        $usuarioAtual = $usuarioDAO->pesquisarUsuarioPorId($idUsu);  // Corrigido para usar o DAO
        if ($usuarioAtual) {
            $usuarioDTO->setSenhaUsu($usuarioAtual['senhaUsu']);
        }
    }

    // Atribuindo os outros campos
    $usuarioDTO->setPerfilUsu($perfilUsu);
    $usuarioDTO->setCpfUsu($cpfUsu);
    $usuarioDTO->setCep($cep);
    $usuarioDTO->setLogradouro($logradouro);
    $usuarioDTO->setBairro($bairro);
    $usuarioDTO->setCidade($cidade);
    $usuarioDTO->setEstado($estado);
    $usuarioDTO->setTelefoneWhatsApp($telefoneWhatsApp);
    $usuarioDTO->setDtNascimentoUsu($dtNascimentoUsu);

    // Realizando a alteração do usuário
    $usuarioDAO = new UsuarioDAO();
    try {
        $resultado = $usuarioDAO->alterarUsuario($usuarioDTO);

        if ($resultado) {
            header("Location: ../view/listarUsuarios.php?status=success");
            exit;
        } else {
            echo "Erro ao alterar o usuário. Por favor, tente novamente.";
        }
    } catch (Exception $e) {
        echo "Erro ao alterar o usuário: " . $e->getMessage();
    }
} else {
    echo "Método inválido.";
}
?>
