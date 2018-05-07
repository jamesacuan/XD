<?php
class PurchaseOrder{

    private $conn;
    private $table1_name = "purchase_order";

    public $userid;
    public $note;
    public $image_url;
    public $expectedJO;
    public $created;
    public $modified;
    public $isDeleted;

    public $count;

    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
        $this->created  = date('Y-m-d H:i:s');
        $this->modified = date('Y-m-d H:i:s');

        $query1 = "INSERT INTO " . $this->table1_name . "
                SET 
                    userid = :userid,
                    created = :created,
                    modified = :modified";

        $query2 = "INSERT INTO " . $this->table2_name . "
                SET 
                    type = :type,
                    code = :code,
                    note = :note,
                    image_url = :image_url,
                    status = :status,
                    created = :created,
                    modified = :modified,
                    job_orderid = :job_orderid";

        $stmt1 = $this->conn->prepare($query1);
        $stmt2 = $this->conn->prepare($query2);

        $this->userid     = htmlspecialchars(strip_tags($this->userid));
        $this->type       = htmlspecialchars(strip_tags($this->type));
        $this->code       = htmlspecialchars(strip_tags($this->code));
        $this->note       = htmlspecialchars(strip_tags($this->note));  
        $this->image_url  = htmlspecialchars(strip_tags($this->image_url));
        $this->status  = htmlspecialchars(strip_tags($this->status));
        $this->expectedJO = htmlspecialchars(strip_tags($this->expectedJO));     
        $this->created    = htmlspecialchars(strip_tags($this->created));
        $this->modified   = htmlspecialchars(strip_tags($this->modified));

        $stmt1->bindParam(':userid', $this->userid);        
        $stmt1->bindParam(':created', $this->created);
        $stmt1->bindParam(':modified', $this->modified);

        $stmt2->bindParam(':type', $this->type);        
        $stmt2->bindParam(':code', $this->code);
        $stmt2->bindParam(':note', $this->note);
        $stmt2->bindParam(':image_url',  $this->image_url);
        $stmt2->bindParam(':status',     $this->status);
        $stmt2->bindParam(':created',    $this->created);
        $stmt2->bindParam(':modified',   $this->modified);
        $stmt2->bindParam(':job_orderid', $this->expectedJO);

        if($stmt1->execute()){
            if($stmt2->execute()){
                return true;
            }
            else{
                $this->showError($stmt2);
                return false;
            }
        }else{
            $this->showError($stmt1);
            return false;
        }
    }
}