<?php
class Product{
 
    private $conn;
    private $table1_name = "products";
    private $table2_name = "product_items";
    
    public $productitemid;
    public $productitemname;
    public $visibility; //userid
    public $image_url;
    public $code; //joborderdetails.code
    public $created, $modified, $isDeleted;
    public $jodid; //joborderdetails_id

    public function __construct($db){
        $this->conn = $db;
    }
    
    function setProduct(){
        $this->created  = date('Y-m-d H:i:s');
        $this->modified = date('Y-m-d H:i:s');
        
        $query = "INSERT INTO " . $this->table1_name . "
            SET 
                name = :name,
                code = :code,
                image_url  = :image_url,
                created    = :created,
                modified   = :modified,
                visibility = :visibility,
                productid  = :productid,
                jodid      = :jodid";

        $stmt = $this->conn->prepare($query);

        $this->productitemname  = htmlspecialchars(strip_tags($this->productitemname));
        $this->image_url        = htmlspecialchars(strip_tags($this->image_url)); 
        $this->code       = htmlspecialchars(strip_tags($this->code));    
        $this->created    = htmlspecialchars(strip_tags($this->created));
        $this->modified   = htmlspecialchars(strip_tags($this->modified));
        $this->visibility = htmlspecialchars(strip_tags($this->visibility));     
        $this->productid  = htmlspecialchars(strip_tags($this->productid));
        $this->jodid      = htmlspecialchars(strip_tags($this->jodid));


        $stmt->bindParam(':name',       $this->productitemname);        
        $stmt->bindParam(':image_url',  $this->image_url);
        //$stmt->bindParam(':note',       $this->note);
        $stmt->bindParam(':created',    $this->created);
        $stmt->bindParam(':modified',   $this->modified);
        $stmt->bindParam(':visibility', $this->visibility);
        $stmt->bindParam(':productid',  $this->productid);
        $stmt->bindParam(':jodid',      $this->jodid);

        if($stmt->execute()){
            return true;
        }
        else{
            $this->showError($stmt);
            return false;
        }
    }

    function setProductItem(){
        $this->created  = date('Y-m-d H:i:s');
        $this->modified = date('Y-m-d H:i:s');
        
        $query = "INSERT INTO " . $this->table2_name . "
            SET 
                name = :name,
                image_url  = :image_url,
                created    = :created,
                modified   = :modified,
                visibility = :visibility,
                productid  = :productid,
                jodid      = :jodid";

        $stmt = $this->conn->prepare($query);

        $this->productitemname  = htmlspecialchars(strip_tags($this->productitemname));
        $this->image_url        = htmlspecialchars(strip_tags($this->image_url));     
        $this->created    = htmlspecialchars(strip_tags($this->created));
        $this->modified   = htmlspecialchars(strip_tags($this->modified));
        $this->visibility = htmlspecialchars(strip_tags($this->visibility));     
        $this->productid  = htmlspecialchars(strip_tags($this->productid));
        $this->jodid      = htmlspecialchars(strip_tags($this->jodid));

        $stmt->bindParam(':name',       $this->productitemname);        
        $stmt->bindParam(':image_url',  $this->image_url);
        //$stmt->bindParam(':note',       $this->note);
        $stmt->bindParam(':created',    $this->created);
        $stmt->bindParam(':modified',   $this->modified);
        $stmt->bindParam(':visibility', $this->visibility);
        $stmt->bindParam(':productid',  $this->productid);
        $stmt->bindParam(':jodid',      $this->jodid);

        if($stmt->execute()){
            return true;
        }
        else{
            $this->showError($stmt);
            return false;
        }
    }

    function readItems(){
        $query = "SELECT 
                product_items.`name`,
                product_items.`image_url`,
                product_items.`modified`,
                product_items.`productid` FROM product_items
                JOIN job_order_details ON product_items.jodid = job_order_details.id
                WHERE product_items.isDeleted <> 'Y'";

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