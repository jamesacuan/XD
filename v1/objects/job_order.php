<?php
class JobOrder{

    private $conn;
    private $table1_name = "job_order";
    private $table2_name = "job_order_details";

    public $joborderid;
    public $userid;
    public $type;
    public $code, $note, $image_url, $expectedJO, $created, $modified, $isDeleted, $joborderdetailsid;
    public $jocount, $tycount;
    public $nickname;

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


    function approve(){
        $this->modified = date('Y-m-d H:i:s');

        $query = "UPDATE " . $this->table2_name . "
                 SET
                    status   = :status,
                    modified = :modified
                 WHERE
                    id       = :id";

        $stmt = $this->conn->prepare($query);

        $this->status            = htmlspecialchars(strip_tags($this->status));
        $this->modified          = htmlspecialchars(strip_tags($this->modified));
        $this->joborderdetailsid = htmlspecialchars(strip_tags($this->joborderdetailsid));

        $stmt->bindParam(':status',   $this->status);
        $stmt->bindParam(':modified', $this->modified);
        $stmt->bindParam(':id',       $this->joborderdetailsid);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function delete(){
        $this->modified = date('Y-m-d H:i:s');

        $query = "UPDATE " . $this->table2_name . "
                 SET
                    isDeleted   = :isDeleted,
                    modified    = :modified
                 WHERE
                    id          = :id";

        $stmt = $this->conn->prepare($query);

        $this->isDeleted         = htmlspecialchars(strip_tags($this->status));
        $this->modified          = htmlspecialchars(strip_tags($this->modified));
        $this->joborderdetailsid = htmlspecialchars(strip_tags($this->joborderdetailsid));

        $stmt->bindParam(':isDeleted',   $this->isDeleted);
        $stmt->bindParam(':modified', $this->modified);
        $stmt->bindParam(':id',       $this->joborderdetailsid);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

   function getJobOrderCount(){
        $query = "SELECT max(id) AS total FROM job_order";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();   
        $num = $stmt->rowCount();
    
        if($num>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->jocount = $row['total'];
            return $this->jocount;
        }
        return false;
    }

    function getJobOrderDetailsCount($JOID){
        $query = "SELECT count(*) AS total FROM job_order_details where job_orderid={$JOID}";

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

    function getJobOrderUser($JOID){
        $query = "SELECT nickname, job_order.created FROM job_order 
                    JOIN users ON job_order.userid = users.userid
                    where job_order.id={$JOID}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();   
        $num = $stmt->rowCount();
    
        if($num>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->answer = $row['nickname'];
            return $this->answer;
        }
        return false;
    }


    function getTypeCount($type_){
        $query = "SELECT count(*) AS total FROM `job_order_details` WHERE `type`='{$type_}'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();   
        $num = $stmt->rowCount();
    
        if($num>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->tycount = $row['total'];
            return $this->tycount;
        }
        return false;
    }

    function readJO($JOID){
        $query = "SELECT job_order.id as JOID,
                        users.nickname,
                        job_order.created
                        FROM `job_order`
                        JOIN users on job_order.userid = users.userid
                        WHERE job_order.id = $JOID";
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

    function readJOD($JOID){
        $query = "SELECT job_order.id as JOID,
                        job_order_details.id as JODID,
                        job_order_details.type,
                        job_order_details.code,
                        users.username,
                        job_order_details.note,
                        job_order_details.image_url,
                        job_order_details.modified,
                        job_order_details.status
                        FROM `job_order`
                        JOIN users on job_order.userid = users.userid
                        JOIN job_order_details on job_order.id = job_order_details.job_orderid
                        WHERE job_order.id = $JOID";
                        /*ORDER BY job_order_details.modified DESC
                        LIMIT {$from_record_num}, {$records_per_page}";
                        */
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readJODwithUserandStatus($userid, $status){
        $query = "SELECT job_order.id as JOID,
                job_order_details.id as JODID,
                job_order_details.type,
                job_order_details.code,
                users.username,
                job_order_details.note,
                job_order_details.image_url,
                job_order_details.modified,
                job_order_details.status
                FROM `job_order`
                JOIN users on job_order.userid = users.userid
                JOIN job_order_details on job_order.id = job_order_details.job_orderid
                WHERE users.userid = $userid
                ORDER BY job_order_details.modified DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    function read($typeval){
        $query = "SELECT job_order.id as JOID,
                        job_order_details.id as JODID,
                        job_order_details.type,
                        job_order_details.code,
                        users.username,
                        job_order_details.note,
                        job_order_details.image_url,
                        job_order_details.modified,
                        job_order_details.created,
                        job_order_details.status
                        FROM `job_order`
                        JOIN users on job_order.userid = users.userid
                        JOIN job_order_details on job_order.id = job_order_details.job_orderid
                        WHERE job_order_details.type LIKE '%{$typeval}%'
                            AND job_order_details.isDeleted <> 'Y'";
                        /*ORDER BY job_order_details.modified DESC
                        LIMIT {$from_record_num}, {$records_per_page}";
                        */
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function getJOItem(){
        $query = "SELECT job_order.id,
        job_order_details.type,
        job_order_details.code,
        users.username,
        users.nickname,
        job_order_details.note,
        job_order_details.image_url,
        job_order_details.modified,
        job_order_details.status
        FROM `job_order`
        JOIN users on job_order.userid = users.userid
        JOIN job_order_details on job_order.id = job_order_details.job_orderid
        WHERE job_order_details.code LIKE ?";
        /*ORDER BY job_order_details.modified DESC*/
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->code);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->joborderid  = $row['id'];
        $this->type        = $row['type'];
        $this->username    = $row['username'];
        $this->nickname    = $row['nickname'];
        $this->note        = $row['note'];
        $this->image_url   = $row['image_url'];
        $this->modified    = $row['modified'];
        $this->status      = $row['status'];
        //return $stmt;
    }

    function truncate(){
        $query1 = "TRUNCATE job_order_details";
        $query2 = "TRUNCATE job_order";

        $stmt = $this->conn->prepare($query1);
        $stmt->execute();   
    
        $stmt = $this->conn->prepare($query2);
        $stmt->execute();
        return $stmt;
    }
}
?>