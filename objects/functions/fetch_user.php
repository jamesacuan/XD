<?php
/*$connect = mysqli_connect("localhost", "root", "", "xd");
$output = '';

$query = "SELECT `userid`, `username`, `nickname`, `password`, `role`, isAdmin, created, modified 
                FROM users
                WHERE username = ?
                LIMIT 0,1";

$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);

if($row.count() > 0){
    return true;
}
else return false;
*/
//set the headers to be a json string
header('content-type: text/json');

//no need to continue if there is no value in the POST username
if(!isset($_POST['username']))
    exit;

//initialize our PDO class. You will need to replace your database credentials respectively
$db = new PDO('mysql:host=localhost;dbname=xd','root','',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

//prepare our query.
$query = $db->prepare('SELECT * FROM users WHERE username = :name');
//let PDO bind the username into the query, and prevent any SQL injection attempts.
$query->bindParam(':name', $_POST['username']);
//execute the query
$query->execute();

//return the json object containing the result of if the username exists or not. The $.post in our jquery will access it.
echo json_encode(array('exists' => $query->rowCount() > 0));



?>