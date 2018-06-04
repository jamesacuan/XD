<?php
class Settings{

    private $conn;
    private $supername = "admin";
    private $superpass = "";
    private $suprole   = "superadmin";
    private $isAdmin   = "Y";

    public $created, $modified;

    public function __construct($db){
        $this->conn = $db;
    }

    function truncate(){
        $this->created  = date('Y-m-d H:i:s');
        $this->modified = date('Y-m-d H:i:s');
        $this->password  = "$2y$10$PGyDtm3efQwftrblni9Gku6MvX0Z2k/F9eK5HXsm5BLwpOre9nBvS"; //H4mil
        
        //$tmppass = password_hash($this->$superpass, PASSWORD_BCRYPT);
        /*
TRUNCATE job_order;
TRUNCATE job_order_details;
TRUNCATE job_order_feedback;
TRUNCATE job_order_status;
TRUNCATE product;
TRUNCATE product_items;
TRUNCATE product_color;
TRUNCATE purchase_order;
TRUNCATE purchase_order_details;
TRUNCATE users;
*/

        $tables = array("job_order_feedback",
                        "job_order_details",
                        "job_order",
                        "product",
                        "product_items",
                        "purchase_order",
                        "purchase_order_details",
                        "users",
                        "job_order_status",
                        "purchase_order_status");
                        
        $max = sizeof($tables);
        for($i=0; $i<$max; $i++){
            $stmt = $this->conn->prepare("TRUNCATE " . $tables[$i]);
            $stmt->execute(); 
        }

        $query = "INSERT INTO `users`
            SET 
                `nickname` = :nickname, 
                `username` = :username,
                `password` = :password,
                `role`     = :role, 
                `isAdmin`  = :isAdmin,
                `created`  = :created, 
                `modified` = :modified";

        $stmt2 = $this->conn->prepare($query);
       
        $stmt2->bindParam(':nickname', $this->supername);
        $stmt2->bindParam(':username', $this->supername);
        $stmt2->bindParam(':password',  $this->superpass);
        $stmt2->bindParam(':role',     $this->suprole);
        $stmt2->bindParam(':isAdmin',  $this->isAdmin);
        $stmt2->bindParam(':created',  $this->created);
        $stmt2->bindParam(':modified', $this->modified);
        
        if($stmt2->execute()){
            return $stmt2;        
        }
        else
            echo "h1";   
    }

    function getColor($value){
        $colors = array("1A237E", "880E4F", "0D47A1", "006064", "1B5E20", "263238",
                        "4527A0", "4A148C", "00695C", "2E7D32", "311B92", "AD1457");
        $ord = ord(strtoupper($value)) - ord('A') + 1;
        if($ord>20) $ord = $ord-20;
        else if($ord>10) $ord = $ord-10;
        
        return $colors[$ord];
    }
}