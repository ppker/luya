<?php

namespace admintests\data\fixtures;

use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'luya\admin\models\User';

    public function getData()
    {
        return [
            'user1' => [
                'id' => 1,
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'john@luya.io',
                'password' => 'nohash',
                'is_deleted' => 0,
            ],
            'user2' => [
                'id' => 2,
                'firstname' => 'Jane',
                'lastname' => 'Doe',
                'email' => 'jane@luya.io',
                'password' => 'nohash',
                'is_deleted' => 0,
            ]
        ];
    }
}
