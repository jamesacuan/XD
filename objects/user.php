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
        $query = "SELECT userid, username, `password`, `role`, created, modified 
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
            $this->id = $row['userid'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            $this->role = $row['role'];

            return true;
        }
    
        return false;
    }
}