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


    /**
     * select data which you need
     *
     * @param $col - name of column
     * @param $val - value of column
     * @return mixed
     * @throws \Framework\Exception\DiException
     */
    public static function find($col,$val){
        $pdo = Service::get('pdo')->prepare('select * from '. static::getTable(). ' where '.$col. ' = '.$val);
        $pdo->execute();
        return $pdo->fetchObject(static::class);
    }

    /**
     * insert data
     * @throws \Framework\Exception\DiException
     */
    public function save(){
        $query = 'insert into '.static::getTable().'(';
        foreach(static::getColumns() as $column) {
            $query .= $column.',';
        }
        $query = substr($query,0,-1);
        $query .= ') values (';
        foreach(static::getColumns() as $col){
            $query.= $this->$col.',';
        }
        $query = substr($query,0,-1);
        $query .= ')';
        Service::get('pdo')->query($query);
    }

    /**
     * select all column in table
     *
     * @return mixed
     * @throws \Framework\Exception\DiException
     *
     */
    public static function findAll(){
        $type = Service::get('pdo');
        $pdo = Service::get('pdo')->query('select * from ' . static::getTable());
        return $pdo->fetchAll($type::FETCH_CLASS, static::class);
    }
}