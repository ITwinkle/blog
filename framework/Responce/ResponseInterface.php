<?php

namespace Framework\Response;

interface ResponseInterface{

    /**
     * send HTTP package
     * @return mixed
     */
    function send();

    /**
     * @param array $headers - headers of HTTP package
     *
     */
    function setHeaders(array $headers);

    /**
     * send headers
     * @return mixed
     */
    function sendHeaders();

    /**
     * @param $version - HTTP protocol version
     *
     */
    function setVersion($version);

    /**
     * @param $status - HTTP package status
     *
     */

    function setStatus($status);
}