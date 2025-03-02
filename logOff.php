<?php
session_start();

$perfil = isset($_SESSION['perfilUsu']) ? $_SESSION['perfilUsu'] : null;

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

if ($perfil == 'Cliente') {
    header("Location: http://localhost/projeto_final_dezembro/index.php");
} elseif ($perfil == 'Vendedor') {
    header("Location: http://localhost/projeto_final_dezembro/view/vendedor/vendedor.php");
} elseif ($perfil == 'Administrador') {
    header("Location: http://localhost/projeto_final_dezembro/index.php");
} else {
    
    header("Location: http://localhost/projeto_final_dezembro/index.php");
}

exit();
?>
