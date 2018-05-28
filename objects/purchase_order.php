<?php
class PurchaseOrder{

    private $conn;
    private $table1_name = "purchase_order";
    private $table2_name = "purchase_order_details";
    private $table3_name = "purchase_order_status";

    public $userid;
    public $image_url;
    public $expectedJO;
    public $created, $modified, $isDeleted;
    public $productitemid;
    public $quantity;
    public $color;
    public $note;
    public $status;
    public $total;
    public $type;
    public $purchase_orderid;

    public $count;

    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
        $this->created  = date('Y-m-d H:i:s');
        $this->modified = date('Y-m-d H:i:s');

        $query = "INSERT INTO " . $this->table1_name . "
                SET 
                    userid   = :userid,
                    created  = :created,
                    modified = :modified";

        $stmt = $this->conn->prepare($query1);

        $this->userid     = htmlspecialchars(strip_tags($this->userid));     
        $this->created    = htmlspecialchars(strip_tags($this->created));
        $this->modified   = htmlspecialchars(strip_tags($this->modified));

        $stmt->bindParam(':userid', $this->userid);        
        $stmt->bindParam(':created', $this->created);
        $stmt->bindParam(':modified', $this->modified);

        if($stmt->execute()){
            return true;
        }
        else{
            $this->showError($stmt);
            return false;
        }
    }

    function addItem(){
        $this->created  = date('Y-m-d H:i:s');
        $this->modified = date('Y-m-d H:i:s');
        $query = "INSERT INTO " . $this->table2_name . "
            SET
                type       = :type,
                productitemid = :productitemid,
                quantity   = :quantity,
                color      = :color,
                note       = :note";

        $stmt = $this->conn->prepare($query);

        $this->productitemid = htmlspecialchars(strip_tags($this->productitemid));
        $this->quantity   = htmlspecialchars(strip_tags($this->quantity));
        $this->color      = htmlspecialchars(strip_tags($this->color));
        $this->note       = htmlspecialchars(strip_tags($this->note));  
        $this->type   = htmlspecialchars(strip_tags($this->type));

        $stmt->bindParam(':productitemid', $this->productitemid);        
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':note', $this->note);
        $stmt->bindParam(':color', $this->color);
        $stmt->bindParam(':type', $this->type);

        if($stmt->execute()){
            return true;
        }
        else{
            $this->showError($stmt);
            return false;
        }
    }

    function addStatus(){
        $this->created  = date('Y-m-d H:i:s');
        $query = "INSERT INTO " . $this->table3_name . "
            SET 
                status     = :status,
                purchase_orderid = :purchase_orderid,
                userid     = :userid,
                created    = :created";

        $stmt = $this->conn->prepare($query);

        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->purchase_orderid   = htmlspecialchars(strip_tags($this->purchase_orderid));
        $this->userid      = htmlspecialchars(strip_tags($this->userid));
        $this->created       = htmlspecialchars(strip_tags($this->created));  

        $stmt->bindParam(':status', $this->status);        
        $stmt->bindParam(':purchase_orderid', $this->purchase_orderid);
        $stmt->bindParam(':userid', $this->userid);
        $stmt->bindParam(':created', $this->created);

        if($stmt->execute()){
            return true;
        }
        else{
            $this->showError($stmt);
            return false;
        }
    }

    function getLastPurchaseOrder(){
        $query = "SELECT max(id) AS total FROM " . $this->table1_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();   
        $num = $stmt->rowCount();
    
        if($num>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->total = $row['total'];
            return $this->total;
        }
        else{
            $this->showError($stmt);
            return false;
        }
    }
}