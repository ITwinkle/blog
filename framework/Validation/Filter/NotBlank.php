<?php

namespace Framework\Validation\Filter;

class NotBlank
{
    /**
     * check field for empty
     *
     * @param $field - checked field
     * @return bool|string
     */
    public function validate($field){
        if(empty(trim($field,' '))){
            return $field.' is empty!';
        }else{
            return true;
        }

    }
}