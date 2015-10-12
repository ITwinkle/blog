<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/17/14
 * Time: 12:09 PM
 */

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Model\ActiveRecordInterface;
use Framework\Security\Model\UserInterface;

class User extends ActiveRecord implements UserInterface, ActiveRecordInterface
{
    public $id;
    public $email;
    public $password;
    public $role;

    public static function getTable()
    {
        return 'users';
    }

    public static function getColumns(){
        return array('email', 'password', 'role');
    }

    public static function getId(){
        return 'id';
    }


    public function getRole()
    {
        return $this->role;
    }
}