<?php

class DataProxy {

    private static $__data_stack = [];

    /**
     *  @description - registers data to stack.
     *  @param {string}$name - name of data
     */
    public static function on ($name,$obj){
        if(!is_callable($obj)){
            self::$__data_stack[$name] = $obj;
        }
    }

    /**
     *  @description - calls registered data block by given name
     *  @param {string}$name - name of block
     */
    public static function call_data($name){
        if(self::$__data_stack[$name]){
            return self::$__data_stack[$name];
        }else{
            throw new Exception("Error: no data block called '".$name."' registred!");
        }   
    }
}
?>