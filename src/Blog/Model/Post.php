<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/16/14
 * Time: 11:36 AM
 */

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Model\ActiveRecordInterface;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;

class Post extends ActiveRecord implements ActiveRecordInterface
{
    public $title;
    public $content;
    public $date;
    public $name;

    public static function getTable()
    {
        return 'posts';
    }

    public static function getColumns(){
        return array('title', 'content', 'date', 'name');
    }

    public static function getId(){
        return 'id';
    }

    public function getRules()
    {
        return array(
            'title'   => array(
                new NotBlank(),
                new Length(4, 100)
            ),
            'content' => array(new NotBlank())
        );
    }
}