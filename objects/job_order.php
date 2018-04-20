<?php
class JobOrder{

    private $conn;
    private $table1_name = "job_order";
    private $table2_name = "job_order_details";

    public $userid;
    public $created;
    public $modified;
    public $isDeleted;

    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
        $this->created=date('Y-m-d H:i:s');
        $this->modified=date('Y-m-d H:i:s');

        $query = "INSERT INTO " . $this->table1_name . "
                SET 
                    userid = :user_id,
                    created = :created,
                    modified = :modified";

        $stmt = $this->conn->prepare($query);

        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->modified=htmlspecialchars(strip_tags($this->modified));
        
        $stmt->bindParam(':created', $this->created);
        $stmt->bindParam(':modified', $this->modified);

        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }
    }

    function create_details(){
        $this->created=date('Y-m-d H:i:s');
        $this->modified=date('Y-m-d H:i:s');

        $query = "INSERT INTO " . $this->table2_name . "
                SET 
                    type = :type,
                    code = :code,
                    image_url = :image_url,
                    status = :status,
                    created = :created,
                    modified = :modified,
                    job_orderid = :joborder_id";
        
        $stmt = $this->conn->prepare($query);
    }
}
?>