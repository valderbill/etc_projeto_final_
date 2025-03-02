-- Criação do banco de dados
CREATE DATABASE projeto_final_dezembro;
USE projeto_final_dezembro;

-- tabela usuario
CREATE TABLE usuario (
    idUsu INT(11) NOT NULL AUTO_INCREMENT,
    nomeUsu VARCHAR(150) COLLATE utf8mb4_general_ci NOT NULL,
    cpfUsu VARCHAR(14) COLLATE utf8mb4_general_ci DEFAULT NULL,
    dtNascimentoUsu DATE DEFAULT NULL,
    telefoneWhatsApp VARCHAR(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
    emailUsu VARCHAR(150) COLLATE utf8mb4_general_ci NOT NULL,
    senhaUsu VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
    perfilUsu VARCHAR(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
    situacaoUsu VARCHAR(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
    cep VARCHAR(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
    logradouro VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    bairro VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    cidade VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    estado VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    PRIMARY KEY (idUsu)
);

-- tabela produto
CREATE TABLE produto (
    idProd INT(11) NOT NULL AUTO_INCREMENT,
    nomeProd VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    precoProd FLOAT DEFAULT NULL,
    qtdProd INT(11) DEFAULT NULL,
    imagem VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    categoriaProd VARCHAR(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    PRIMARY KEY (idProd)
);

-- tabela carrinho
CREATE TABLE carrinho (
    idCarrinho INT(11) AUTO_INCREMENT PRIMARY KEY,
    idUsu INT(11) NOT NULL,   
    idProd INT(11) NOT NULL,     
    qtdProd INT(11) NOT NULL,     
    FOREIGN KEY (idUsu) REFERENCES usuario(idUsu), 
    FOREIGN KEY (idProd) REFERENCES produtos(idProd)  
);

CREATE TABLE carrinho (
    idCarrinho INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUsu INT(11) DEFAULT NULL,
    idProd INT(11) DEFAULT NULL,
    quantidade INT(11) NOT NULL DEFAULT 1,
    nomeProd VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    precoProd FLOAT DEFAULT NULL,
    imagem VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    categoriaProd VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    FOREIGN KEY (idUsu) REFERENCES usuario(idUsu),
    FOREIGN KEY (idProd) REFERENCES produto(idProd)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


