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

    function userExists(){
        $query = "SELECT `userid`, `username`, `password`, `role`, isAdmin, created, modified 
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