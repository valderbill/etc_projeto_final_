<?php
class Carrinho {
    private $idCarrinho;
    private $idUsu;
    private $itensCarrinho = []; 

    public function __construct($idCarrinho, $idUsu) {
        $this->idCarrinho = $idCarrinho;
        $this->idUsu = $idUsu;
    }

    public function getIdCarrinho() {
        return $this->idCarrinho;
    }

    public function getIdUsu() {
        return $this->idUsu;
    }

    public function getItensCarrinho() {
        return $this->itensCarrinho;
    }

    public function setItensCarrinho($itens) {
        $this->itensCarrinho = $itens;
    }

    public function addItem(ItemCarrinho $item) {
        $this->itensCarrinho[] = $item;
    }
}
?>
