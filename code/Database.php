<?php

class Query{
    public $table = '';      // table name
    public $action = '';     // select insert update delete
    public $fields_value = [];
    public $condition = [];  // where
    
    
    public $string = '';
    
    function __construct($table, $action){
        $this->table = $table;
        $this->action = $action;
    }

    
    function addCondition(){}
    function get(){}
}


class Database{
    private static $instance=null;
    private $address = '';
    private $DBname = '';
    private $user = '';
    private $pass = '';
    private $connection = null;

    private function __construct(){}

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Database;
        }
        return self::$instance;
    }

    public function initialize($address, $DBname, $user, $pass){
        $this->address = $address;
        $this->DBname = $DBname;
        $this->user = $user;
        $this->pass = $pass;
        $this->makeConnection();
    }

    private function makeConnection(){
        try {
            $conn = new PDO("mysql:host=".$this->address.";dbname=".$this->DBname, $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection = $conn;

        } catch(PDOException $e) {
            exit("Connection failed: " . $e->getMessage());
        }
    }

    public function saveObj($object, $table_name = null){

        if ($table_name == null){
            $table_name = strtolower(get_class($object));
        }

        //string of sets
        $fields = get_object_vars($object);
        $fields_array = [];
        $value_array = [];

        foreach($fields as $field_name => $field_value){
            $fields_array[] = $field_name;
            $value_array[] = "'".$field_value."'";
            $update_set[] = $field_name."='".$field_value."'";
        }

        // ubdate
        $ID = $object->getField('_id');
        if($ID != null){
            $sql = "UPDATE ". $table_name . " SET " . implode(", ", $update_set) . " WHERE _id=".$ID.";";
        }

        // insert
        else{
            $sql = "INSERT INTO ". $table_name ." (" . implode(", ", $fields_array) . ") VALUES (".implode(", ", $value_array).");";
        }
    
        try {
            $this->connection->exec($sql);
            return true;
        } catch(PDOException $e) {
            exit("Connection failed: " . $e->getMessage());
            return false;
        }

    }

    public function select($table_name, $conditions = "true"){
        $sql = "SELECT * FROM " . strtolower($table_name) . " WHERE " . $conditions. ";";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    
    public function deleteObj($object, $table_name = null){

        if ($table_name == null){
            $table_name = strtolower(get_class($object));
        }

        if($object->getField('_id') == null){
            echo "error: it doesn't indicate to spesific object";
        }

        $sql = "DELETE FROM " . $table_name . " WHERE _id=".$object->getField('_id').";";

        try {
            $this->connection->exec($sql);
            return true;
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
            return false;
        }

    }
    
}