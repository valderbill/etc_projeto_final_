<?php

require_once '../model/DTO/UsuarioDTO.php';
require_once '../model/DAO/UsuarioDAO.php';

error_reporting(0);

// Verifica se a variável 'idUsu' foi passada na URL
if (isset($_GET['idUsu'])) {
    $idUsu = $_GET['idUsu'];

    $usuarioDAO = new UsuarioDAO();

    // Realiza a exclusão do usuário
    $sucesso = $usuarioDAO->excluirUsuario($idUsu);

    // Após a exclusão, redireciona de volta para a página de listagem de usuários
    header('Location: http://localhost/projeto_final_dezembro/view/listarUsuarios.php');
    exit(); // Garantir que o código não continue executando após o redirecionamento
}

?>
