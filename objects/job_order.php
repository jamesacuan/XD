<?php
class JobOrder{

    private $conn;
    private $table_name = "job_order";

    public $userid;
    public $created;
    public $modified;
    public $isDeleted;

    public function __construct($db){
        $this->conn = $db;
    }

    function create(){

    }
}
?>