<?php
class Connection{
    private $conn;
    function __construct(){
        $this->conn = new PDO("mysql:host=localhost;dbname=formbuilder", "root", "");
    }

    function getTableInfo(){
        /*SELECT COLUMN_NAME, DATA_TYPE  FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = '<table name>' and TABLE_SCHEMA = '<database name> and COLUMN_NAME != 'id''*/

        $sql = "SELECT COLUMN_NAME, DATA_TYPE  FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'Users' and TABLE_SCHEMA = 'formbuilder' and COLUMN_NAME != 'id'";

        $st = $this->conn->prepare($sql);
        $st->execute();
        return $st->fetchall(PDO::FETCH_ASSOC);
    }

    function submitData($fields, $data){
        $sql = "insert into users(";
        foreach($fields as $f){
            $sql .= $f.", ";
        }
        $sql = substr($sql,0,strlen($sql)-2).") values (";
        foreach($data as $d){
            $sql .= "'".$d."', ";
        }
        $sql = substr($sql,0,strlen($sql)-2).")";
        $st = $this->conn->prepare($sql);
        return $st->execute();
    }
}
?>