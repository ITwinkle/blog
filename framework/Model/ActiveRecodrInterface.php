<?php

namespace framework\Model;


interface ActiveRecodrInterface
{

    static function getId();
    static function getColumns();
    static function getTable();

}