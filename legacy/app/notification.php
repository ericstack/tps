<?php
include  'database.php';
class Notification extends Database
{
    // private $database_connect;
    public $notification = array();
    // public function __construct($db)
    // {
    //     $this->database_connect = $db;
    // }

    public function stock_notification()
    {
        // $sql = "SELECT * FROM inventory WHERE quantity = 0";
        // $stmt = $this->database_connect()->query($sql);
        // $stmt->execute();
        // $inventoryCount = $stmt->rowCount();
        // $notification = ([
        //     "inventory" => $products->name . " has low" . $products->quantity
        // ]);
        // return $notification;
    }
}
