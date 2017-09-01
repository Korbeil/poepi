<?php
/**
 * Created by PhpStorm.
 * User: bleduc
 * Date: 31/08/17
 * Time: 15:10
 */

    namespace App\Poe\Interfaces;

    interface ApiAccessor
    {

        /**
         * Launch request and return object
         *
         * @param array $args
         * @return object
         */
        static function request($args = []);

        /**
         * Used to know which URL will be requested
         *
         * @param array $args
         * @return string
         */
        static function buildURL($args = []);

    }