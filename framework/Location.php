<?php

namespace Framework;

class Location
{
    private $words = [];

    /**
     * Initialize language you need
     *
     * @param string $path  - path to folder with locales
     * @param string $lang - language you need
     */
    public function __construct($path, $lang = 'en_US'){
        $ini_file = $path . $lang . '.ini' ;
        if(file_exists($ini_file)){
            $this->words = parse_ini_file($ini_file);
        } else {
            $this->words = ROOT.'app/Locale/en_US.ini';
        }
    }

    /**
     * Getter method
     *
     * @param string $word - word you need
     * @return mixed
     */
    public function getWord($word){
        return $this->words[$word];
    }
}