<?php

namespace Framework\Validation;

class Validator
{
    /**
     * current object
     *
     * @var object
     */
    private $object;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * set object
     *
     * @param $object - name of object
     */
    public function __construct($object){
        $this->object = $object;
    }

    /**
     * set error message
     *
     * @param $error - text of error
     */
    public function setErrors($error){
        $this->errors = array_merge($this->errors,$error) ;

    }

    /**
     * return error message
     * @return array
     */
    public function getErrors(){
        return $this->errors;
    }

    /**
     * check object
     *
     * @return bool
     */
    public function isValid(){
        $rules = $this->object->getRules();
        foreach($rules as $rule=>$field){
            foreach($field as $value){
                $val = $value->validate($this->object->$rule,$rule);
                if(is_array($val)){
                    $this->setErrors($val);
                }
            }

        }
        if(!empty($this->getErrors())){
            return false;
        }
        return true;
    }
}