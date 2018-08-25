<?php
    require_once('database.php');
    class FormBuilder{
        private $tableInfo = array();
        private $fields = array();
        private $ob;
        private $dt = array(
            'varchar'=>'text',
            'int' => "number",
            'date' => 'date',
            'datetime' => 'datetime-local',
            'char' => 'text'
        );
        function __construct(){
            $this->ob = new Connection();
            array_push($this->tableInfo, $this->ob->getTableInfo());
        }

        function generateForm(){
            $form = "<div>
            <form action='classes/submit.php' method='post'>
            <table>";
            $x = count($this->tableInfo[0]);
            for($i=0;$i<$x;$i++){
                $form .= "<tr>";
                $form .= $this->inputs($this->tableInfo[0][$i]["COLUMN_NAME"], $this->tableInfo[0][$i]["DATA_TYPE"]);
                $form .= "</tr>";
            }
            echo $form .= "<tr><td></td><td><input type='submit' name='formdata' value='submit' />
            </td></tr>
            </table>
            </form></div>";
        }

        function inputs($fname, $type){
            return $str = "<td>".$fname."</td>
            <td><input type='".$this->replaceDatatype($type)."' name='".$fname."' required='required' /></td>";
        }

        function replaceDatatype($type){
            if (array_key_exists($type, $this->dt)){
                return $this->dt[$type];
            }else{
                $this->dt['varchar'];
            }
        }
        function getFields(){
            $x = count($this->tableInfo[0]);
            for($i=0;$i<$x;$i++){
                array_push($this->fields, $this->tableInfo[0][$i]["COLUMN_NAME"]);
            }
            return $this->fields;
        }
        function getFormData($data){
            return $this->ob->submitData($this->fields, $data);
        }
    }
?>