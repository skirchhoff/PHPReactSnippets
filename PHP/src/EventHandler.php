<?php
/**
 *  @description - small event manager
 */

class EventHandler {

    private $__event_func_stack = [];

    /**
     *  @description - registers function to event stack.
     *  @param {string}$name - name of event to trigger
     *  @param {function}$func - function to call, when event triggers
     */
    public function on ($name,$func){
        if(is_callable($func)){
            $this->__event_func_stack[$name] = $func;
        }
    }

    /**
     *  @description - calls registered function by given event name
     *  @param {string}$name - name of event
     *  @param {mixed}$param - parameter from triggered object
     */
    protected function call_event($name,$param = null){
        if($this->__event_func_stack[$name]){
            $this->__event_func_stack[$name]($param);
        }else{
            throw new Exception("Error: no eventhandler called '".$name."' registred!");
        }   
    }
}
?>