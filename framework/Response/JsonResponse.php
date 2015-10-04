<?php

namespace Framework\Response;

class JsonResponse extends Response
{
    /**
     * send HTTP package in json format
     */
    public function __construct($body = '', $status = 200){
        parent::__construct($body,$status);

        $this->setHeaders(array('Content-Type' => 'application/json'));

        if('' != $body){
            $this->body = json_encode($body);
        }
    }
}