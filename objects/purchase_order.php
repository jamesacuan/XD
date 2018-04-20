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
}