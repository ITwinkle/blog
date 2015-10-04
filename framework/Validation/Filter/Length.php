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
        $this->maxLenght = $max;
        $this->minLength = $min;
    }

    /**
     * validate field to length
     *
     * @param $field - checked field
     * @return bool|string
     */
    public function validate($field){
        if(count($field) < $this->minLength || count($field) > $this->maxLength){
            return 'Length of '.$field.'don\'t in diapason between '.$this->minLength.' and '.$this->maxLenght  ;
        }else{
            return true;
        }
    }
}