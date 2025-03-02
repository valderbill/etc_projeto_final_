<?php
require_once '../model/DAO/UsuarioDAO.php'; 

$usuarioDAO = new UsuarioDAO();
$todos = $usuarioDAO->listarUsuarios(); 

