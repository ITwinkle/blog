<?php

namespace Framework\Validation;

class Validatore
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
        $this->errors = $error;
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
            foreach($rules[$rule] as $value){
                $val = $value->validate($rules[$rule]);
                if(is_string($val)){
                    $this->setErrors($val);
                    return false;
                }else{
                    return true;
                }
            }
        }
    }
}