<?php
class ProdutoDTO {
    private $idProd;
    private $nomeProd;
    private $precoProd;
    private $qtdProd;
    private $categoriaProd;
    private $imagem;

    // Métodos para o idProd
    public function setIdProd($idProd) {
        $this->idProd = $idProd;
    }
    public function getIdProd() {
        return $this->idProd;
    }

    // Métodos para o nomeProd
    public function setNomeProd($nomeProd) {
        $this->nomeProd = $nomeProd;
    }
    public function getNomeProd() {
        return $this->nomeProd;
    }

    // Métodos para o precoProd
    public function setPrecoProd($precoProd) {
        $this->precoProd = $precoProd;
    }
    public function getPrecoProd() {
        return $this->precoProd;
    }

    // Métodos para o qtdProd
    public function setQtdProd($qtdProd) {
        $this->qtdProd = $qtdProd;
    }
    public function getQtdProd() {
        return $this->qtdProd;
    }

    // Métodos para o categoriaProd
    public function setCategoriaProd($categoriaProd) {
        $this->categoriaProd = $categoriaProd;
    }
    public function getCategoriaProd() {
        return $this->categoriaProd;
    }

    // Métodos para a imagem
    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }
    public function getImagem() {
        return $this->imagem;
    }
}
?>
