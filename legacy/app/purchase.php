<?php


class Purchase
{
    private $database_connect;
    public function __construct($db)
    {
        $this->database_connect = $db;
    }

    public function display_purchase()
    {
        $sql = "SELECT * FROM purchase";
        $stmt = $this->database_connect->prepare($sql);
        $stmt->execute();
        return  $stmt;
    }

    public function fill_product_list()
    {
        $query = "
        SELECT * FROM inventory 
        ";
        $statement = $this->database_connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output = array();
        foreach ($result as $row) {
            $output = [
                "row_id" => $row["id"],
                "row_name" => $row["name"]
            ];
        }
        return $result;
    }
}
