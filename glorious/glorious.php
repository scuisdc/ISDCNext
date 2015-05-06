<?php

class GloriousDB{
    private $db;
    private $state;
    private $table;
    private $find_q = "";
    public function __construct($host, $username, $passwd, $database){
        $this->db = new mysqli($host, $username, $passwd, $database);
        if(mysqli_connect_errno())
        {
            $this->state = false;
        }
        $this->state = true;
        $this->db->query("SET NAMES UTF8");
    }

    public function state(){
        return $this->state;
    }

    public function destroy(){
        $this->db->close();
    }

    private function _execute($query, $columns="*"){
        $res = $this->_query($query);
        if ($columns == "*")
            $columns = $this->getColumnNames($this->table);
        $ret = array();
        for ($i = 0; $i < $res->num_rows; $i ++){
            $row = $res->fetch_assoc();
            $temp_ret = array();
            for($j = 0; $j < count($columns); $j ++) {
                $column = $columns[$j];
                if($row[$column] != null)
                    $temp_ret[$column] = $row[$column];
            }
            array_push($ret, $temp_ret);
        }
        return $ret;
    }

    public function getColumnNames($table){
        $q = "show columns from ".$table;
        $res = $this->db->query($q);
        $arr = array();
        while($row = mysqli_fetch_array($res)){
            array_push($arr, $row['Field']);
        }
        return $arr;
    }

    private function _getKeyName($table)
    {
        $r = mysqli_fetch_assoc($this->_query("SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'"));
        return $r['Column_name'];
    }


    public function findOne($value)
    {
        $pri = $this->_getKeyName($this->table);
        $q = "select * from $this->table where $pri=$value;";
        $res = $this->_execute($q);
        return $res[0];
    }

    public function _wherehelper($ary, $opr="and", $op)
    {
        $keys = array_keys($ary);
        $values = array_values($ary);
        $sql_cond = "(";
        for($k = 0; $k < count($keys); $k ++)
        {
            $str = ""; //string for each condition
            $key = $keys[$k];
            $value = $values[$k];
            $first_letter = $value[0];
            if($first_letter == ">" || $first_letter == "<" || $first_letter ==
                "!")
            {
                $str .= "$key$value $opr ";
            }
            else{
                $str .= "$key='$value' $opr ";
            }
            $sql_cond .= $str;
        }
        if($opr == "or")
            $sql_cond = substr($sql_cond, 0, -4);
        else
            $sql_cond = substr($sql_cond, 0, -5);
        $sql_cond .= ")";
        $this->find_q .= " $op ".$sql_cond;
    }

    public function where($ary, $opr="and")
    {
        $this->_wherehelper($ary, $opr, "and");
        return $this->db;
    }

    public function orWhere($ary, $opr="and")
    {
        $this->_wherehelper($ary, $opr, "or");
        return $this->db;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    /*只提供了query方法，没有其他任何的封装*/
    public function sql($query)
    {
        return $this->_query($query);
    }
    /*查找对应的列*/
    public function find($columns="*")
    {
        $length = count($this->find_q);
        $q = "select * from $this->table where ".substr($this->find_q, 4).";";
        $ret = $this->_execute($q, $columns);
        $this->find_q = "";
        return $ret;
    }

    private function _query($sql){
        return $this->db->query($sql);
    }

    public function insert($ary){
        $sqlA = '';
        foreach($ary as $k=>$v){
            $sqlA .= "`$k` = '$v',";
        }

        $sqlA = substr($sqlA, 0, strlen($sqlA)-1);
        $sql  = "insert into $this->table set $sqlA";
        $this->_query($sql);
    }

    public function update($update, $cond){
        $sqlA = "";
        foreach($update as $k=>$v){
            $sqlA .= "$k = '$v', ";
        }
        $key = array_keys($cond)[0];
        $val = array_values($cond)[0];
        $sqlB = "$key = '$val'";

        $sqlA = substr($sqlA, 0, strlen($sqlA)-2);
        $sql = "update $this->table set $sqlA where $sqlB;";
        return $this->_query($sql);
    }

    public function findall() {
        $q = "select * from $this->table;";
        return $this->_execute($q);
    }

    public function delete($cond){
        $key = array_keys($cond)[0];
        $val = array_values($cond)[0];
        $sqlB = "$key = '$val'";

        $sql = "delete from $this->table where $sqlB;";
        return $this->_query($sql);
    }
}

?>
