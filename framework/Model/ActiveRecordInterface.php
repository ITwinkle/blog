<?php

namespace framework\Model;


interface ActiveRecordInterface
{
    static function getId();
    static function getColumns();
    static function getTable();
}