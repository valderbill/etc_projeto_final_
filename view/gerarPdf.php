<?php

require '../vendor/autoload.php';  

use Dompdf\Dompdf;

$dompdf = new Dompdf();

require_once '../control/listarUsuariosController.php'; 

$html = '
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Usuários</h1>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
            </tr>
        </thead>
        <tbody>';
        
foreach ($todos as $t) {
    $html .= '
            <tr>
                <td>' . htmlspecialchars($t['nomeUsu']) . '</td>
                <td>' . htmlspecialchars($t['emailUsu']) . '</td>
                <td>' . htmlspecialchars($t['perfilUsu']) . '</td>
            </tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');  
$dompdf->render();
$dompdf->stream("usuarios.pdf", ["Attachment" => false]);  
