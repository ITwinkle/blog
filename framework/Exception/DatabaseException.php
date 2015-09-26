<?php

namespace Framework\Exception;


class DatabaseException
{
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}