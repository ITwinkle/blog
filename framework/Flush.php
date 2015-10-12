<?php

namespace Framework;

class Flush
{
    public function set($type, $message) {
        $_SESSION['flush'][$type][] = $message;
    }

    public function show() {
        if(array_key_exists('flush',$_SESSION)){
            $flush = $_SESSION['flush'];
            unset($_SESSION['flush']);
            return $flush;
        } else {
            return array();
        }
    }
}