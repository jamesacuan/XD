<?php
class User{
 
    private $conn;
    private $table_name = "users";
 
    public $id;
    public $username;
    public $password;
    public $type;
    public $created;
    public $modified;
 
    public function __construct($db){
        $this->conn = $db;
    }
    function addUser(){
        $this->created  = date('Y-m-d H:i:s');
        $this->modified = date('Y-m-d H:i:s');
        $query1 = "INSERT INTO " . $this->table_name . "SET 
                    nickname = :nickname,
                    username = :username,
                    role     = :role,
                    created = :created,
                    modified = :modified";

        $stmt1 = $this->conn->prepare($query1);

        $this->nickname   = htmlspecialchars(strip_tags($this->nickname));
        $this->username   = htmlspecialchars(strip_tags($this->username));
        $this->role       = htmlspecialchars(strip_tags($this->role));  
        $this->created    = htmlspecialchars(strip_tags($this->created));
        $this->modified   = htmlspecialchars(strip_tags($this->modified));

        $stmt1->bindParam(':nickname', $this->nickname);    
        $stmt1->bindParam(':username', $this->username); 
        $stmt1->bindParam(':role', $this->role); 
        $stmt1->bindParam(':created', $this->created);
        $stmt1->bindParam(':modified', $this->modified);

        if($stmt1->execute()){
                return true;
        }else
            return false;
    }


    function userExists(){
        $query = "SELECT `userid`, `username`, `nickname`, `password`, `role`, isAdmin, created, modified 
                FROM " . $this->table_name . "
                WHERE username = ?
                LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $this->username=htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(1, $this->username);
        $stmt->execute();   
        $num = $stmt->rowCount();
    
        if($num>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id       = $row['userid'];
            $this->nickname = $row['nickname'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->role     = $row['role'];
            $this->isAdmin  = $row['isAdmin'];

            return true;
        }
    
        return false;
    }

    function read(){
        $query = "SELECT * FROM `users`
                    WHERE isDeleted <> 'Y'
                    ORDER BY nickname ASC";
                        /*ORDER BY job_order_details.modified DESC
                        LIMIT {$from_record_num}, {$records_per_page}";
                        */
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function getUser($uid){
        $query = "SELECT job_order.id as JOID,
                        users.nickname,
                        job_order.created
                        FROM `job_order`
                        JOIN users on job_order.userid = users.userid
                        WHERE job_order.id = $uid";
                        /*ORDER BY job_order_details.modified DESC
                        LIMIT {$from_record_num}, {$records_per_page}";
                        */
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nickname  = $row['nickname'];
        $this->created   = $row['created'];
        $stmt->execute();
        return $stmt;
    }

}