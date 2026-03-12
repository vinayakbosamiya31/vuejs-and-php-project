<?php
 header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
class DB
{

    private $mysql = "mysql:host=localhost;dbname=vinay_todo_app";
    private $user = "root";
    private $psw = "";
    public $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->mysql, $this->user, $this->psw);
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo 'success';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function insert($fname, $e, $phone)
    {
        $sql = $this->conn->prepare("INSERT INTO users(Name,Email,Phone) VALUES(?,?,?)");
        $sql->bindParam(1, $fname, PDO::PARAM_STR);
        $sql->bindParam(2, $e, PDO::PARAM_STR);
        $sql->bindParam(3, $phone, PDO::PARAM_INT);
        $sql->execute();

        return true;

    }

    public function Read($db)
    {
        $data = array();
        $sql = $this->conn->prepare("SELECT * FROM $db");
        $sql->execute();
        $res = $sql->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res as $row) {
            $data[] = $row;
        }
        
        return $data;
    }

    public function getUserById($db,$id){
        $sql = $this->conn->prepare("SELECT * FROM $db WHERE id = ?");
        $sql->bindParam(1,$id, PDO::PARAM_INT);
        $sql->execute();
        $res = $sql->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function update($db,$name, $email, $phone,$id){
    
         $sql = $this->conn->prepare("UPDATE $db SET Name=?, Email=?, Phone=? WHERE Id=?");
    $sql->execute([$name, $email, $phone, $id]);
    echo $sql->rowCount();
        return true;
    }

    public function delete($db,$id)
    {
        $sql = $this->conn->prepare("DELETE FROM $db WHERE Id = ?");
        $sql->bindParam(1,$id,PDO::PARAM_INT);
        $sql->execute();
        return true;
    }

    public function Crow($db){
    $sql = $this->conn->prepare("SELECT * FROM $db");
    $sql->execute();
    $t_row = $sql->rowCount();

    return $t_row;
    }
}
// $obj = new DB();
// print_r($obj->Crow('users'));
?>