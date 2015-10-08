<?php

namespace Framework;

class Flush
{
    public function set($type, $message) {
        $_SESSION['flush'][$type][] = $message;
    }

    public function show() {
        if(array_key_exists('flush',$_SESSION)){
            return $_SESSION['flush'];
        } else {
            return array();
        }
    }
}