<?php
class ItemCarrinho {
    private $produto;
    private $quantidade;

    public function __construct($produto, $quantidade) {
        $this->produto = $produto;
        $this->quantidade = $quantidade;
    }

    public function getProduto() {
        return $this->produto;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }
}
?>
