<?php

namespace Framework\Response;

class ResponseRedirect extends Response
{
    public function __construct($uri){
        $this->setHeaders(array('location'=>'/'.trim($uri)))->setStatus('302');
    }
}