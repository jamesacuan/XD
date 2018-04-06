<?php
class Ticket{
 
    private $conn;
    private $table_name = "ticket";
 
    public $id;
    public $type;
    public $code;
    public $created;
    public $modified;
    public $isDeleted;
 
    public function __construct($db){
        $this->conn = $db;
    }

    function create(){

        $this->created=date('Y-m-d H:i:s');

        $query = "INSERT INTO " . $this->table_name . " 
                SET
                    type = :type, 
                    code = :code, 
                    created = :created, 
                    modified = :modified";
 
        $stmt = $this->conn->prepare($query);

        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->code=htmlspecialchars(strip_tags($this->code));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->modified=htmlspecialchars(strip_tags($this->modified));

        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':code', $this->code);
        $stmt->bindParam(':created', $this->created);
        $stmt->bindParam(':modified', $this->modified);

        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }
    }
}