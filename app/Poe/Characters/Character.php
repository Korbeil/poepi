<?php
/**
 * Created by PhpStorm.
 * User: bleduc
 * Date: 31/08/17
 * Time: 15:31
 */

    namespace App\Poe\Characters;

    use App\Poe\Object;

    class Character extends Object
    {

        protected static $fields    = [
            'account'               => [
                'name'              => 'account',
                'type'              => 'string',
                'description'       => 'Name of the account linked to the character'
            ],
            'name'                  => [
                'name'              => 'name',
                'type'              => 'string',
                'description'       => 'Name of the character'
            ],
            'league'                => [
                'name'              => 'league',
                'type'              => 'string',
                'description'       => 'Name of the league that belongs to the character'
            ],
            'classId'               => [
                'name'              => 'classId',
                'type'              => 'integer',
                'description'       => 'ID of the class of the character'
            ],
            'ascendancyClass'       => [
                'name'              => 'ascendancyClass',
                'type'              => 'integer',
                'description'       => 'ID of the ascendancy class of the character'
            ],
            'class'                 => [
                'name'              => 'class',
                'type'              => 'string',
                'description'       => 'Class name of the character'
            ],
            'level'                 => [
                'name'              => 'level',
                'type'              => 'integer',
                'description'       => 'Level of the character'
            ]
        ];

    }