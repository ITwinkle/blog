<?php

namespace Framework\Validation\Filter;

class Length
{
    private $maxLength;

    private $minLength;

    /**
     * @param $min - min value
     * @param $max - max value
     */
    public function __construct($min,$max){
        $this->minLength = $min;
        $this->maxLength = $max;
    }

    /**
     * validate field to length
     *
     * @param $field - checked field
     * @param $key - name of checked field
     * @return bool|string
     */
    public function validate($field,$key){
        if(strlen($field) >= $this->minLength && strlen($field) <= $this->maxLength){
            return true;
        }else{
            return array($key=>'Length of \''.$key.'\' don\'t in diapason between '.$this->minLength.' and '.$this->maxLength.' symbols');
        }
    }
}