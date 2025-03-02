<?php
require_once '../model/DTO/UsuarioDTO.php';
require_once '../model/DAO/UsuarioDAO.php';

if (isset($_POST["nomeUsu"], $_POST["emailUsu"], $_POST["senhaUsu"])) {

    $nomeUsu = strip_tags($_POST["nomeUsu"]);    
    $dtNascimentoUsu = isset($_POST["dtNascimentoUsu"]) ? $_POST["dtNascimentoUsu"] : null;
    $cpfUsu = isset($_POST["cpfUsu"]) ? strip_tags($_POST["cpfUsu"]) : null;
    $telefoneWhatsApp = isset($_POST["telefoneWhatsApp"]) ? strip_tags($_POST["telefoneWhatsApp"]) : null;
    $emailUsu = strip_tags($_POST["emailUsu"]);
    $senhaUsu = MD5($_POST["senhaUsu"]); 

    $perfilUsu = isset($_POST["perfilUsu"]) ? strip_tags($_POST["perfilUsu"]) : null;
    $situacaoUsu = isset($_POST["situacaoUsu"]) ? strip_tags($_POST["situacaoUsu"]) : null;

    $cep = isset($_POST["cep"]) ? strip_tags($_POST["cep"]) : null;
    $logradouro = isset($_POST["logradouro"]) ? strip_tags($_POST["logradouro"]) : null;
    $bairro = isset($_POST["bairro"]) ? strip_tags($_POST["bairro"]) : null;
    $cidade = isset($_POST["cidade"]) ? strip_tags($_POST["cidade"]) : null;
    $estado = isset($_POST["estado"]) ? strip_tags($_POST["estado"]) : null;

    $usuarioDTO = new UsuarioDTO();
    $usuarioDTO->setNomeUsu($nomeUsu);
    $usuarioDTO->setCpfUsu($cpfUsu);
    $usuarioDTO->setDtNascimentoUsu($dtNascimentoUsu);
    $usuarioDTO->setTelefoneWhatsApp($telefoneWhatsApp);
    $usuarioDTO->setEmailUsu($emailUsu);
    $usuarioDTO->setSenhaUsu($senhaUsu);
    $usuarioDTO->setPerfilUsu($perfilUsu);
    $usuarioDTO->setSituacaoUsu($situacaoUsu);
    $usuarioDTO->setCep($cep);
    $usuarioDTO->setLogradouro($logradouro);
    $usuarioDTO->setBairro($bairro);
    $usuarioDTO->setCidade($cidade);
    $usuarioDTO->setEstado($estado);

    $usuarioDAO = new UsuarioDAO();
    $sucesso = $usuarioDAO->salvarUsuario($usuarioDTO);

    // Apenas retorna o status, sem redirecionamento ou mensagem
    if ($sucesso) {
        echo "success";  // Apenas retorna sucesso
    } else {
        echo "error";  // Caso haja erro
    }
} else {
    echo "error";  // Caso os dados obrigatórios não sejam preenchidos
}
?>
