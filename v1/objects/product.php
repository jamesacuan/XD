<?php
class Product{
 
    private $conn;
    private $table_name = "products";

    public function __construct($db){
        $this->conn = $db;
    }
    
    function readItems(){
        $query = "SELECT `type`, 
                        `code`,
                        `name`,
                        `note`,
                        `image_url`,
                        `status`, 
                        `modified`,
                        `productid` FROM `product_items`
                        WHERE isDeleted <> 'Y'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name  = $row['name'];
        $stmt->execute();
        return $stmt;
    }

    function getItemCount($type){
        $query = "SELECT max(id) AS total
                FROM product_items 
                WHERE product_items.type='{$type}'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();   
        $num = $stmt->rowCount();
    
        if($num>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->answer = $row['total'];
            return $this->answer;
        }
        return false;
    }
}