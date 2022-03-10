<?php

require_once("Database.php");

Database::getInstance()->initialize('mysql', 'simple-php-orm', 'root', 'root');

class Model{

    protected $_id = null;

    public function __construct($fields = []){
        foreach($fields as $field_name => $field_value){
            $this->$field_name = $field_value;
        }
    }

    public function getField($name){
        return $this->$name;
    }

    public function setField($name, $value){
        $this->$name = $value;
        return $this;
    }

    public function save(){
        return Database::getInstance()->saveObj($this);
    }

    public function delete(){
        return Database::getInstance()->deleteObj($this);
    }

    static function getAll(){
        $model_name = get_called_class();
        $query_results = Database::getInstance()->select($model_name);
        $result = [];
        foreach ($query_results as $item) {
                $result[] = new $model_name($item);
        }
        return $result;
    }

    static function getOne(){
        $model_name = get_called_class();
        $query_results = Database::getInstance()->select($model_name);
        $result = new $model_name($query_results[0]);
        return $result;
    }

    static function filter($conditions){
        $model_name = get_called_class();
        $query_results = Database::getInstance()->select($model_name, $conditions);
        $result = [];
        foreach ($query_results as $item) {
                $result[] = new $model_name($item);
        }
        if(sizeof($result) == 1){
            $result = $result[0];
        }
        return $result;
    }
}
