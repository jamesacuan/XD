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
        
        $tables = array("job_order_feedback",
                        "job_order_details",
                        "job_order",
                        "product",
                        "product_items",
                        "purchase_order",
                        "purchase_order_details",
                        "users",
                        "job_order_status");
                        
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

}