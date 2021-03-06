<?php
class PurchaseOrder{

    private $conn;
    private $table1_name = "purchase_order";
    private $table2_name = "purchase_order_details";
    private $table3_name = "purchase_order_status";

    public $userid;
    public $image_url;
    public $expectedJO;
    public $product; //if HH / TH
    public $created, $modified, $isDeleted;
    public $productitemid;
    public $quantity;
    public $color;
    public $note;
    public $status;
    public $total;
    public $type;
    public $purchase_orderid;
    public $productname;


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

        $stmt = $this->conn->prepare($query);

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
                product    = :product,
                productitemid = :productitemid,
                quantity   = :quantity,
                color      = :color,
                note       = :note,
                purchase_orderid = :purchase_orderid";
                //////////////id 	product_id 	quantity 	type 	additional_detail 	purchaseorder_code 

        $stmt = $this->conn->prepare($query);

        $this->product    = htmlspecialchars(strip_tags($this->product));
        $this->productitemid = htmlspecialchars(strip_tags($this->productitemid));
        $this->quantity   = htmlspecialchars(strip_tags($this->quantity));
        $this->color      = htmlspecialchars(strip_tags($this->color));
        $this->note       = htmlspecialchars(strip_tags($this->note));  
        $this->type   = htmlspecialchars(strip_tags($this->type));
        $this->purchase_orderid   = htmlspecialchars(strip_tags($this->purchase_orderid));

        $stmt->bindParam(':product', $this->product);        
        $stmt->bindParam(':productitemid', $this->productitemid);        
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':note', $this->note);
        $stmt->bindParam(':color', $this->color);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':purchase_orderid', $this->purchase_orderid);

        if($stmt->execute()){
            return true;
        }
        else{
            $this->showError($stmt);
            return false;
        }
    }

    function setStatus(){
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

    function read(){
        $query = "SELECT purchase_order.id,
                    users.nickname,
                    purchase_order.created,
                    s1.status
                FROM `purchase_order`
                JOIN users on users.userid = purchase_order.userid
                JOIN purchase_order_status s1 on s1.purchase_orderid = purchase_order.id
                WHERE purchase_order.isDeleted <> 'Y'
                AND s1.created = (SELECT MAX(s2.created) FROM purchase_order_status s2
                                    WHERE s2.purchase_orderid = s1.purchase_orderid)";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readPOD($POID){
        $query = "SELECT purchase_order.id,
                    users.nickname,
                    users.username,
                    purchase_order.created,
                    s1.status
                FROM `purchase_order`
                JOIN users on users.userid = purchase_order.userid
                JOIN purchase_order_status s1 on s1.purchase_orderid = purchase_order.id
                WHERE purchase_order.id = $POID
                AND   s1.created = (SELECT MAX(s2.created) FROM purchase_order_status s2
                                    WHERE s2.purchase_orderid = s1.purchase_orderid)";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->username  = $row['username'];
        $this->nickname  = $row['nickname'];
        $this->created   = $row['created'];
        $this->purchase_orderid = $row['id'];
        $this->status   = $row['status'];

        $stmt->execute();
        return $stmt;
    }

    function readPOItem($POID){
        $query = "SELECT p1.`id`,
        p1.`product`,
        p1.`type`,
        p1.`quantity`,
        product_color.name as color,
        p1.`note`,
        product_items.name as productname,
        product_items.`image_url`
        FROM purchase_order_details p1
        JOIN product_color ON product_color.id = p1.color
        JOIN product_items ON p1.productitemid = product_items.id
        WHERE p1.`purchase_orderid` = $POID
 UNION
 SELECT p2.`id`,
        p2.`product`,
        p2.`type`,
        p2.`quantity`,
        product_color.name as color,
        p2.`note`,
        p2.`productitemid` as productname,
        p2.`productitemid` as image_url
        FROM purchase_order_details p2
        JOIN product_color ON product_color.id = p2.color
        WHERE (p2.productitemid = '0' OR p2.productitemid = 'undefined') AND
        p2.`purchase_orderid` = $POID";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->type         = $row['type'];
        $this->quantity     = $row['quantity'];
        $this->image_url     = $row['image_url'];
        $this->color        = $row['color'];
        $this->note         = $row['note'];
        $this->productname  = $row['productname'];

        $stmt->execute();
        return $stmt;
    }
}