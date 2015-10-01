<?php
/**
 * Created by PhpStorm.
 * User: ihor
 * Date: 24.09.15
 * Time: 16:38
 */

namespace Framework\Exception;


class HttpException extends \Exception
{
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}