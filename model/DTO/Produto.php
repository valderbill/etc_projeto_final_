<?php
class Produto {
    private $idProd;
    private $nomeProd;
    private $precoProd;
    private $qtdProd;

    public function __construct($idProd, $nomeProd, $precoProd, $qtdProd) {
        $this->idProd = $idProd;
        $this->nomeProd = $nomeProd;
        $this->precoProd = $precoProd;
        $this->qtdProd = $qtdProd;
    }

    public function getIdProd() {
        return $this->idProd;
    }

    public function getNomeProd() {
        return $this->nomeProd;
    }

    public function getPrecoProd() {
        return $this->precoProd;
    }

    public function getQtdProd() {
        return $this->qtdProd;
    }
}
?>
