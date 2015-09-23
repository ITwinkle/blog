<?php

namespace Framework\Response;

class ResponseRedirect extends Response
{
    public function __construct($uri){
        header('location:'.trim($uri),true,302);
    }
}