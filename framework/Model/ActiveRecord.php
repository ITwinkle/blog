<?php

namespace framework\Model;

use framework\Di\Service;
abstract class ActiveRecord
{
    public $id;

    /**
     * return identifier
     *
     * @return int
     */
    abstract static function getId();

    /**
     *return table name
     *
     * @return string
     */
    abstract static function getTable();

    /**
     * return names of column
     *
     * @return array
     */
    abstract static function getColumns();
}