<?php
class Connection{
    private $conn;
    function __construct(){
        $this->conn = new mysqli("localhost", "root", "", "formbuilder");
    }

    function getTableInfo(){
        /*SELECT COLUMN_NAME, DATA_TYPE  FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = '<table name>' and TABLE_SCHEMA = '<database name> and COLUMN_NAME != 'id''*/

        $information = array();
        $sql = "SELECT COLUMN_NAME, DATA_TYPE  FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'Users' and TABLE_SCHEMA = 'formbuilder' and COLUMN_NAME != 'id'";

        $info = $this->conn->query($sql);
        if($info->num_rows>0){
            while($row=$info->fetch_assoc()){
                array_push($information, $row);
            }
        }
        return $information;
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
        return $this->conn->query($sql);
    }
}
?>