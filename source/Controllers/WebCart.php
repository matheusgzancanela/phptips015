<?php

namespace Source\controllers;

use Source\Controllers\Controller;
use Source\Facades\Cart;
use Source\Models\Product;

class WebCart extends Controller
{
  /** @var Cart */
  private $cart;

  public function __construct($router)
  {
    parent::__construct($router);
    $this->cart = new Cart();
  }

  public function cart(array $data): void
  {
    echo json_encode($this->cart->cart());
  }

  public function add(array $data): void
  {
    $id = filter_var($data["id"], FILTER_VALIDATE_INT);
    $product = (new Product())->findById($id);
    if (!$id || !$product) {
      echo $this->ajaxMessage("Erro ao adicionar produto", "error");
      return;
    }

    $this->cart->add($product);
    echo json_encode($this->cart->cart());
  }

  public function remove(array $data): void
  {
    $id = filter_var($data["id"], FILTER_VALIDATE_INT);
    $product = (new Product())->findById($id);
    if (!$id || !$product) {
      echo $this->ajaxMessage("Erro ao remover produto", "error");
      return;
    }

    $this->cart->remove($product);
    echo json_encode($this->cart->cart());
  }

  public function clear()
  {
    $this->cart->clear();
    echo json_encode($this->cart->cart());
  }
}
