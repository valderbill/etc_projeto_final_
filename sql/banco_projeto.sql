CREATE DATABASE projeto_final_dezembro;
USE projeto_final_dezembro;

CREATE TABLE IF NOT EXISTS carrinho (
    idCarrinho INT(11) NOT NULL AUTO_INCREMENT,
    idUsu INT(11) DEFAULT NULL,
    idProd INT(11) DEFAULT NULL,
    quantidade INT(11) NOT NULL DEFAULT 1,
    nomeProd VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    precoProd FLOAT DEFAULT NULL,
    imagem VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    categoriaProd VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    PRIMARY KEY (idCarrinho),
    INDEX (idUsu),
    INDEX (idProd)
);

-- Criação da tabela produto
CREATE TABLE IF NOT EXISTS produto (
    idProd INT(11) NOT NULL AUTO_INCREMENT,
    nomeProd VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    precoProd FLOAT DEFAULT NULL,
    qtdProd INT(11) DEFAULT NULL,
    imagem VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    categoriaProd VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    PRIMARY KEY (idProd)
);

-- Criação da tabela usuario
CREATE TABLE IF NOT EXISTS usuario (
    idUsu INT(11) NOT NULL AUTO_INCREMENT,
    nomeUsu VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    cpfUsu VARCHAR(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    dtNascimentoUsu DATE DEFAULT NULL,
    telefoneWhatsApp VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    emailUsu VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    senhaUsu VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    perfilUsu VARCHAR(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    situacaoUsu VARCHAR(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    cep VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    logradouro VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    bairro VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    cidade VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    estado VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    codigoValidacaoUsu VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    expiracaoCodigoUsu DATETIME DEFAULT NULL,
    PRIMARY KEY (idUsu)
);

-- Criação da tabela vendas
CREATE TABLE IF NOT EXISTS vendas (
    idVenda INT(11) NOT NULL AUTO_INCREMENT,
    idUsu INT(11) NOT NULL,
    idProd INT(11) NOT NULL,
    quantidadeVendida INT(11) NOT NULL,
    dataVenda DATETIME DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (idVenda),
    INDEX (idUsu),
    INDEX (idProd)
);