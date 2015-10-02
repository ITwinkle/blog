<?php

namespace Framework\Response;

class JsonRespose extends Response
{
    /**
     * send HTTP package in json format
     */
    public function __construct($body = '', $status = 200){
        parent::__construct($body,$status);

        if(0 != count($this->headers)){
            $this->sendHeaders();
        }
        header('Content-Type: application/json');

        if('' != $body){
            echo json_encode($body);
        }else{
            echo json_encode($this->body);
        }
    }
}