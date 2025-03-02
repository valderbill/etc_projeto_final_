<?php

require_once 'Conexao.php';

try {
   
    $conexao = Conexao::getInstance();
    echo "Conexão realizada com sucesso!";
} catch (PDOException $exc) {
    echo "Erro ao conectar ao banco: " . $exc->getMessage();
}
?>
