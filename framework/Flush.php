<?php

namespace Framework;

class Flush
{
    /**
     * Setter method
     *
     * @param string $type - type of message
     * @param string $message - text of message
     */
    public function set($type, $message) {
        $_SESSION['flush'][$type][] = $message;
    }

    /**
     * Output message
     *
     * @return array
     */
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