<?php

namespace Framework\Validation\Filter;

class NotBlank
{
    /**
     * check field for empty
     *
     * @param $field string - checked field
     * @param $key string - name of checked field
     * @return bool|string
     */
    public function validate($field,$key){
        if('' == trim($field,' ')){
            return array($key=>'The field is empty!');
        }else{
            return true;
        }

    }
}