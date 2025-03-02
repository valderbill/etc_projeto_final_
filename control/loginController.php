<?php
session_start();
require_once '../model/DTO/usuarioDTO.php';
require_once '../model/DAO/usuarioDAO.php';

if (!isset($_POST["emailUsu"])) {
    header("location:../view/login.php?msg=Acesso indevido!");
    exit;
}

$emailUsu = strip_tags($_POST["emailUsu"]);
$senhaUsu = MD5(strip_tags($_POST["senhaUsu"]));  // Senha encriptada com MD5

$usuarioDAO = new UsuarioDAO();     
$sucesso = $usuarioDAO->validarLogin($emailUsu, $senhaUsu);

if ($sucesso === false) {
    var_dump("Login failed: ", $emailUsu, $senhaUsu);
    exit;
}

if ($sucesso) {
    $_SESSION["idUsu"] = $sucesso["idUsu"];
    $_SESSION["nomeUsu"] = $sucesso["nomeUsu"];
    $_SESSION["emailUsu"] = $sucesso["emailUsu"];
    $_SESSION["situacaoUsu"] = $sucesso["situacaoUsu"];
    $_SESSION["perfilUsu"] = $sucesso["perfilUsu"];

    switch ($_SESSION["perfilUsu"]) {
        case 'Cliente':
            header("Location: http://localhost/projeto_final_dezembro/view/public/cozinha.php");
            break;
        case 'Vendedor':
            header("Location: http://localhost/projeto_final_dezembro/view/vendedor/vendedor.php");
            break;
        case 'Administrador':
            header("Location: http://localhost/projeto_final_dezembro/adm.php");
            break;
        default:
            header("Location: ../view/login.php?msg=Perfil não reconhecido.");
            exit;
    }
} else {
    $msg = "Usuário ou senha inválidos!";
    header("Location: ../view/login.php?msg=" . urlencode($msg)); 
    exit;
}
?>
