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
    public $type;
    public $producttype;
    public $productname;
    public $productcategory;
    public $note;
    public $userid;

    public function __construct($db){
        $this->conn = $db;
    }
    
    /*function setProduct(){
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
                `code`       = :code, 
                `name`       = :name,
                `image_url`  = :image_url,
                `type`       = :type,
                `created`    = :created,
                `modified`   = :modified,
                `visibility` = :visibility,
                `jodid`      = :jodid";

        $stmt = $this->conn->prepare($query);

        $this->productitemname  = htmlspecialchars(strip_tags($this->productitemname));
        $this->image_url        = htmlspecialchars(strip_tags($this->image_url));
        $this->visibility = htmlspecialchars(strip_tags($this->visibility));    
        $this->jodid      = htmlspecialchars(strip_tags($this->jodid));
        $this->type       = htmlspecialchars(strip_tags($this->type));     
        $this->code      = htmlspecialchars(strip_tags($this->code));
        $this->created    = htmlspecialchars(strip_tags($this->created));
        $this->modified   = htmlspecialchars(strip_tags($this->modified));

        $stmt->bindParam(':name',       $this->productitemname);        
        $stmt->bindParam(':image_url',  $this->image_url);
        $stmt->bindParam(':type',       $this->type);
        $stmt->bindParam(':created',    $this->created);
        $stmt->bindParam(':modified',   $this->modified);
        $stmt->bindParam(':visibility', $this->visibility);
        //$stmt->bindParam(':productid',  $this->productid);
        $stmt->bindParam(':jodid',      $this->jodid);
        $stmt->bindParam(':code',      $this->code);

        if($stmt->execute()){
            return true;
        }
        else{
            $this->showError($stmt);
            return false;
        }
    }*/

    function setProductItem(){
        $this->created  = date('Y-m-d H:i:s');
        $this->modified = date('Y-m-d H:i:s');

        $query = "INSERT INTO `product_item`
            SET
                `type`      = :producttype,
                `name`      = :productname, 
                `category`  = :productcategory,
                `created`   = :created, 
                `modified`  = :modified, 
                `userid`    = :userid"; 

        $stmt = $this->conn->prepare($query);

        $this->producttype  = htmlspecialchars(strip_tags($this->producttype));
        $this->productname  = htmlspecialchars(strip_tags($this->productname));
        $this->productcategory = htmlspecialchars(strip_tags($this->productcategory));        
        $this->created    = htmlspecialchars(strip_tags($this->created));
        $this->modified   = htmlspecialchars(strip_tags($this->modified));
        $this->userid     = htmlspecialchars(strip_tags($this->userid));

        $stmt->bindParam(':producttype',     $this->producttype);        
        $stmt->bindParam(':productname',     $this->productname);
        $stmt->bindParam(':productcategory', $this->productcategory);
        $stmt->bindParam(':created',       $this->created);
        $stmt->bindParam(':modified',      $this->modified);
        $stmt->bindParam(':userid',        $this->userid);

        if($stmt->execute()){
            return true;
        }
        else{
            $this->showError($stmt);
            return false;
        }
    }

    function setProductItemVariant(){
        $this->created  = date('Y-m-d H:i:s');
        $this->modified = date('Y-m-d H:i:s');

        $query = "INSERT INTO `product_item_variant`
                SET
                    `image_url` =   :image_url,
                    `code`      =   :code,
                    `note`      = :note,
                    `created`   =   :created,
                    `modified`  =   :modified,
                    `product_colorid`   =   :product_colorid,
                    `product_itemid`    =   :product_itemid,
                    `jodid`     =   :jodid,
                    `userid`    =   :userid";

        $stmt = $this->conn->prepare($query);

        $this->image_url  = htmlspecialchars(strip_tags($this->image_url));
        $this->code       = htmlspecialchars(strip_tags($this->code));
        $this->note       = htmlspecialchars(strip_tags($this->note));        
        $this->created    = htmlspecialchars(strip_tags($this->created));
        $this->modified   = htmlspecialchars(strip_tags($this->modified));
        $this->product_colorid     = htmlspecialchars(strip_tags($this->product_colorid));
        $this->product_itemid     = htmlspecialchars(strip_tags($this->product_itemid));
        $this->jodid      = htmlspecialchars(strip_tags($this->jodid));
        $this->userid     = htmlspecialchars(strip_tags($this->userid));

        $stmt->bindParam(':image_url',       $this->image_url);        
        $stmt->bindParam(':code',            $this->code);
        $stmt->bindParam(':note',            $this->note);
        $stmt->bindParam(':created',         $this->created);
        $stmt->bindParam(':modified',        $this->modified);
        $stmt->bindParam(':product_colorid', $this->product_colorid);
        $stmt->bindParam(':product_itemid',  $this->product_itemid);
        $stmt->bindParam(':jodid',           $this->jodid);
        $stmt->bindParam(':userid',          $this->userid);

        if($stmt->execute()){
            return true;
        }
        else{
            $this->showError($stmt);
            return false;
        }
    }

    function getProductItemCount(){
        $query = "SELECT max(id) AS total FROM product_item";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();   
        $num = $stmt->rowCount();
    
        if($num>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'];;
        }
        return false;
    }

    function readItems(){
        $query = "SELECT 
                product_items.`name`,
                product_items.`image_url`,
                product_items.`modified`,
                /*product_items.`productid`,*/
                users.nickname,
                job_order_details.code,
                job_order_details.type,
                product_items.visibility
                FROM product_items
                JOIN job_order_details ON product_items.jodid = job_order_details.id
                JOIN job_order ON job_order_details.job_orderid = job_order.id
                JOIN users ON users.userid = job_order.userid
                WHERE product_items.isDeleted <> 'Y'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name  = $row['name'];
        $stmt->execute();
        return $stmt;
    }

    function readProductItems($from_record_num, $records_per_page){
        $query = "SELECT 
            product_item.id,
            product_item.name as 'name',
            /*concat(product_item.name, ' (',product_color.name,')') as 'name',
            */product_item.type,
            product_item.category,
            product_item_variant.id,
            product_item_variant.image_url,
            product_item_variant.code,
            product_color.name as 'color'
            FROM product_item
            JOIN product_item_variant ON product_item.id = product_item_variant.product_itemid
            JOIN product_color ON product_item_variant.product_colorid = product_color.id
            WHERE product_item.isDeleted <> 'Y'
            AND product_item_variant.isDeleted <> 'Y'
            limit {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name  = $row['name'];
        $stmt->execute();
        return $stmt;
    }

    function getProductItemsCount(){
        $query = "SELECT 
            count(*) as total
            FROM product_item_variant";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name  = $row['total'];
        return $this->name;
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