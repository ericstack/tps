<?php
include 'database.php';
class Inventory extends Database
{
    // private $database_connect;
    // public function __construct($db)
    // {
    //     $this->database_connect = $db;
    // }
    public function display_inventory($sql)
    {
        $stmt = $this->database_connect()->query($sql);
        $stmt->execute();
        return  $stmt;
    }


    public function add_to_inventory($value)
    {
        $sql = "INSERT INTO inventory (";
        $sql .= implode(",", array_keys($value)) . ') VALUES (';
        $sql .= "'" . implode("','", array_values($value)) . "')";
        $stmt = $this->database_connect()->prepare($sql);
        $stmt->execute();
        return  $stmt;
    }

    public function display_single_product($sql)
    {
        $stmt = $this->database_connect()->prepare($sql);
        $stmt->execute();
        return  $stmt;
    }

    public function update_inventory($value)
    {

        $stmt = $this->database_connect()->prepare(
            "UPDATE inventory 
            SET name = :name, description = :description, quantity = :quantity, category_id=:category_id  
            WHERE id = :id
            "
        );
        $stmt->execute(
            array(
                ":name" => $value['name'],
                ":description" => $value['description'],
                ":quantity" => $value['quantity'],
                ":category_id" => $value['category_id'],
                ":id" => $value['id'],
            )
        );
        return  $stmt;
    }
}
