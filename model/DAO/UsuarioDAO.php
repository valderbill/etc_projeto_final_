<?php
include "Conexao.php";
require_once "../model/DTO/UsuarioDTO.php";

class UsuarioDAO
{
    private $pdo = null;

    public function __construct()
    {
        $this->pdo = Conexao::getInstance();
    }

    public function salvarUsuario(UsuarioDTO $usuarioDTO)
    {
        try {
            $sql = "INSERT INTO usuario (nomeUsu, cpfUsu, dtNascimentoUsu, telefoneWhatsApp, emailUsu, senhaUsu, perfilUsu, situacaoUsu, cep, logradouro, bairro, cidade, estado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(1, $usuarioDTO->getNomeUsu());
            $stmt->bindValue(2, $usuarioDTO->getCpfUsu());
            $stmt->bindValue(3, $usuarioDTO->getDtNascimentoUsu());
            $stmt->bindValue(4, $usuarioDTO->getTelefoneWhatsApp());
            $stmt->bindValue(5, $usuarioDTO->getEmailUsu());
            $stmt->bindValue(6, $usuarioDTO->getSenhaUsu());
            $stmt->bindValue(7, $usuarioDTO->getPerfilUsu());
            $stmt->bindValue(8, $usuarioDTO->getSituacaoUsu());
            $stmt->bindValue(9, $usuarioDTO->getCep());
            $stmt->bindValue(10, $usuarioDTO->getLogradouro());
            $stmt->bindValue(11, $usuarioDTO->getBairro());
            $stmt->bindValue(12, $usuarioDTO->getCidade());
            $stmt->bindValue(13, $usuarioDTO->getEstado());

            return $stmt->execute();
        } catch (PDOException $exc) {
            echo "Error saving user: " . $exc->getMessage();
            return false;
        }
    }

    public function listarUsuarios()
    {
        try {
            $sql = "SELECT idUsu, nomeUsu, dtNascimentoUsu, emailUsu, perfilUsu, situacaoUsu FROM usuario";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exc) {
            echo "Error listing users: " . $exc->getMessage();
            return [];
        }
    }

    public function listarUsuariosPorPerfil($perfil)
    {
        try {
            $sql = "SELECT idUsu, nomeUsu, emailUsu, situacaoUsu FROM usuario WHERE perfilUsu = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $perfil);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exc) {
            echo "Error listing users by profile: " . $exc->getMessage();
            return [];
        }
    }

    public function excluirUsuario($idUsuario)
    {
        try {
            $sql = "DELETE FROM usuario WHERE idUsu = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $idUsuario);
            return $stmt->execute();
        } catch (PDOException $exc) {
            echo "Error deleting user: " . $exc->getMessage();
            return false;
        }
    }

    public function alterarUsuario(UsuarioDTO $usuarioDTO)
    {
        try {
            $sql = $usuarioDTO->getPerfilUsu() === 'Cliente' ? 
                "UPDATE usuario SET 
                    nomeUsu = ?, cpfUsu = ?, dtNascimentoUsu = ?, telefoneWhatsApp = ?, 
                    emailUsu = ?, senhaUsu = ?, perfilUsu = ?, situacaoUsu = ?, 
                    cep = ?, logradouro = ?, bairro = ?, cidade = ?, estado = ? 
                WHERE idUsu = ?" : 
                "UPDATE usuario SET 
                    nomeUsu = ?, cpfUsu = ?, dtNascimentoUsu = ?, telefoneWhatsApp = ?, 
                    emailUsu = ?, senhaUsu = ?, perfilUsu = ?, situacaoUsu = ? 
                WHERE idUsu = ?";

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(1, $usuarioDTO->getNomeUsu());
            $stmt->bindValue(2, $usuarioDTO->getCpfUsu());
            $stmt->bindValue(3, $usuarioDTO->getDtNascimentoUsu());
            $stmt->bindValue(4, $usuarioDTO->getTelefoneWhatsApp());
            $stmt->bindValue(5, $usuarioDTO->getEmailUsu());
            $stmt->bindValue(6, $usuarioDTO->getSenhaUsu());
            $stmt->bindValue(7, $usuarioDTO->getPerfilUsu());
            $stmt->bindValue(8, $usuarioDTO->getSituacaoUsu());

            if ($usuarioDTO->getPerfilUsu() === 'Cliente') {
                $stmt->bindValue(9, $usuarioDTO->getCep());
                $stmt->bindValue(10, $usuarioDTO->getLogradouro());
                $stmt->bindValue(11, $usuarioDTO->getBairro());
                $stmt->bindValue(12, $usuarioDTO->getCidade());
                $stmt->bindValue(13, $usuarioDTO->getEstado());
                $stmt->bindValue(14, $usuarioDTO->getIdUsu());
            } else {
                $stmt->bindValue(9, $usuarioDTO->getIdUsu());
            }

            return $stmt->execute();
        } catch (PDOException $exc) {
            echo "Error updating user: " . $exc->getMessage();
            return false;
        }
    }

    public function pesquisarUsuarioPorId($idUsuario)
    {
        if (empty($idUsuario)) {
            echo "ID do usuário não fornecido.";
            return null;
        }

        try {
            $sql = "SELECT * FROM usuario WHERE idUsu = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $idUsuario);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                return $usuario;
            } else {
                echo "Usuário não encontrado.";
                return null;
            }
        } catch (PDOException $exc) {
            echo "Erro ao buscar usuário por ID: " . $exc->getMessage();
            return null;
        }
    }

    public function pesquisarUsuarioPorEmail($emailUsu)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE emailUsu = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $emailUsu);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exc) {
            echo "Erro ao buscar usuário por e-mail: " . $exc->getMessage();
            return null;
        }
    }

    public function validarLogin($emailUsu, $senhaUsu)
    {
        try {
            $sql = "SELECT idUsu, nomeUsu, emailUsu, situacaoUsu, perfilUsu FROM usuario WHERE emailUsu = ? AND senhaUsu = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $emailUsu);
            $stmt->bindValue(2, $senhaUsu);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exc) {
            echo "Erro ao validar login: " . $exc->getMessage();
            return null;
        }
    }

    public function saveCodigoExpiracao($idUsu, $codigoValidacao, $dataExpiracao)
    {
        try {
            $sql = "UPDATE usuario SET codigoValidacaoUsu = ?, expiracaoCodigoUsu = ? WHERE idUsu = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $codigoValidacao);
            $stmt->bindValue(2, $dataExpiracao);
            $stmt->bindValue(3, $idUsu);
            return $stmt->execute();
        } catch (PDOException $exc) {
            echo "Erro ao salvar código de expiração: " . $exc->getMessage();
            return false;
        }
    }

    public function validarCodigoDeValidacao($codigoValidacao)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE codigoValidacaoUsu = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $codigoValidacao);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exc) {
            echo "Erro ao validar código de validação: " . $exc->getMessage();
            return null;
        }
    }

    public function redefinirSenha($idUsuario, $newPassword)
    {
        try {
            $sql = "UPDATE usuario SET senhaUsu = ? WHERE idUsu = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $newPassword);
            $stmt->bindValue(2, $idUsuario);
            return $stmt->execute();
        } catch (PDOException $exc) {
            echo "Erro ao redefinir a senha: " . $exc->getMessage();
            return false;
        }
    }
}
?>
