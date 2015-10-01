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
     * insert data
     *
     * @throws \Framework\Exception\DiException
     */
    public function insert(){
        foreach ($this->getColumns() as $key) {
            $values[] = '\''.$this->$key.'\'';
        }
        Service::get('pdo')->query(
            'insert into '.static::getTable().'('.implode(',', $this->getColumns()).') values ('.implode(
                ',',
                $values).')'
        );
    }


    /**
     * select column which you need
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

    /**
     * update data
     *
     * @throws \Framework\Exception\DiException
     */
    public function update(){
        foreach ($this->getColumns() as $key) {
            $values[] = $key.' = \''.$this->$key.'\'';
        }
        Service::get('pdo')->query('update '.static::getTable().' set '.implode(',', $values)
            .' where '.static::getId().' = '.$this->id
        );
    }

    /**
     * delete data
     *
     * @throws \Framework\Exception\DiException
     */
    public function delete(){
        Service::get('pdo')->query('delete from ' . static::getTable() . ' where ' . static::getId() . ' = ' . $this->id);
    }
}