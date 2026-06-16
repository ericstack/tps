<?php

class Dashboard
{

  public function __construct($db)
  {
    $this->database_connect = $db;
  }

  public function productCount()
  {
    $sql = "SELECT * FROM inventory";
    $stmt = $this->database_connect->query($sql);
    $count = $stmt->rowCount();
    return $count;
  }
  protected function purchaseCount()
  {

    // $sql = "SELECT * FROM products";
    // $stmt = $this->database_connect->query($sql);
    // $count = $stmt->rowCount();
    // $products = $stmt->fetchAll();
    // return ([
    //   'productCount' => $count,
    //   'productArray' =>$products
    // ]);
  }
  protected function orderCount()
  {

    // $sql = "SELECT * FROM products";
    // $stmt = $this->database_connect->query($sql);
    // $count = $stmt->rowCount();
    // $products = $stmt->fetchAll();
    // return ([
    //   'productCount' => $count,
    //   'productArray' =>$products
    // ]);
  }
  protected function deliveryCount()
  {

    // $sql = "SELECT * FROM products";
    // $stmt = $this->database_connect->query($sql);
    // $count = $stmt->rowCount();
    // $products = $stmt->fetchAll();
    // return ([
    //   'productCount' => $count,
    //   'productArray' =>$products
    // ]);
  }
  protected function taskCount()
  {

    // $sql = "SELECT * FROM products";
    // $stmt = $this->database_connect->query($sql);
    // $count = $stmt->rowCount();
    // $products = $stmt->fetchAll();
    // return ([
    //   'productCount' => $count,
    //   'productArray' =>$products
    // ]);
  }
}
